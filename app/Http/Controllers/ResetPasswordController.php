<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Mail;
use App\Mail\MailableWithButton;

use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): InertiaResponse
    {
        return Inertia::render('Auth/ForgotPass/View', [
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $validate['email'])->firstOrFail();

        $password_token = Password::createToken($user);
        $user->remember_token = $password_token;
        $user->save();

        Mail::to($user->email)->send(
            new MailableWithButton(
                title: 'Forgot your password, ' . $user->name . '?',
                body: 'There has been a request to reset your password. Click on the button below to change your password. If you did not make this request, please ignore this e-mail.',
                url: route('reset.password', [
                    'token' => $password_token,
                    'email' => $user->email
                ]),
                buttonText: 'Reset Password'
            )
        );
        
        return back()->with('status', 'If your account exists, we will send you an email with a reset link.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        return Inertia::render('Auth/ResetPass/View', [
            'email' => $request->email,
            'token' => $request->route('token'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PasswordReset) {
            return to_route('login')->with('status', __($status));
        }

        else return back()->with('status', 'There was a problem resetting your password.');
    }
}

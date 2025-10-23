<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>

        body {
            margin:0; 
            padding:0; 
            font-family: Arial, sans-serif; 
            background-color:#e7e5e4;
        }
        .email-header {
            margin-bottom:1rem; 
            max-width: 600px; 
            width: 100%;
            border: 1px solid #fff; 
            border-radius: .25rem; 
            background-color: #ffffff; 
        }

        .email-container {
            border: 1px solid #fff; 
            border-radius: .25rem; 
            background-color: #ffffff; 
            max-width: 600px; 
        }

        .email-content {
            color: #4338ca; 
            font-size: 16px; 
            line-height: 24px; 
            padding: 2rem; 
            padding-top: 1rem; 
            padding-bottom: 2rem;
        }

        h3 {
            padding: 1rem;
            margin: 0; 
            color: #4338ca;
        }

        button {   
            background-color:#6366f1; 
            border: 1px solid #6366f1;
            color:#ffffff; 
            border-radius:0.25rem; 
            padding:12px 24px; 
            text-decoration:none; 
            font-weight:bold;
            margin-bottom:2rem;
        }

        @media only screen and (max-width: 620px) {
            .email-container {
                width: 100% !important;
                padding: 0 !important;
            }

            .email-content {
                padding: 1rem !important;
            }

            button {
                display: block !important;
                width: 100% !important;
                box-sizing: border-box;
                text-align: center !important;
            }

            .logo {
                width: 96px !important;
                display: block; 
                max-width: 100%; 
                height: auto;
            }

            pre {
                white-space: pre-wrap;
                word-break: break-word;
            }
        }
    </style>
</head>
<body>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center">
                <img 
                    src="{{ asset('images/logo.svg') }}" 
                    alt="Logo" 
                    width="128" 
                    class="logo" 
                />
                
                <table 
                    border="0" 
                    cellpadding="0" 
                    cellspacing="0" 
                    width="600" 
                    class="email-header"
                >
                    <tr>
                        <td align="center">
                            <h3>{{ $title }}</h3>
                        </td>
                    </tr>
                </table>

                <table 
                    class="email-container" 
                    border="0" 
                    cellpadding="0" 
                    cellspacing="0" 
                    width="600"
                >

                    <tr >
                        <td class="email-content">
                            <p>{{ $body }}</p>
                        </td>
                    </tr>

                    <tr>

                        <td align="center">
                            <button href="{{ $url }}">
                               {{ $buttonText }}
                            </button>
                        </td>     
                    </tr>

                </table>

            </td>
        </tr>
    </table>
</body>
</html>
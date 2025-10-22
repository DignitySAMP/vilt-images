# Image Uploader (VILT Stack)

A simple image uploading platform built with the **VILT** stack. Open source and designed as a showcase of my current full-stack skills.

You can access the demo here `url_here` and authenticate using `test@example.com / test@example.com`.

> The demo is automatically wiped every two hours. Any data uploaded is per-user to avoid abuse. The code for this is also included in the `demo` branch.

---

## 📦 Stack

- **Laravel** 12.x  
- **Inertia.js** 2.x  
- **Vue** 3.x (Composition API)  
- **Tailwind CSS** 4.x  


## 📦 Dependencies

- **Intervention Image** – Thumbnail generation  
- **Spatie Image Optimizer** – Image optimization  
- **Toastify (Vue)** – Toast notifications  
- **Ziggy** – Laravel route access in Vue  


## 🔧 Setup

Install dependencies:

```bash
npm install && composer install
cp .env.example .env
php artisan key:generate
```

Run database setup:

```bash
php artisan migrate # type 'yes' when prompted to create database.sqlite
php artisan db:seed # seeds mock data and test user
```

Link storage:
```bash
php artisan storage:link
```

## ✨ Features

### Authentication
 - Users can register or login, based on the default Laravel user class
 - Users can edit their profile (name, email, password)
 - Users can delete their account (deletes all associated relationships, i.e. image, album, ...)

### Images
- Upload images via drag & drop  
- Add metadata (name, description) and select album during upload  
- Thumbnails are automatically generated with Intervention post upload
- Images are automatically optimized with Spatie's imageOptimizer post upload
- Storage per user, per date. Filenames use `Str::uuid()` to avoid overwrites.
- Ability to sort (most recent => oldest => largest size => smallest size) images
- Ability to filter (by author => title => description) images
- Similar images (comparing author, title, description, album) are shown when viewing a single image

### Albums
- Serves as a parent category for images
- Can be assigned during image upload
- Ability to sort (most recent => oldest => most images => least images) albums
- Ability to filter (by author => title => description) albums
- Migrations set to cascade images if albums get deleted

### Privacy
 - Ability to make images and albums 'private' or 'public'
 - Uses policies and guard (+ a `->visible()` scope util)
 - Images automatically inherit parent album privacy setting
 - Collections are built with the privacy setting in mind

### UX / UI:
  - Built entirely using Tailwind 4
  - Entirely responsive (mobile, tablet, desktop)
  - Dark mode according to latest Tailwind 4 standards
  - Reusable form components `InputButton, InputText, InputCheck`
  - Reusable icons (pass them as a property or import normally)

### Unit and feature tests
  - Tests model relationships
  - Tests scopes and private images/albums, 
  - Tests image accesors (image url, thumbnail url, file_size)
  - Tests user authorization (guest vs. authenticated)
  - Tests image authorization (image and album privacy rules / privacy inheritance)







## todo
  - add forgot your password page
  - make components for select, checkboxes
    - make search partials use the custom inputtext component
    - add Inertia <head> seo, meta and titles in each page (app_name | page_title)
    - add favicon (take applogo icon, change to indigo-500, convert to favicon)
  - add toasts using toastify
  - move auth login/register/profile into it's own Auth/ folder with proper folder and pages

  - implement demo mode
    - https://github.com/inertiajs/pingcrm/blob/master/app/Http/Controllers/UsersController.php#L83
    - protect demo users and demo images / albums
    - automatically wipe 'dirty' content after 1 hour of inactivity
    - only show uploads to the user who uploaded them
      - make a config setting for this (protect_demo_application)
      
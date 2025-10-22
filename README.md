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

- Upload images via drag & drop  
  - Add metadata and select album before upload  
  - Auto-thumbnail + image optimization  

- Public / private albums and images
  - Privacy inherited from album  

- Manage or create albums and assign images  

- Sort & filter (by author, title, description)  

- Similar images shown on image view  

- Basic auth (register/login) and profile management

- Delete owned images, albums or profiles

- UX / UI:
  - Entirely responsive (mobile, tablet, desktop)
  - Dark mode according to latest Tailwind 4 standards
  - Reusable form components `InputButton, InputText, InputCheck`
  - Reusable icons (pass them as a property or import normally)










## todo
  - add forgot your password page
  - make components for select, checkboxes
  - add toasts using toastify
  - move auth login/register/profile into it's own Auth/ folder with proper folder and pages

  - implement demo mode
    - https://github.com/inertiajs/pingcrm/blob/master/app/Http/Controllers/UsersController.php#L83
    - protect demo users and demo images / albums
    - automatically wipe 'dirty' content after 1 hour of inactivity
    - only show uploads to the user who uploaded them
      - make a config setting for this (protect_demo_application)
      
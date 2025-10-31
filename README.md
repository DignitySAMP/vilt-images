# Image Uploader

A simple image uploading platform built with the **VILT** stack. Open source and designed as a showcase of my current full-stack skills as well as provide a demo for using the stack.

> If you're interesting in developing an application using VILT, check out my [vilt stack starter kit](https://github.com/DignitySAMP/vilt-stack).


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
- **Ziggy.js** – Laravel route access in Vue  


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


## ✨ Screenshots

<details>
  <summary> 🖼️ Click to view screenshots</summary>
  <br>
  <p align="center">
    <img src=".screenshots/screencapture-127-0-0-1-8000-image-create-2025-10-31-15_15_21.png" width="35%" />
    <img src=".screenshots/email.png" width="21.25%" />
  </p>

  <p align="center">
    <img src=".screenshots/screencapture-127-0-0-1-8000-login-2025-10-31-15_08_32.png" width="35%" />
    <img src=".screenshots/screencapture-127-0-0-1-8000-register-2025-10-31-15_08_39.png" width="35%" />
  </p>
  <p align="center">
    <img src=".screenshots/screencapture-127-0-0-1-8000-2025-10-31-15_07_25.png" width="35%" />
    <img src=".screenshots/screencapture-127-0-0-1-8000-2025-10-31-15_15_39.png" width="35%" />
  </p>
  <p align="center">
    <img src=".screenshots/screencapture-127-0-0-1-8000-albums-2025-10-31-15_08_04.png" width="35%" />
    <img src=".screenshots/screencapture-127-0-0-1-8000-albums-2025-10-31-15_13_26.png" width="35%" />
  </p>
  <p align="center">
    <img src=".screenshots/screencapture-127-0-0-1-8000-image-11-edit-2025-10-31-15_13_46.png" width="35%" />
    <img src=".screenshots/screencapture-127-0-0-1-8000-album-2-edit-2025-10-31-15_13_34.png" width="35%" />
    </p>
  <p align="center">
    <img src=".screenshots/screencapture-127-0-0-1-8000-profile-2025-10-31-15_13_01.png" width="35%" />
    <img src=".screenshots/screencapture-127-0-0-1-8000-image-9-2025-10-31-15_07_44.png" width="35%" />
  </p>
  <p align="center">
    <img src=".screenshots/screencapture-127-0-0-1-8000-image-11-edit-2025-10-31-15_13_59.png" width="35%" />
    <img src=".screenshots/screencapture-127-0-0-1-8000-profile-2025-10-31-15_15_54.png" width="35%" />
  </p>
</details>


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
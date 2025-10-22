##


This project is a base implementation of an image uploading platform. It is a reflection of my current prowess using the VILT stack.

## Setup

Stack installation:
```
  npm install && composer install

  cp .env.example .env
  php artisan key:generate
```

Database setup:
```
  php artisan migrate
    -> 'yes' when prompted to make database.sqlite

  php artisan db:seed
    -> generates mock data and mock user
```

Symlink `storage/public` with `public/storage`
```
  php artisan storage:link
```

Test user (with base images / albums):
`
test@example.com:test@example.com
`

## Stack
 - Laravel 12.x
 - Vue 3.x (Composition API)
 - Inertia 2.x
 - Tailwind 4.x

## Dependencies
 - Invervention (to generate thumbnails)
 - Spatie's Image Optimizer (to optimize images post upload)
 - Toastify for Vue (show toasts across the application)
 - Ziggy.js (laravel routes in vue)


## Features

 - Component and partial driven UX (cross-page components in `/component/`, per page components in `/page/partials/`)
 - Basic responsiveness (mobile first design principles) and darkmode
 - Multi drag and drop image uploading 
   - Preselect the album and configure metadata during upload
   - Images are optimized when uploaded and thumbnails are automatically created when uploaded
 - Create, browse through manage, and assign albums to images. 
 - Public and private images and albums using policies and guards.
 - Images inherit their privacy from the album they belong to.
 - Sort images or albums (oldest => newest or smallest => largest)
 - Filter images or albums (author => title => description)
 - Similar images (determined by title, description, album or author) are shown when viewing an image
 - Basic authentication (register and login) with basic throttle protection
 - Profile management (change name, email, password) or delete profile (purges all image data)


## todo
  - add forgot your password page
  - make components for buttons, select, checkboxes
  - add toasts using toastify
  - move auth login/register/profile into it's own Auth/ folder with proper folder and pages

  - implement demo mode
    - https://github.com/inertiajs/pingcrm/blob/master/app/Http/Controllers/UsersController.php#L83
    - protect demo users and demo images / albums
    - automatically wipe 'dirty' content after 1 hour of inactivity
    - only show uploads to the user who uploaded them
      - make a config setting for this (protect_demo_application)
      
  - template
    - dark mode
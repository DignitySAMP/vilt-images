##

`
  php artisan storage:link
`

## todo
  - add forgot your password page
  
  - implement demo mode
    - https://github.com/inertiajs/pingcrm/blob/master/app/Http/Controllers/UsersController.php#L83
    - protect demo users and demo images / albums
    - automatically wipe 'dirty' content after 1 hour of inactivity
    - only show uploads to the user who uploaded them
      - make a config setting for this (protect_demo_application)
      
  - template
    - dark mode
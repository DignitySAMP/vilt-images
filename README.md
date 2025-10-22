##



`
  php artisan storage:link
`



## todo
  - view your albums link to all albums

  - add option for albums to be made private on creation

  - add forgot your password page

  - add proper filtering on index and profile page
  - add profile editing and deleting
    - deleting purges all images
  - add filter component to albums

  - properly test filters using debugbar 
    -> avoid n+1 and other inefficient collections
        -> implement resources if necessary

  - implement demo mode
    - https://github.com/inertiajs/pingcrm/blob/master/app/Http/Controllers/UsersController.php#L83
    - protect demo users and demo images / albums
    - automatically wipe 'dirty' content after 1 hour of inactivity
    - only show uploads to the user who uploaded them
      - make a config setting for this (protect_demo_application)

  - image tags?
    - can be used for better 'similar' images?
    - show as little cards in the design?

  - template
    - ux friendliness, cta best practices, ...
    - dark mode
    - responsivity
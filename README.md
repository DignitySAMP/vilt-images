##



`
  php artisan storage:link
`



## todo
  - view your albums link to all albums
  - add an intuitive way to declare the desired image name/description for every (multiple) upload(s)

  - add image public/private switch (to see if people can view it or not)
    - add a proper page for this (i.e. 'this image is private')
    - make it so only those with the link can see it (signed URLs)

  - add forgot your password page

  - add proper filtering on index and profile page
  - add profile editing and deleting
    - deleting purges all images

  - ability to make albums private or public
  - add filter component to albums

  - make filters work
  - properly test filters using debugbar 
    -> avoid n+1 and other inefficient collections
        -> implement resources if necessary

  - image tags?
    - can be used for better 'similar' images?
    - show as little cards in the design?

  - implement demo mode
    - https://github.com/inertiajs/pingcrm/blob/master/app/Http/Controllers/UsersController.php#L83
    - protect demo users and demo images / albums
    - automatically wipe 'dirty' content after 1 hour of inactivity
    - only show uploads to the user who uploaded them
      - make a config setting for this (protect_demo_application)

  - template
    - dark mode
    - responsivity
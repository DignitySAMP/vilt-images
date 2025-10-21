##



`
  php artisan storage:link
`



## todo
  - add image names and descriptions
    - render this in a way that doesnt break the design, perhaps only show description on individual /show/ page.
    - 'description' will become 'name'. 
  - add a way to edit or delete images if you own them
    - through profile or on the 'show' page

  - add placeholder images (10 or so) and spread them over 2-3 users.
    - will be useful for testing some upcoming functionality

  - add image public/private switch (to see if people can view it or not)
    - add a proper page for this (i.e. 'this image is private')
    - make it so only those with the link can see it (signed URLs)

  - add proper filtering on index and profile page
  - add profile editing and deleting
    - deleting purges all images

  - add image albums support / CRUD
    - ability to make albums private or public
    - ability to see all images in a specific album
    - add a component 'card' for albums, if you click on it, you get taken to the album

  - image tags?
    - can be used for better 'similar' images?
    - show as little cards in the design?


  - template
    - dark mode
    - responsivity
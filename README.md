User authentication with Laravel
=================================

Configuration
--------------
* The files /app/config/local/database.php (for local development) &  /app/config/database.php should contain the neccessary db credentials.

* Depending on your development mode, the file /bootstrap/start.php needs to be changed accordingly. In particular the line: 
```
    $env = $app->detectEnvironment(array(
        'local' => array('your-machine-name'),
    ));
```
Should contain the appropriate environment variables.To find out your machine name simply type `hostname` in the command line.

* After the first two steps are completed you can run the database migrations: `php artisan migrate`. This will run all outstanding migrations.

* The file /app/congif/mail.php also needs to be filled out with the proper credentials of your smtp host.

References
----------
This code was developed following the laravel tutorial: [![Laravel Authentication Tutorial](http://img.youtube.com/vi/-QjzzLVsUJY/0.jpg)](http://www.youtube.com/watch?v=-QjzzLVsUJY&list=PLfdtiltiRHWGf_XXdKn60f8h9jjn_9QDp)
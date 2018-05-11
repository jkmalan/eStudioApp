eStudio Scheduler App
====

This application is designed to import, query, and display class data from a database to assist technicians in the field to find and perform maintenance and other tasks on available rooms across campuses.

It consists of a backend focusing mainly in PHP and SQL, and a frontend focusing mainly in PHP, Javascript, and Bootstrap. It implements multiple frameworks and open source Bootstrap plugins to function.

Plugins & Frameworks
----

- JQuery v3.2.1
  - Popper v1.12.9
- Bootstrap v3.3.7
- [Bootstrap Calendar v0.2.5](https://github.com/Serhioromano/bootstrap-calendar)
  - Underscore v1.8.3
- [FontAwesome v4.7.0](https://fontawesome.com/v4.7.0/)

Goals & Objectives
----

- Search by Instructor (First/Last Name)
- Redesign the UI
  - search_rooms.php
    - Fix week view
    - Fix day view
  - search_times.php
    - Cleanup display of results
  - search_courses.php
    - Cleanup display of results
- Administration Page
  - File upload improvements (Bypass timeout and/or better upload process)
  - Authentication required (Security implementations sitewide)
- Backend
  - Smarter use of AJAX and PHP functions
  - Refined SQL to import CSV

Setup & Deployment
----

Dependencies
- Apache 2.4.23 (Or any version of Apache 2.x.x)
- MySQL 5.7.14
- PHP 5.6.25 (Must use PHP 5.6.x, PHP 7 will not work)

The site is version controlled through git, so having a git client or git compatible IDE is helpful for tracking and handling changes.

1. Setup the Apache/PHP/MySQL servers on the computer or server of choice. Some settings will have to be adjusted and a database will have to be created before one can proceed with the setup.
    1. In the php.ini file, two settings must be adjusted to accommodate larger sized files through the Administration page.
        ```
        ; Maximum size of POST data that PHP will accept.
        ; Its value may be 0 to disable the limit. It is ignored if POST data reading
        ; is disabled through enable_post_data_reading.
        ; http://php.net/post-max-size
        post_max_size = 8M
        
        ...
        
        ; Maximum allowed size for uploaded files.
        ; http://php.net/upload-max-filesize
        upload_max_filesize = 2M
        ```
        By default, both settings will be low, but they should be adjusted to a value more reasonable for a large data file, such as 50M (50 megabytes), thought be warned, large files take longer to process.
    2. Unpack the project files into the root directory of the web server. Files of interest for getting the program setup should be 'php/settings/config.php' and '/php/initialize.php'. In the 'initialize.php' file, change the value in the BASE_URL global variable to reflect the public domain of your server.
       ```
       /* The base url of the site */
       define("BASE_URL", 'http://127.0.0.1/'); // Change this to match the base URL of the site
       /* EXAMPLE: define("BASE_URL", 'http://estudio.com/'); */
       ```
       While here, also verify that the line at the bottom which should be commented out, is still commented out. This is used for manual population of the database in the event of testing or skipping the Administration page. It will run on every page's load, so once it has been loaded, please remember to recomment the line of code!
       ```
       // DBHandler::populateDB(ROOT_DIR . 'data/room_201810_test.csv'); // Populates the database manually from a properly formatted CSV
       // >>>> IF USED FOR IMPORT, PLEASE RECOMMENT LINE AFTERWARDS <<<<
       ```
    3. The MySQL database should also be created at this time if not yet done. There are two different paths that can be taken, the first is to setup an empty database and let the program populate it with file data. The other option is to provide an existing database with all the appropriate data pre-loaded.
       1. Creating a MySQL Database (CLI)
       
          First log into the MySQL database, which should by default be username 'root' with a blank password.
          ```
          > mysql -u root -p
          > Enter password:
          ```
          Once it has been logged into, a database must be created and then a user must be created and assigned privileges to use that database.
          ```
          mysql> CREATE DATABASE sju_database;
          mysql> CREATE USER 'sju_admin'@'localhost' IDENTIFIED BY 'password';
          mysql> GRANT ALL PRIVILEGES ON sju_database.* TO 'sju_admin'@'localhost';
          mysql> FLUSH PRIVILEGES;
          ```
          This will create the database, the user, and provide the user privileges to manipulate the database. At this point, the application will automatically generate tables, insert data, and select data as dictated by the application.
       2. Connecting to a MySQL Database (config.php)
       
          Creating a database may not be necessary if a database has been provided with pre-loaded data. In that case, so long as the database provided is on the same machine as the web server or has an exposed port on the network/internet, it can be accessed simply by changing settings. Change the following settings in the config.php as necessary to point towards the desired database.
          ```
          /**
           * @var string The database host address
           */
          public static $DB_HOST = "127.0.0.1";
      
          /**
           * @var int The database host port
           */
          public static $DB_PORT = 3306;
      
          /**
           * @var string The database name
           */
          public static $DB_NAME = "sju_database";
      
          /**
           * @var string The database username to connect with
           */
          public static $DB_USER = "sju_admin";
      
          /**
           * @var string The database password to connect with
           */
          public static $DB_PASS = "sju_adminpass";
          ```
          Replace '127.0.0.1' with your server address, and '3306' with your server port if different. Replace 'sju_database', 'sju_admin', and 'sju_adminpass' with relevant values if necessary as well. This should be all the setup necessary for the application to reach and connect to the database if all is set properly server-side.
    4. 
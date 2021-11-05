<!--
        About: CREATE Movies
        Author: Mohit Verma
        Date: 29-10-2021
		Student_id: 0777694
     -->
<?php
//Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'mverma');     // your scweb username
define('DB_PASSWORD', 'plbnjplbnjz3q4rz3q4r');  // See blackboard for 20-char password
define('DB_NAME', 'mvermaauction');   // username followed by lowercase db

//Add your name below
define("CONFIG_ADMIN", "Mohit Verma");
define("CONGIF_ADMINEMAIL", "MV47@stclairconnect.ca");

//Add the location of your forums below
define("CONFIG_URL", "https://mverma.scweb.ca/auction");

//Add your blog name below
define("CONFIG_AUCTIONNAME", "Web Guys Online Auction");

//The Currency used in Auction
define("CONFIG_CURRENCY", "$");

//Set TimeZone
date_default_timezone_set("America/Toronto");
//Log Location
define("LOG_LOCATION", "../logs/app.log");

//File Ulpoad Location
define("LOG_UPLOADLOC", "imgs/");

// Add blog name
//$config_blogname = "The Best Blog in the Universe";
//$config_author = "Mohit Verma";
?>
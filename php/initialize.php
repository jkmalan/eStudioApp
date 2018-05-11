<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

/* The root directory of the site */
define("ROOT_DIR", filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . "/"); // This is the root directory of the webserver

/* The base url of the site */
define("BASE_URL", 'http://127.0.0.1/'); // Change this to match the base URL of the site

require_once 'settings/config.php';
require_once 'database/database.php';
require_once 'database/dbqueries.php';
require_once 'database/dbhandler.php';
require_once 'functions.php';

Database::connect(); // Connects to the specified database in the configuration
DBHandler::prepareDB(); // Creates the tables necessary for the database

// DBHandler::populateDB(ROOT_DIR . 'data/room_201810_test.csv'); // Populates the database manually from a properly formatted CSV
// >>>> IF USED FOR IMPORT, PLEASE RECOMMENT LINE AFTERWARDS <<<<


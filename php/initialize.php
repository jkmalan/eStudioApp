<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

/* The root directory of the site */
define("ROOT_DIR", filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . "/");

/* The base url of the site */
define("BASE_URL", 'http://127.0.0.1/');

require_once 'settings/config.php';
require_once 'database/dbqueries.php';
require_once 'database/database.php';
require_once 'database/dbhandler.php';

Database::connect();
DBHandler::import(null);


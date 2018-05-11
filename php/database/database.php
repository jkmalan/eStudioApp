<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

/**
 * Provides access to the database with a PDO database
 *
 * @author jkmalan (aka John Malandrakis)
 */
class Database {

    /**
     * @var PDO database object
     */
    private static $PDO;

    /**
     * Opens the connection to the database
     */
    public static function connect() {
        $dsn = "mysql:host=" . Config::$DB_HOST
               . ";port=" . Config::$DB_PORT
               . ";dbname=" . Config::$DB_NAME
               . ";charset=" . Config::$DB_CHAR;
        try {
            self::$PDO = new PDO($dsn, Config::$DB_USER, Config::$DB_PASS);
            self::$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Display SQL exceptions to the web page
            self::$PDO->setAttribute(PDO::MYSQL_ATTR_LOCAL_INFILE, true); // Allows use of MySQL 'LOAD DATA LOCAL INFILE' for mass data import
        } catch (PDOException $ex) {
            exit("Database failed to connect: " . $ex->getMessage());
        }
    }

    /**
     * Closes the connection to the database
     */
    public static function disconnect() {
        self::$PDO = null;
    }

    /**
     * Returns the database object
     *
     * @return PDO database object
     */
    public static function getDatabase() {
        return self::$PDO;
    }

}
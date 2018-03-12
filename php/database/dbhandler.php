<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

/**
 * Handles input and output of data into the database
 */
class DBHandler {

    /**
     * Imports a CSV into the SQL database
     *
     * @param $file
     */
    public static function import($file) {
        $db = Database::getDatabase();
        foreach (DBQueries::$CREATE_TABLES as $query) {
            $createTable = $db->exec($query);
            if ($createTable) {
                echo "Table created!";
            }
        }

        /* Temporarily disable file read in
        if (($data = fopen($file, "r")) !== FALSE) {
            $header = fgetcsv($data, 0, ",");
            while (($row = fgetcsv($data, 0, ",")) !== FALSE) {
                self::insertEvent(self::bindHeader($header, $row));
            }
        }
        */
    }

    /*
     * Binds column headers to row values as a key-value
     *
     * @param $header
     * @param $row
     * @return array
     */
    private static function bindHeader($header, $row) {
        $fieldMap = array();
        for ($i = 0; $i < count($header); $i++) {
            $fieldMap[$header[$i]] = $row[$i];
        }
        return $fieldMap;
    }

    /*
     * Inserts an event into the database
     *
     * @param $fieldMap An array of key-value pairs
     */
    private static function insertEvent($fieldMap) {

    }

    public static function selectCampuses() {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $results = $db->query(DBQueries::$SELECT_CAMPUSES);
        } catch (PDOException $ex) {
            exit("Failed to query data: " . $ex->getMessage());
        }

        return $results;
    }

    public static function selectBuildings($camp) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_BUILDINGS);
            $stmt->bindParam(1,$camp);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit("Failed to query data: " . $ex->getMessage());
        }

        return $results;
    }

    public static function selectRooms($bldg) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_ROOMS);
            $stmt->bindParam(1,$bldg);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit("Failed to query data: " . $ex->getMessage());
        }

        return $results;
    }

    public static function selectProfessors() {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $results = $db->query(DBQueries::$SELECT_INSTRUCTORS);
        } catch (PDOException $ex) {
            exit("Failed to query data: " . $ex->getMessage());
        }

        return $results;
    }

    /**
     * Retrieves data using a specified room
     *
     * @param $campus
     * @param $building
     * @param $room
     */
    public static function selectRoom($campus, $building, $room) {
        $db = Database::getDatabase();
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_ROOM);
            $stmt->bindParam(1, $campus);
            $stmt->bindParam(2, $building);
            $stmt->bindParam(3, $room);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit("Failed to insert or update row: " . $ex->getMessage());
        }
    }

    /**
     * Retrieves data using a specified course
     *
     * @param $subject
     * @param $course
     */
    public static function selectCourse($subject, $course) {
        $db = Database::getDatabase();
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_COURSE);
            $stmt->bindParam(1, $subject);
            $stmt->bindParam(2, $course);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit("Failed to insert or update row: " . $ex->getMessage());
        }
    }

    /**
     * Retrieves data using a specified instructor
     *
     * @param $xid
     */
    public static function selectInstructor($xid) {
        $db = Database::getDatabase();
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_ROOM);
            $stmt->bindParam(1, $xid);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit("Failed to insert or update row: " . $ex->getMessage());
        }
    }

}
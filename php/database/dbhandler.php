<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

/**
 * Handles input and output of data into the database
 *
 * @author jkmalan (aka John Malandrakis)
 */
class DBHandler {

    /**
     * Creates all necessary tables if they do not already exist
     */
    public static function prepareDB() {
        $db = Database::getDatabase();
        try {
            foreach (DBQueries::$CREATE_TABLES as $table) {
                $db->exec($table);
            }
        } catch (PDOException $ex) {
            exit($ex->getTraceAsString() . "<br>" . $ex->getMessage());
        }
    }

    /**
     * Adds events to the database given a CSV data file
     *
     * @param $file
     */
    public static function populateDB($file) {
        if (($data = fopen($file, "r")) !== FALSE) {
            $header = fgetcsv($data, 0, ",");
            while (($row =fgetcsv($data, 0, ",")) !== FALSE) {
                self::insertEventByRow($header, $row);
            }
        }
    }

    /*
     * Adds a single event and relevant data to the database
     *
     * @param $header Requires a header containing the column fields
     * @param $row Requires an array containing the matching values
     */
    private static function insertEventByRow($header, $row) {
        $map = array();
        for ($i = 0; $i < count($header); $i++) {
            $map[$header[$i]] = $row[$i];
        }

        /*
         * Field names correspond to the column headers in the CSV
         * Some values can be null or empty: rooms.room_name, instructors.mname, events.xid
         */
        $db = Database::getDatabase();
        try {

            /* Inserts a location into the table by campus, building, and room
             * On collision, it will update existing information with the new information
             */
            $stmtRoom = $db->prepare(DBQueries::$INSERT_ROOM);
            $stmtRoom->bindParam(1, $map[Config::$DATA_MAP['camp_code']]);
            $stmtRoom->bindParam(2, $map[Config::$DATA_MAP['camp_name']]);
            $stmtRoom->bindParam(3, $map[Config::$DATA_MAP['bldg_code']]);
            $stmtRoom->bindParam(4, $map[Config::$DATA_MAP['bldg_name']]);
            $stmtRoom->bindParam(5, $map[Config::$DATA_MAP['room_code']]);
            $room_name = '';
            if (isset($map[Config::$DATA_MAP['room_name']]) && $map[Config::$DATA_MAP['room_name']] != NULL) {
                $room_name = $map[Config::$DATA_MAP['room_name']];
            }
            $stmtRoom->bindParam(6, $room_name);
            $stmtRoom->execute();

            /* Inserts a course into the table by subject and course
             * On collision, it will update existing information with the new information
             */
            $stmtCourse = $db->prepare(DBQueries::$INSERT_COURSE);
            $stmtCourse->bindParam(1, $map[Config::$DATA_MAP['subj_code']]);
            $stmtCourse->bindParam(2, $map[Config::$DATA_MAP['subj_name']]);
            $stmtCourse->bindParam(3, $map[Config::$DATA_MAP['crse_code']]);
            $stmtCourse->bindParam(4, $map[Config::$DATA_MAP['crse_name']]);
            $stmtCourse->execute();

            /* Inserts an instructor into the table by xid and name
             * On collision, it will update existing information with the new information
             */
            $stmtInstructor = $db->prepare(DBQueries::$INSERT_INSTRUCTOR);
            $stmtInstructor->bindParam(1, $map[Config::$DATA_MAP['xid']]);
            $stmtInstructor->bindParam(2, $map[Config::$DATA_MAP['fname']]);
            $mname = '';
            if (isset($map[Config::$DATA_MAP['mname']]) && $map[Config::$DATA_MAP['mname']]!= NULL) {
                $mname = $map[Config::$DATA_MAP['mname']];
            }
            $stmtInstructor->bindParam(3, $mname);
            $stmtInstructor->bindParam(4, $map[Config::$DATA_MAP['lname']]);
            $stmtInstructor->execute();

            /* Inserts an event into the table
             * This should not collide, each has a unique compound key of term, CRN, and time
             */
            $stmtEvent = $db->prepare(DBQueries::$INSERT_EVENT);
            $stmtEvent->bindParam(1, $map[Config::$DATA_MAP['term_code']]);
            $stmtEvent->bindParam(2, $map[Config::$DATA_MAP['crn_key']]);
            $stmtEvent->bindParam(3, $map[Config::$DATA_MAP['time_start']]);
            $stmtEvent->bindParam(4, $map[Config::$DATA_MAP['time_end']]);
            $stmtEvent->bindParam(5, $map[Config::$DATA_MAP['title']]);
            $stmtEvent->bindParam(6, $map[Config::$DATA_MAP['camp_code']]);
            $stmtEvent->bindParam(7, $map[Config::$DATA_MAP['bldg_code']]);
            $stmtEvent->bindParam(8, $map[Config::$DATA_MAP['room_code']]);
            $stmtEvent->bindParam(9, $map[Config::$DATA_MAP['subj_code']]);
            $stmtEvent->bindParam(10, $map[Config::$DATA_MAP['crse_code']]);
            $xid = '';
            if (isset($map[Config::$DATA_MAP['xid']]) && $map[Config::$DATA_MAP['xid']] != NULL) {
                $xid = $map[Config::$DATA_MAP['xid']];
            }
            $stmtEvent->bindParam(11, $xid);
            $stmtEvent->execute();

        } catch (PDOException $ex) {
            exit($ex->getTraceAsString() . "<br>" . $ex->getMessage());
        }
    }

    /**
     * Retrieves a list of campuses with a code and name
     *
     * @return array|null A list of campuses
     */
    public static function getCampuses() {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_CAMPUSES);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit($ex->getTraceAsString() . "<br>" . $ex->getMessage());
        }

        return $results;
    }

    /**
     * Retrieves a list of buildings with a code and name
     *
     * @param $camp_code
     * @return array|null A list of buildings
     */
    public static function getBuildings($camp_code) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_BUILDINGS);
            $stmt->bindParam(1, $camp_code);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit($ex->getTraceAsString() . "<br>" . $ex->getMessage());
        }

        return $results;
    }

    /**
     * Retrieves a list of rooms with a code and name
     *
     * @param $bldg_code
     * @return array|null A list of rooms
     */
    public static function getRooms($bldg_code) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_ROOMS);
            $stmt->bindParam(1, $bldg_code);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit($ex->getTraceAsString() . "<br>" . $ex->getMessage());
        }

        return $results;
    }

    /**
     * Retrieves a list of subjects with a code and name
     *
     * @return array|null A list of subjects
     */
    public static function getSubjects() {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_SUBJECTS);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit($ex->getTraceAsString() . "<br>" . $ex->getMessage());
        }

        return $results;
    }

    /**
     * Retrieves a list of courses with a code and name
     *
     * @param $subj_code
     * @return array|null A list of courses
     */
    public static function getCourses($subj_code) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_COURSES);
            $stmt->bindParam(1, $subj_code);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit($ex->getTraceAsString() . "<br>" . $ex->getMessage());
        }

        return $results;
    }

    /**
     * Retrieves a list of instructors with a code and name
     *
     * @return array|null A list of instructors
     */
    public static function getInstructors() {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_INSTRUCTORS);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit($ex->getTraceAsString() . "<br>" . $ex->getMessage());
        }

        return $results;
    }

    /**
     * Searches for events given a specified range of time
     * If missing an end time, will search without and end point
     *
     * @param $time_start
     * @param $time_end
     * @return array|null A list of events
     */
    public static function searchEventsByTime($time_start, $time_end = '') {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_EVENTS_TIMES);
            $stmt->bindParam(1, $time_start);
            $stmt->bindParam(2,$time_end);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit($ex->getTraceAsString() . "<br>" . $ex->getMessage());
        }

        return $results;
    }

    /**
     * Searches for events given a specified room
     * Requires a campus, building, and room to be provided
     *
     * @param $camp_code
     * @param $bldg_code
     * @param $room_code
     * @return array|null A list of events
     */
    public static function searchEventsByRoom($camp_code, $bldg_code, $room_code) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_EVENTS_ROOMS);
            $stmt->bindParam(1, $camp_code);
            $stmt->bindParam(2, $bldg_code);
            $stmt->bindParam(3, $room_code);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit($ex->getTraceAsString() . "<br>" . $ex->getMessage());
        }

        return $results;
    }

    /**
     * Searches for events given a specified term and CRN
     * Requires a term code and CRN to be provided
     *
     * @param $term_code
     * @param $crn_key
     * @return array|null A list of events
     */
    public static function searchEventsByCRN($term_code, $crn_key) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_EVENTS_CRNS);
            $stmt->bindParam(1, $term_code);
            $stmt->bindParam(2, $crn_key);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit($ex->getTraceAsString() . "<br>" . $ex->getMessage());
        }

        return $results;
    }

}
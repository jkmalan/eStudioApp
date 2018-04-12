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

    public static function searchRoomByTime($date, $time_start, $time_end = NULL) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SEARCH_ROOMBYTIME);
            $stmt->bindParam(1, $date);
            $stmt->bindParam(2, $time_start);
            $stmt->bindParam(3,$time_end);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {

        }

        return $results;
    }

    public static function searchRoomByCourse($subject, $course) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SEARCH_ROOMBYCOURSE);
            $stmt->bindParam(1, $subject);
            $stmt->bindParam(2, $course);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {

        }

        return $results;
    }

    public static function searchRoomsByInstructor($instructor) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SEARCH_ROOMBYINSTRUCTOR);
            $stmt->bindParam(1, $instructor);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {

        }

        return $results;
    }

    public static function searchTimeByRoom($campus, $building, $room) {

    }

    public static function searchTimeByCourse($subject, $course) {

    }

    public static function searchTimeByInstructor($instructor) {

    }

    public static function searchRooms($date, $time) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SEARCH_ROOMS_BY_TIME);
            $stmt->bindParam(1, $time);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit("Failed to query data: " . $ex->getMessage());
        }

        return $results;
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

    public static function selectSubjects() {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $results = $db->query(DBQueries::$SELECT_SUBJECTS);
        } catch (PDOException $ex) {
            exit("Failed to query data: " . $ex->getMessage());
        }

        return $results;
    }

    public static function selectCourses($subj) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SELECT_COURSES);
            $stmt->bindParam(1,$subj);
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
     * Retrieves events data using a specified room
     *
     * @param $campus
     * @param $building
     * @param $room
     * @return array of events
     */
    public static function selectRoom($campus, $building, $room) {
        $db = Database::getDatabase();
        $results = NULL;
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

        return $results;
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
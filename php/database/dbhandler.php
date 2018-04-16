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

    public static function prepareDB() {
        $db = Database::getDatabase();
        try {
            foreach (DBQueries::$CREATE_TABLES as $table) {
                $results = $db->exec($table);
                if ($results) {

                }
            }
        } catch (PDOException $ex) {
            exit($ex->getMessage());
        }
    }

    public static function populateDB($file) {
        if (($data = fopen($file, "r")) !== FALSE) {
            $header = fgetcsv($data, 0, ",");
            while (($row =fgetcsv($data, 0, ",")) !== FALSE) {
                self::insertEventByRow($header, $row);
            }
        }
    }

    public static function insertEventByRow($header, $row) {
        $fields = array();
        for ($i = 0; $i < count($header); $i++) {
            $fields[$header[$i]] = $row[$i];
        }

        $db = Database::getDatabase();
        try {
            $stmtRoom = $db->prepare(DBQueries::$INSERT_ROOM);
            $stmtRoom->bindParam(1, $fields['camp_code']); // Good
            $stmtRoom->bindParam(2, $fields['camp_name']); // Good
            $stmtRoom->bindParam(3, $fields['bldg_code']); // Good
            $stmtRoom->bindParam(4, $fields['bldg_name']); // Good
            $stmtRoom->bindParam(5, $fields['room_code']); // Good
            $stmtRoom->bindParam(6, $fields['room_name']); // Good
            $stmtRoom->execute();
            $stmtCourse = $db->prepare(DBQueries::$INSERT_COURSE);
            $stmtCourse->bindParam(1, $fields['subj_code']); // Good
            $stmtCourse->bindParam(2, $fields['subj_name']); // Good
            $stmtCourse->bindParam(3, $fields['crse_code']); // Good
            $stmtCourse->bindParam(4, $fields['crse_name']); // Good
            $stmtCourse->execute();
            if (!empty($fields['instr_xid']) || $fields['instr_xid'] !== NULL) {
                $stmtInstructor = $db->prepare(DBQueries::$INSERT_INSTRUCTOR);
                $stmtInstructor->bindParam(1, $fields['instr_xid']);
                $stmtInstructor->bindParam(2, $fields['instr_fname']);
                $stmtInstructor->bindParam(3, $fields['instr_lname']);
                $stmtInstructor->execute();
            }
            $stmtEvent = $db->prepare(DBQueries::$INSERT_EVENT);
            $stmtEvent->bindParam(1, $fields['event_title']);
            $stmtEvent->bindParam(2, $fields['event_time_start']);
            $stmtEvent->bindParam(3, $fields['event_time_end']);
            $stmtEvent->bindParam(4, $fields['term_code']);
            $stmtEvent->bindParam(5, $fields['crn_key']);
            $stmtEvent->bindParam(6, $fields['camp_code']);
            $stmtEvent->bindParam(7, $fields['bldg_code']);
            $stmtEvent->bindParam(8, $fields['room_code']);
            $stmtEvent->bindParam(9, $fields['subj_code']);
            $stmtEvent->bindParam(10, $fields['crse_code']);
            $stmtEvent->bindParam(11, $fields['instr_xid']);
            $stmtEvent->execute();
        } catch (PDOException $ex) {
            exit($ex->getMessage());
        }
    }

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
            exit($ex->getMessage());
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
            exit($ex->getMessage());
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
            exit($ex->getMessage());
        }

        return $results;
    }

    public static function searchTimeByRoom($campus, $building, $room) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SEARCH_TIMEBYROOM);
            $stmt->bindParam(1, $campus);
            $stmt->bindParam(2, $building);
            $stmt->bindParam(3, $room);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit($ex->getMessage());
        }

        return $results;
    }

    public static function searchTimeByCourse($subject, $course) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SEARCH_TIMEBYCOURSE);
            $stmt->bindParam(1, $subject);
            $stmt->bindParam(2, $course);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit($ex->getMessage());
        }

        return $results;
    }

    public static function searchTimeByInstructor($instructor) {
        $db = Database::getDatabase();
        $results = NULL;
        try {
            $stmt = $db->prepare(DBQueries::$SEARCH_TIMEBYINSTRUCTOR);
            $stmt->bindParam(1, $instructor);
            $stmt->execute();
            $results = $stmt->fetchAll();
        } catch (PDOException $ex) {
            exit($ex->getMessage());
        }

        return $results;
    }

    /** SEPARATOR // SEPARATOR // SEPARATOR // SEPARATOR ///
    ///                                                  ///
    ///   \/\/\/  //      OLD METHODS       //   \/\/\/  ///
    ///                                                  ///
    /// SEPARATOR // SEPARATOR // SEPARATOR // SEPARATOR **/

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
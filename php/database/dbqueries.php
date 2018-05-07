<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

/**
 * Static constants containing the various pre-prepared SQL queries
 *
 * @author jkmalan (aka John Malandrakis)
 */
class DBQueries {

    /**
     * @var array A list of table creation queries
     */
    public static $CREATE_TABLES = array(

        "CREATE_ROOMS" =>
            "CREATE TABLE IF NOT EXISTS rooms ("
            . "camp_code CHAR(4) NOT NULL,"
            . "camp_name CHAR(32) NOT NULL,"
            . "bldg_code CHAR(8) NOT NULL,"
            . "bldg_name CHAR(32) NOT NULL,"
            . "room_code CHAR(16) NOT NULL,"
            . "room_name CHAR(32),"
            . "PRIMARY KEY (camp_code, bldg_code, room_code));",

        "CREATE_COURSES" =>
            "CREATE TABLE IF NOT EXISTS courses ("
            . "subj_code CHAR(8) NOT NULL,"
            . "subj_name CHAR(32) NOT NULL,"
            . "crse_code CHAR(8) NOT NULL,"
            . "crse_name CHAR(32) NOT NULL,"
            . "PRIMARY KEY (subj_code, crse_code));",

        "CREATE_INSTRUCTORS" =>
            "CREATE TABLE IF NOT EXISTS instructors ("
            . "xid CHAR(9) NOT NULL,"
            . "fname CHAR(32) NOT NULL,"
            . "mname CHAR(32),"
            . "lname CHAR(32) NOT NULL,"
            . "PRIMARY KEY (xid));",

        "CREATE_TERMS" =>
            "CREATE TABLE IF NOT EXISTS terms ("
            . "term_code INT NOT NULL,"
            . "term_name CHAR(32) NOT NULL,"
            . "PRIMARY KEY (term_code));",

        "CREATE_EVENTS" =>
            "CREATE TABLE IF NOT EXISTS `events` ("
            . "term_code INT NOT NULL,"
            . "crn_key INT NOT NULL,"
            . "time_start DATETIME NOT NULL,"
            . "time_end DATETIME NOT NULL,"
            . "title CHAR(64) NOT NULL,"
            . "camp_code CHAR(4) NOT NULL,"
            . "bldg_code CHAR(8) NOT NULL,"
            . "room_code CHAR(16) NOT NULL,"
            . "subj_code CHAR(8) NOT NULL,"
            . "crse_code CHAR(8) NOT NULL,"
            . "xid CHAR(9),"
            . "PRIMARY KEY (term_code, crn_key, time_start),"
            . "FOREIGN KEY (term_code) REFERENCES terms(term_code),"
            . "FOREIGN KEY (camp_code, bldg_code, room_code) REFERENCES rooms(camp_code, bldg_code, room_code),"
            . "FOREIGN KEY (subj_code, crse_code) REFERENCES courses(subj_code, crse_code),"
            . "FOREIGN KEY (xid) REFERENCES instructors(xid));"
    );

    /**
     * @var string A query to insert a single room into the rooms table
     */
    public static $INSERT_ROOM =
        "INSERT INTO rooms (camp_code, camp_name, bldg_code, bldg_name, room_code, room_name) "
        . "VALUES (?, ?, ?, ?, ?, ?) "
        . "ON DUPLICATE KEY UPDATE camp_code = camp_code;";

    /**
     * @var string A query to insert a single course into the courses table
     */
    public static $INSERT_COURSE =
        "INSERT INTO courses (subj_code, subj_name, crse_code, crse_name) "
        . "VALUES (?, ?, ?, ?) "
        . "ON DUPLICATE KEY UPDATE subj_code = subj_code;";

    /**
     * @var string A query to insert a single instructor into the instructors table
     */
    public static $INSERT_INSTRUCTOR =
        "INSERT INTO instructors (xid, fname, mname, lname) "
        . "VALUES (?, ?, ?, ?) "
        . "ON DUPLICATE KEY UPDATE xid = xid;";

    /**
     * @var string A query to insert a single term into the terms table
     */
    public static $INSERT_TERM =
        "INSERT INTO terms (term_code, term_name) "
        . "VALUES (?, ?) "
        . "ON DUPLICATE KEY UPDATE term_code = term_code;";

    /**
     * @var string A query to insert a single event into the events table
     */
    public static $INSERT_EVENT =
        "INSERT INTO `events` (term_code, crn_key, time_start, time_end, title, camp_code, bldg_code, room_code, subj_code, crse_code, xid) "
        . "VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?) "
        . "ON DUPLICATE KEY UPDATE crn_key = crn_key";

    /**
     * @var string A query to select a list of available campuses
     */
    public static $SELECT_CAMPUSES =
        "SELECT DISTINCT camp_code, camp_name FROM rooms "
        . "WHERE true;";

    /**
     * @var string A query to select a list of available buildings for a campus
     */
    public static $SELECT_BUILDINGS =
        "SELECT DISTINCT bldg_code, bldg_name FROM rooms "
        . "WHERE camp_code = ?;";

    /**
     * @var string A query to select a list of available rooms for a building
     */
    public static $SELECT_ROOMS =
        "SELECT DISTINCT room_code, room_name FROM rooms "
        . "WHERE bldg_code = ?;";

    /**
     * @var string A query to select a list of available subjects
     */
    public static $SELECT_SUBJECTS =
        "SELECT DISTINCT subj_code, subj_name FROM courses "
        . "WHERE true;";

    /**
     * @var string A query to select a list of available courses for a subject
     */
    public static $SELECT_COURSES =
        "SELECT DISTINCT crse_code, crse_name FROM courses "
	    . "WHERE subj_code = ?;";

    /**
     * @var string A query to select a list of available instructors
     */
    public static $SELECT_INSTRUCTORS =
        "SELECT DISTINCT xid, fname, lname FROM instructors "
        . "WHERE true;";

    /**
     * @var string A query to select a list of available terms
     */
    public static $SELECT_TERMS =
        "SELECT DISTINCT term_code, term_name FROM terms "
        . "WHERE true;";

    /**
     * @var string A query to select a list of events given a specified range of time
     *
     * Provides all variables from all tables
     * Returns DATETIME as UNIX timestamps
     */
    public static $SELECT_EVENTS_TIMES =
        "SELECT e.term_code, t.term_name, e.crn_key, e.time_start, e.time_end, e.title, e.camp_code, r.camp_name, e.bldg_code, r.bldg_name, e.room_code, r.room_name, e.subj_code, c.subj_name, e.crse_code, c.crse_name, e.xid, i.fname, i.mname, i.lname FROM `events` e "
        . "INNER JOIN rooms r ON e.camp_code = r.camp_code AND e.bldg_code = r.bldg_code AND e.room_code = r.room_code "
        . "INNER JOIN courses c ON e.subj_code = c.subj_code AND e.crse_code = c.crse_code "
        . "INNER JOIN instructors i ON e.xid = i.xid "
        . "INNER JOIN terms t ON e.term_code = t.term_code "
        . "WHERE e.time_start >= ? AND e.time_end <= ? "
        . "ORDER BY room_name ASC;";

    /**
     * @var string A query to select a list of events given a specified room
     *
     * Provides all variables from all tables
     * Returns DATETIME as UNIX timestamps
     */
    public static $SELECT_EVENTS_ROOMS =
        "SELECT e.term_code, t.term_name, e.crn_key, e.time_start, e.time_end, e.title, e.camp_code, r.camp_name, e.bldg_code, r.bldg_name, e.room_code, r.room_name, e.subj_code, c.subj_name, e.crse_code, c.crse_name, e.xid, i.fname, i.mname, i.lname FROM `events` e "
        . "INNER JOIN rooms r ON e.camp_code = r.camp_code AND e.bldg_code = r.bldg_code AND e.room_code = r.room_code "
        . "INNER JOIN courses c ON e.subj_code = c.subj_code AND e.crse_code = c.crse_code "
        . "INNER JOIN instructors i ON e.xid = i.xid "
        . "INNER JOIN terms t ON e.term_code = t.term_code "
        . "WHERE e.camp_code = ? AND e.bldg_code = ? AND e.room_code = ? "
        . "ORDER BY time_start ASC;";

    /**
     * @var string A query to select a list of events given a specified term and CRN
     *
     * Provides all variables from all tables
     * Returns DATETIME as UNIX timestamps
     */
    public static $SELECT_EVENTS_CRNS =
        "SELECT e.term_code, t.term_name, e.crn_key, e.time_start, e.time_end, e.title, e.camp_code, r.camp_name, e.bldg_code, r.bldg_name, e.room_code, r.room_name, e.subj_code, c.subj_name, e.crse_code, c.crse_name, e.xid, i.fname, i.mname, i.lname FROM `events` e "
        . "INNER JOIN rooms r ON e.camp_code = r.camp_code AND e.bldg_code = r.bldg_code AND e.room_code = r.room_code "
        . "INNER JOIN courses c ON e.subj_code = c.subj_code AND e.crse_code = c.crse_code "
        . "INNER JOIN instructors i ON e.xid = i.xid "
        . "INNER JOIN terms t ON e.term_code = t.term_code "
        . "WHERE e.term_code = ? AND e.crn_key = ? "
        . "ORDER BY room_code ASC, time_start ASC;";

}
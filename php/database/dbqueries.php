<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

class DBQueries {

    public static $CREATE_TABLES = array(
        "CREATE_ROOMS" => "CREATE TABLE IF NOT EXISTS rooms ("
            . "camp_code CHAR(8) NOT NULL,"
            . "camp_name CHAR(32) NOT NULL,"
            . "bldg_code CHAR(8) NOT NULL,"
            . "bldg_name CHAR(32) NOT NULL,"
            . "room_code CHAR(8) NOT NULL,"
            . "room_name CHAR(32) NOT NULL,"
            . "PRIMARY KEY (camp_code, bldg_code, room_code));",
        "CREATE_COURSES" => "CREATE TABLE IF NOT EXISTS courses ("
            . "subj_code CHAR(8) NOT NULL,"
            . "subj_name CHAR(32) NOT NULL,"
            . "crse_code CHAR(8) NOT NULL,"
            . "crse_name CHAR(32) NOT NULL,"
            . "PRIMARY KEY (subj_code, crse_code));",
        "CREATE_INSTRUCTORS" => "CREATE TABLE IF NOT EXISTS instructors ("
            . "instr_xid CHAR(9) NOT NULL,"
            . "instr_fname CHAR(32) NOT NULL,"
            . "instr_lname CHAR(32) NOT NULL,"
            . "PRIMARY KEY (instr_xid));",
        "CREATE_EVENTS" => "CREATE TABLE IF NOT EXISTS `events` ("
            . "event_id INT NOT NULL AUTO_INCREMENT,"
            . "event_title CHAR(32) NOT NULL,"
            . "event_date DATE NOT NULL,"
            . "event_time_start TIME NOT NULL,"
            . "event_time_end TIME NOT NULL,"
            . "term_code CHAR(8) NOT NULL,"
            . "crn_key INT NOT NULL,"
            . "camp_code CHAR(8) NOT NULL,"
            . "bldg_code CHAR(8) NOT NULL,"
            . "room_code CHAR(8) NOT NULL,"
            . "subj_code CHAR(8) NOT NULL,"
            . "crse_code CHAR(8) NOT NULL,"
            . "instr_xid CHAR(9) NOT NULL,"
            . "PRIMARY KEY (event_id),"
            . "FOREIGN KEY (camp_code, bldg_code, room_code) REFERENCES rooms(camp_code, bldg_code, room_code),"
            . "FOREIGN KEY (subj_code, crse_code) REFERENCES courses(subj_code, crse_code),"
            . "FOREIGN KEY (instr_xid) REFERENCES instructors(instr_xid));"
    );

    public static $INSERT_ROOM = "INSERT INTO rooms (camp_code, camp_name, bldg_code, bldg_name, room_code, room_name) VALUES (?, ?, ?, ?, ?, ?);";

    public static $INSERT_COURSE = "INSERT INTO courses (subj_code, subj_name, crse_code, crse_name) VALUES (?, ?, ?, ?);";

    public static $INSERT_INSTRUCTOR = "INSERT INTO instructors (instr_xid, instr_fname, instr_lname) VALUES (?, ?, ?);";

    public static $INSERT_EVENT = "INSERT INTO events (event_title, event_date, event_time_start, event_time_end, term_code, crn_key, camp_code, bldg_code, room_code, subj_code, crse_code, instr_xid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

    public static $SELECT_CAMPUSES = "SELECT DISTINCT camp_code, camp_name FROM rooms WHERE true;";

    public static $SELECT_BUILDINGS = "SELECT DISTINCT bldg_code, bldg_name FROM rooms WHERE camp_code=?;";

    public static $SELECT_ROOMS = "SELECT DISTINCT room_code, room_name FROM rooms WHERE bldg_code=?;";

    public static $SELECT_INSTRUCTORS = "SELECT DISTINCT instr_xid, instr_fname, instr_lname FROM `instructors` WHERE true;";

    public static $SELECT_ROOM = "SELECT event_id, event_title, event_time_start, event_time_end, crn_key, camp_name, bldg_name, room_name FROM `events` e INNER JOIN rooms r ON e.camp_code = r.camp_code AND e.bldg_code = r.bldg_code AND e.room_code = r.room_code WHERE e.camp_code=? AND e.bldg_code=? AND e.room_code=?;";

    public static $SELECT_COURSE = "SELECT * FROM `events` WHERE subj_code=? AND crse_code=?;";

    public static $SELECT_SUBJECTS = "SELECT DISTINCT subj_code, subj_name FROM courses WHERE true;";

    public static $SELECT_COURSES = "SELECT DISTINCT crse_code, crse_name FROM courses WHERE subj_code=?;";

    public static $SEARCH_ROOMS_BY_TIME = "SELECT r.bldg_code, r.bldg_name, r.room_code, r.room_name FROM rooms r INNER JOIN events e ON r.room_code=e.room_code AND r.bldg_code=e.bldg_code AND r.camp_code=e.camp_code WHERE event_time_start >= ?;";

    public static $SEARCH_ROOMBYTIME = "SELECT r.camp_code, r.camp_name, r.bldg_code, r.bldg_name, r.room_code, r.room_name, e.event_time_start, e.event_time_end FROM rooms r INNER JOIN events e ON r.camp_code = e.camp_code AND r.bldg_code = e.bldg_code AND r.room_code = e.room_code WHERE event_date = ? AND event_time_start >= ? AND (event_time_end IS NULL OR event_time_end <= ?);";

    public static $SEARCH_ROOMBYCOURSE = "SELECT r.camp_code, r.camp_name, r.bldg_code, r.bldg_name, r.room_code, r.room_name, e.event_time_start, e.event_time_end FROM rooms r INNER JOIN events e ON r.camp_code = e.camp_code AND r.bldg_code = e.bldg_code AND r.room_code = e.room_code WHERE subj_code = ? AND crse_code = ?;";

    public static $SEARCH_ROOMBYINSTRUCTOR = "SELECT r.camp_code, r.camp_name, r.bldg_code, r.bldg_name, r.room_code, r.room_name, e.event_time_start, e.event_time_end FROM rooms r INNER JOIN events e ON r.camp_code = e.camp_code AND r.bldg_code = e.bldg_code AND r.room_code = e.room_code WHERE instr_xid = ?";

    public static $SEARCH_TIMEBYROOM = "SELECT e.event_id, e.event_title, e.event_date, e.event_time_start, e.event_time_end, e.term_code, e.crn_key, e.camp_code, r.camp_name, e.bldg_code, r.bldg_name, e.room_code, r.room_name, e.subj_code, c.subj_name, e.crse_code, c.crse_name, e.instr_xid, i.instr_fname, i.instr_lname FROM events e INNER JOIN rooms r ON e.camp_code=r.camp_code AND e.bldg_code = r.bldg_code AND e.room_code = r.room_code INNER JOIN courses c ON e.subj_code=c.subj_code AND e.crse_code=c.crse_code INNER JOIN instructors i ON e.instr_xid=i.instr_xid WHERE e.camp_code=? AND e.bldg_code=? AND e.room_code=?;";

    public static $SEARCH_TIMEBYCOURSE = "";

    public static $SEARCH_TIMEBYINSTRUCTOR = "";

}
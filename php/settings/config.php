<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

/**
 * Static constants containing settings and configuration data
 *
 * @author jkmalan (aka John Malandrakis)
 */
class Config {

    /**
     * @var string The database host address
     */
    public static $DB_HOST = "127.0.0.1";

    /**
     * @var int The database host port
     */
    public static $DB_PORT = 3306;

    /**
     * @var string The database name
     */
    public static $DB_NAME = "sju_database";

    /**
     * @var string The database username to connect with
     */
    public static $DB_USER = "sju_admin";

    /**
     * @var string The database password to connect with
     */
    public static $DB_PASS = "sju_adminpass";

    /**
     * @var string The database character set
     */
    public static $DB_CHAR = "utf8";

    /**
     * @var array A map of SQL field names to CSV field names
     */
    public static $DATA_MAP = array(
        "camp_code"  => "camp_code",
        "camp_name"  => "camp_name",
        "bldg_code"  => "bldg_code",
        "bldg_name"  => "bldg_name",
        "room_code"  => "room_code",
        "room_name"  => "room_name",
        "subj_code"  => "subj_code",
        "subj_name"  => "subj_name",
        "crse_code"  => "crse_code",
        "crse_name"  => "crse_name",
        "xid"        => "instr_xid",
        "fname"      => "instr_fname",
        "mname"      => "instr_mname",
        "lname"      => "instr_lname",
        "term_code"  => "term_code",
        "term_name"  => "term_name",
        "eid"        => "event_id",
        "crn_key"    => "crn_key",
        "title"      => "event_title",
        "time_start" => "event_time_start",
        "time_end"   => "event_time_end"
    );

}
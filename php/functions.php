<?php
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . "/php/initialize.php";

$function_type = filter_input(INPUT_GET, 'ftype');

if ($function_type === "camp") {
    $campuses = DBHandler::getCampuses();
    echo "<option value='' selected disabled>Choose a campus...</option>";
    foreach ($campuses as $camp) {
        echo "<option value='" . $camp['camp_code'] . "'>" . $camp['camp_name'] . "</option>";
    }
}

if ($function_type === "bldg") {
    $campus = filter_input(INPUT_GET, 'campus');
    $buildings = DBHandler::getBuildings($campus);
    echo "<option value='' selected disabled>Choose a building...</option>";
    foreach ($buildings as $bldg) {
        echo "<option value='" . $bldg['bldg_code'] . "'>" . $bldg['bldg_name'] . "</option>";
    }
}

if ($function_type === "room") {
    $building = filter_input(INPUT_GET, 'building');
    $rooms = DBHandler::getRooms($building);
    echo "<option value='' selected disabled>Choose a room...</option>";
    foreach ($rooms as $room) {
        echo "<option value='" . $room['room_code'] . "'>" . $room['room_name'] . "</option>";
    }
}

if ($function_type === "subj") {
    $subjects = DBHandler::getSubjects();
    echo "<option value='' selected disabled>Choose a subject...</option>";
    foreach ($subjects as $subj) {
        echo "<option value='" . $subj['subj_code'] . "'>" . $subj['subj_name'] . "</option>";
    }
}

if ($function_type === "crse") {
    $subject = filter_input(INPUT_GET, 'subject');
    $courses = DBHandler::getCourses($subject);
    echo "<option value='' selected disabled>Choose a course...</option>";
    foreach ($courses as $crse) {
        echo "<option value='" . $crse['crse_code'] . "'>" . $crse['crse_name'] . "</option>";
    }
}

if ($function_type === "searchEBR") {
    $camp = filter_input(INPUT_GET, 'camp');
    $bldg = filter_input(INPUT_GET, 'bldg');
    $room = filter_input(INPUT_GET, 'room');
    $events = DBHandler::searchEventsByRoom($camp, $bldg, $room);
    $results = array();
    foreach ($events as $event) {
        echo "<p>";
        echo $event['title'] . "<br>";
        echo $event['term_code'] . " : " . $event['crn_key'] . "<br>";
        echo $event['room_name'] . "-" . $event['bldg_name']  . "-" . $event['room_name'] .   "<br>";
        echo $event['xid'] . ": " . $event['fname']  . " " . $event['lname'] . "<br>";
        echo $event['time_start'] . "<br>";
        echo $event['time_end'] . "</p>";
    }
}

if ($function_type === "searchEBT") {
    $time_start = filter_input(INPUT_GET, 'time_start');
    $time_end = filter_input(INPUT_GET, 'time_end');
    $events = DBHandler::searchEventsByTime($time_start, $time_end);
    $results = array();
    foreach ($events as $event) {
        echo "<p>";
        echo $event['title'] . "<br>";
        echo $event['term_code'] . " : " . $event['crn_key'] . "<br>";
        echo $event['room_name'] . "-" . $event['bldg_name']  . "-" . $event['room_name'] .   "<br>";
        echo $event['xid'] . ": " . $event['fname']  . " " . $event['lname'] . "<br>";
        echo $event['time_start'] . "<br>";
        echo $event['time_end'] . "</p>";
    }
}

if ($function_type === "searchEBC") {
    $term_code = filter_input(INPUT_GET, 'term');
    $crn_key = filter_input(INPUT_GET, 'crn');
    $events = DBHandler::searchEventsByCRN($term_code, $crn_key);
    $results = array();
    foreach ($events as $event) {
        echo "<p>";
        echo $event['title'] . "<br>";
        echo $event['term_code'] . " : " . $event['crn_key'] . "<br>";
        echo $event['room_name'] . "-" . $event['bldg_name']  . "-" . $event['room_name'] .   "<br>";
        echo $event['xid'] . ": " . $event['fname']  . " " . $event['lname'] . "<br>";
        echo $event['time_start'] . "<br>";
        echo $event['time_end'] . "</p>";
    }
}

function searchEBR($camp, $bldg, $room) {
    $events = DBHandler::searchEventsByRoom($camp, $bldg, $room);
    return $events;
}

function searchEBT($time_start, $time_end) {
    $events = DBHandler::searchEventsByTime($time_start, $time_end);
    return $events;
}

function searchEBC($term_code, $crn_key) {
    $events = DBHandler::searchEventsByCRN($term_code, $crn_key);
    return $events;
}

function validate($string) {
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}
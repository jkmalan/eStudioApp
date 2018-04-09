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
    $campuses = DBHandler::selectCampuses();
    echo "<option value='' selected disabled>Choose a campus...</option>";
    foreach ($campuses as $camp) {
        echo "<option value='" . $camp['camp_code'] . "'>" . $camp['camp_name'] . "</option>";
    }
}

if ($function_type === "bldg") {
    $campus = filter_input(INPUT_GET, 'campus');
    $buildings = DBHandler::selectBuildings($campus);
    echo "<option value='' selected disabled>Choose a building...</option>";
    foreach ($buildings as $bldg) {
        echo "<option value='" . $bldg['bldg_code'] . "'>" . $bldg['bldg_name'] . "</option>";
    }
}

if ($function_type === "room") {
    $building = filter_input(INPUT_GET, 'building');
    $rooms = DBHandler::selectRooms($building);
    echo "<option value='' selected disabled>Choose a room...</option>";
    foreach ($rooms as $room) {
        echo "<option value='" . $room['room_code'] . "'>" . $room['room_name'] . "</option>";
    }
}

if ($function_type === "subj") {
    $subjects = DBHandler::selectSubjects();
    echo "<option value='' selected disabled>Choose a subject...</option>";
    foreach ($subjects as $subj) {
        echo "<option value='" . $subj['subj_code'] . "'>" . $subj['subj_name'] . "</option>";
    }
}

if ($function_type === "crse") {
    $subject = filter_input(INPUT_GET, 'subject');
    $courses = DBHandler::selectCourses($subject);
    echo "<option value='' selected disabled>Choose a course...</option>";
    foreach ($courses as $crse) {
        echo "<option value='" . $crse['crse_code'] . "'>" . $crse['crse_name'] . "</option>";
    }
}

if ($function_type === "roomEvents") {
    $camp = filter_input(INPUT_GET, 'camp');
    $bldg = filter_input(INPUT_GET, 'bldg');
    $room = filter_input(INPUT_GET, 'room');
    $events = DBHandler::selectRoom($camp, $bldg, $room);
    $results = array();
    foreach ($events as $event) {
        $results[] = array(
            'id' => $event['event_id'],
            'title' => $event['event_title'],
            'crn' => $event['crn_key'],
            'camp' => $event['camp_name'],
            'bldg' => $event['bldg_name'],
            'room' => $event['room_name'],
            'start' => strtotime(new DateTime($event['event_time_start'] . " " . $event['event_date']))*1000,
            'end' => strtotime(new DateTime($event['event_time_end'] . " " . $event['event_date']))*1000
        );
    }
}

function validate($string) {
    $string = trim($string);
    $string = stripslashes($string);
    $string = htmlspecialchars($string);
    return $string;
}
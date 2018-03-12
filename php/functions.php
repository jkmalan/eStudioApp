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
    echo "<option selected>Choose a campus...</option>";
    foreach ($campuses as $camp) {
        echo "<option value='" . $camp['camp_code'] . "'>" . $camp['camp_name'] . "</option>";
    }
}

if ($function_type === "bldg") {
    $campus = filter_input(INPUT_GET, 'campus');
    $buildings = DBHandler::selectBuildings($campus);
    echo "<option selected>Choose a building...</option>";
    foreach ($buildings as $bldg) {
        echo "<option value='" . $bldg['bldg_code'] . "'>" . $bldg['bldg_name'] . "</option>";
    }
}

if ($function_type === "room") {
    $building = filter_input(INPUT_GET, 'building');
    $rooms = DBHandler::selectRooms($building);
    echo "<option selected>Choose a room...</option>";
    foreach ($rooms as $room) {
        echo "<option value='" . $room['room_code'] . "'>" . $room['room_name'] . "</option>";
    }
}

if ($function_type === "prof") {
    $professors = DBHandler::selectProfessors();
    echo "<option selected>Choose a professor...</option>";
    foreach ($professors as $prof) {
        echo "<option value='" . $prof['instr_xid'] . "'>" . $prof['instr_fname'] . " " . $prof['instr_lname'] . "</option>";
    }
}
/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

"use strict";

Date.prototype.getWeek = function(iso8601) {
    if (iso8601) {
        var target = new Date(this.valueOf());
        var day = (this.getDay() + 6) % 7;
        target.setDate(target.getDate() - day + 3);
    }
};
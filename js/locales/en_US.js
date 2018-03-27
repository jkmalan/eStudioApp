/**
 * Copyright (c) 2017 John Malandrakis
 * This software is provided to St. John's University to be
 * used, modified, and distributed at their discretion.
 * All other rights reserved.
 */

if (!window.calendar_languages) {
    window.calendar_languages = {};
}

window.calendar_languages['en_US'] = {
    // Locale Specific Settings
    time_iso8601: true,
    week_start: 2, // Specifies the first day of the week - 2 for Sunday, 1 for Monday
    week_iso8601: false, // Specifies the first week of the year according to ISO 8601

    // Error Messages
    error_badView: 'Calendar: View {0} not found!',
    error_badURL: 'Calendar: Event URL is not found!',
    error_badFormat: 'Calendar: Bad date format {0}. Use "now" or "yyyy-mm-dd"!',
    error_badNav: 'Calendar: Bad navigation direction {0}. Use "next", "prev", or "today"!',
    error_badDivide: 'Calendar: Bad time split parameter. Use "5", "10", "15", "30"!',

    // Title Formats
    title_year: '{0}', // yyyy - 2018
    title_month: '{0} {1}', // m# yyyy - March 2018
    title_week: 'Week {0} of {1}', // Week ww of yyyy - Week 13 of 2018
    title_day: '{0} {1}, {2}', // m# dd, yyyy - March 27, 2018

    // Other Formats
    time_am: 'AM',
    time_pm: 'PM',
    week: 'Week {0}',

    // Month Names Full
    m: {
        0: 'January',
        1: 'February',
        2: 'March',
        3: 'April',
        4: 'May',
        5: 'June',
        6: 'July',
        7: 'August',
        8: 'September',
        9: 'October',
        10: 'November',
        11: 'December',
    },

    // Month Names Abbreviated
    ms: {
        0: 'Jan',
        1: 'Feb',
        2: 'Mar',
        3: 'Apr',
        4: 'May',
        5: 'Jun',
        6: 'Jul',
        7: 'Aug',
        8: 'Sep',
        9: 'Oct',
        10: 'Nov',
        11: 'Dec',
    },

    // Day Names Full
    d: {
        0: 'Sunday',
        1: 'Monday',
        2: 'Tuesday',
        3: 'Wednesday',
        4: 'Thursday',
        5: 'Friday',
        6: 'Saturday',
    },

    // Day Names Abbreviated
    ds: {
        0: 'Sun',
        1: 'Mon',
        2: 'Tue',
        3: 'Wed',
        4: 'Thu',
        5: 'Fri',
        6: 'Sat',
    },

    // Holidays List
    holidays: {
        '01-01': "New Year's Day", // January 1
        '01+3*1': "Martin Luther King Jr. Day", // Third (+3*) Monday (1) in January (01)
        '02+3*1': "President's Day", // Third (+3*) Monday (1) in February (02)
        '05-1*1': "Memorial Day", // Last (-1*) Monday (1) in May (05)
        '04-07': "Independence Day", // July 4
        '09+1*1': "Labor Day", // First (+1*) Monday (1) in September (09)
        '10+2*1': "Columbus Day", // Second (+2*) Monday (1) in October (10)
        '11-11': "Veterans Day", // November 11
        '11+4*4': "Thanksgiving Day", // Fourth (+4*) Thursday (4) in November (11)
        '25-12': "Christmas" // December 25
    }

};
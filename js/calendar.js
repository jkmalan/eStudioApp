/**
 * Bootstrap Calendar
 *
 * Adapted from http://github.com/Serhioromano/bootstrap-calendar by Sergey Romanov
 *
 * @author jkmalan (aka John Malandrakis)
 */

"use strict";

(function($) {


    let default_options = {
        view_width: '100%',
        view_type: 'month',
        view_init: 'now',
        time_start: '00:00',
        time_end: '23:00',
        time_interval: '30',
        tmpls_path: '/templates/',
        tmpls_cache: true,
        events_source: '',
        events_cache: false,

    };

    function Calendar(settings, context) {
        this.options = $.extend(true, {position: {start: new Date(), end: new Date()}}, default_options, settings);
        this.context = context;

        this.setOptions = function(settings) {

        };

        /**
         * Sets the locale to be used
         *
         * @param language
         */
        this.setLanguage = function(language) {

        };

        this.render = function() {

        };

        this.view = function(view) {

        };

        this.navigate = function(target, callback) {

        };

        this.getTitle = function() {
            let date = this.options.position.start;
            switch (this.options.view) {
                case 'year':
                    return this.locale.title_year.format(date.getFullYear());
                case 'month':
                    return this.locale.title_year.format(this.locale['m' + date.getMonth()], date.getFullYear());
                case 'week':
                    return this.locale.title_year.format(date.getWeek());
                case 'day':
                    return this.locale.title_year.format(date.getFullYear());
            }
        };

        this.getYear = function() {
            return this.options.position.start.getFullYear();
        };

        this.getMonth = function() {
            return this.locale['m' + this.options.position.start.getMonth()];
        };

        this.getDay = function() {
            return this.locale['d' + this.options.position.start.getDay()];
        };

        this.isToday = function() {
            let now = new Date().getTime();
            return (now > this.options.position.start) && (now < this.options.position.end);
        };

        this.getStartDate = function() {
            return this.options.position.start;
        };

        this.getEndDate = function() {
            return this.options.position.end;
        };

        this.getEvents = function(start, end) {

        };

        this.showEvents = function(event, context, slider, self) {

        };

        this.addEvent = function() {

        };

        this.remEvent = function() {

        };

        this.modEvent = function() {

        };

        this.setLanguage(this.options.language);
        this.context.css('width', this.options.width).addClass('cal-context');

    }

    $.fn.calendar = function(settings) {
        return new Calendar(settings, this);
    }

}(jQuery));
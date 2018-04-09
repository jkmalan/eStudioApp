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
        language: 'en_US',
        view_width: '100%', // Previously 'width'
        view_type: 'month', // Previously 'view'
        view_init: 'now', // Previously 'day'
        view_weekbox: true, // Previously 'weekbox'
        view_weeknumbers: true, // Previously 'display_week_numbers'
        modal: null,
        modal_type: "iframe",
        modal_title: null,
        tooltip: 'body', // Previously 'tooltip_container'
        time_start: '00:00',
        time_end: '23:00',
        time_interval: '30', // Previously 'time_split'
        holiday_merge: false, // Previously 'merge_holidays'
        tmpls_path: '/templates/',
        tmpls_cache: true,
        events_source: '',
        events_cache: false,
        events_between: false, // Previously 'show_events_which_fits_time'

        // Event Callbacks triggered on various calendar events
        onEventsLoad: function(events) {

        },
        onEventsPreLoad: function(next) {

        },
        onViewLoad: function(view) {

        },
        onModalShown: function(events) {

        },
        onModalHidden: function(events) {

        },

        // Determines various classes and view settings, not exactly understood, but used
        classes: {
            months: {
                inmonth: 'cal-day-inmonth',
                outmonth: 'cal-day-outmonth',
                saturday: 'cal-day-weekend',
                sunday: 'cal-day-weekend',
                holidays: 'cal-day-holiday',
                today: 'cal-day-today'
            },
            week: {
                workday: 'cal-day-workday',
                saturday: 'cal-day-weekend',
                sunday: 'cal-day-weekend',
                holidays: 'cal-day-holiday',
                today: 'cal-day-today'
            }
        },
        views: {
            year: {
                slide_events: 1,
                enable: 1
            },
            month: {
                slide_events: 1,
                enable: 1
            },
            week: {
                enable: 1
            },
            day: {
                enable: 1
            }
        },

        // Internal settings
        events: [],
        templates: {
            year: '',
            month: '',
            week: '',
            day: ''
        },

        stop_cycling: false // Unknown option, seemingly unused
    };

    let default_messages = {

    };

    let timezone = '';
    try {
        if ($.type(window.jstz) === 'object' && $.type(jstz.determine) === 'function') {
            timezone = jstz.determine().name();
            if ($.type(timezone) !== 'string') {
                timezone = '';
            }
        }
    } catch (ex) {
        warn('Failed to determine timezone from browser!'); // ERROR: Timezone could not be determined
    }

    function buildEventsSourceURL(url, data) {
        let sourceURL = url;
        let separator = (url.indexOf('?') < 0) ? '?' : '&';
        for (let key in data) {
            sourceURL += separator + key + "=" + encodeURIComponent(data[key]);
            separator = "&";
        }
        return sourceURL;
    }

    function warn(message) {
        if ($.type(window.console) === 'object' && $.type(window.console.warn) === 'function') {
            window.console.warn('[Calendar] ' + message);
        }
    }

    function Calendar(settings, context) {
        this.options = $.extend(true, {position: {start: new Date(), end: new Date()}}, default_options, settings);
        this.context = context;

        this.setOptions = function(settings) {
            $.extend(this.options, settings);
            if ('language' in settings) {
                this.setLanguage(settings.language);
            }

            if ('modal' in settings) {
                this.updateModal();
            }
        };

        /**
         * Sets the locale to be used
         *
         * @param language
         */
        this.setLanguage = function(language) {
            if (window.calendar_languages) {
                let lang = language in window.calendar_languages ? language : default_options.language;
                this.locale = $.extend(true, {}, default_messages, calendar_languages[lang]);
                this.options.language = lang;
            }
        };

        this.render = function() {
            this.context.html('');
            this.loadTemplate(this.options.view_type);

            let data = {};
            data.cal = this;
            data.day = 1;

            let day = this.locale.d;
            if (this.locale.week_start === 1) {
                data.days_name = [day[1], day[2], day[3], day[4], day[5], day[6], day[0]];
            } else {
                data.days_name = [day[0], day[1], day[2], day[3], day[4], day[5], day[6]];
            }

            let start = this.options.position.start.getTime();
            let end = this.options.position.end.getTime();

            data.events = this.getEvents(start, end);

            switch (this.options.view) {
                case 'month':
                    break;
                case 'week':
                    this.calcHourMinute(data);
                    break;
                case 'day':
                    this.calcHourMinute(data);
                    break;
            }

            data.start = new Date(start);
            data.lang = this.locale;

            this.context.append(this.options.templates[this.options.view](data));
            this.update();
        };

        this.update = function() {
            let self = this;

            $('*[data-toggle="tooltip"]').tooltip({container: this.options.tooltip});

            $('*[data-cal-date]').on('click', function() {
                let view = $(this).data('cal-view');
                self.options.day = $(this).data('cal-date');
                self.view(view);
            });

            $('.cal-cell').on('dblclick', function() {
                let view = $('[data-cal-date]', this).data('cal-view');
                self.options.day = $('[data-cal-date]', this).data('cal-date');
                self.view(view);
            });

            this['update_' + this.options.view]();

            this.update_modal();
        };

        this.update_modal = function() {
            let self = this;

            $('a[data-event-id]', this.context).unbind('click');

            if (!self.options.modal) {
                return;
            }

            let modal = $(self.options.modal);

            if (!modal.length) {
                return;
            }

            let iframe = null;
            if (self.options.modal_type === "iframe") {
                iframe = $(document.createElement("iframe"))
                    .attr({
                        width: "100%",
                        frameborder: "0"
                    });
            }

            $('a[data-event-id]', this.context).on('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                let url = $(this).attr('href');
                let id = $(this).data('event-id');
                let eventID = _.find(self.options.events, function(event) {
                    return event.id === id;
                });
            });
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
            let events = [];
            $.each(this.options.events, function() {
                if (this.start !== null) {
                    let event_end = this.end || this.start;
                    if ((parseInt(this.start) < end) && (parseInt(event_end) > start)) {
                        events.push(this);
                    }
                }
            });
            return events;
        };

        this.showEvents = function(event, context, slider, self) {

        };

        this.addEvent = function() {

        };

        this.remEvent = function() {

        };

        this.modEvent = function() {

        };

        this.formatHour = function() {

        };

        this.formatTime = function() {

        };

        this.calcHourMinute = function(data) {
            let self = this;
            let time_interval = parseInt(this.options.time_interval);
            let time_interval_count = 60 / time_interval;
            let time_interval_hour = Math.min(time_interval_count, 1);

            if (((time_interval_count >= 1) && (time_interval_count % 1 !== 0)) || ((time_interval_count < 1) && (1440 / time_interval % 1 !== 0))) {
                $.error(this.locale.error_badDivide);
            }

            let time_start = this.options.time_start.split(':');
            let time_end = this.options.time_end.split(':');

            data.hours = (parseInt(time_end[0]) - parseInt(time_start[0])) * time_interval_hour;
            let lines = data.hours * time_interval_count - parseInt(time_start[1]) / time_interval;
            let msPerLine = 60000 * time_interval;

            let start = new Date(this.options.position.start.getTime());
            start.setHours(parseInt(time_start[0]));
            start.setMinutes(parseInt(time_start[1]));
            let end = new Date(this.options.position.end.getTime());
            end.setHours(parseInt(time_end[0]));
            end.setMinutes(parseInt(time_end[1]));

            data.all_day = [];
            data.by_hour = [];
            data.after_time = [];
            data.before_time = [];
            $.each(data.events, function(k, e) {

            });
        };

        this.getTemplate = function(view) {
            if ($.type(this.options.tmpls_path) === 'function') {
                return this.options.tmpls_path(view);
            } else {
                return this.options.tmpls_path + view + '.html';
            }
        };

        this.loadTemplate = function(view) {
            if (this.options.templates[view]) {
                return;
            }

            let self = this;
            $.ajax({
                url: self.getTemplate(view),
                dataType: 'html',
                type: 'GET',
                async: false,
                cache: this.options.tmpls_cache
            }).done(function(html) {
                self.options.templates[view] = _.template(html);
            });
        };

        this.setLanguage(this.options.language);
        this.context.css('width', this.options.width).addClass('cal-context');

    }

    $.fn.calendar = function(settings) {
        return new Calendar(settings, this);
    }

}(jQuery));
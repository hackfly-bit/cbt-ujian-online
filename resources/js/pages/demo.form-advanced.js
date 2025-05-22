/**
 * Theme: Attex - Responsive Bootstrap 5 Admin Dashboard
 * Author: Coderthemes
 * Module/App: Time Picker
 */

import t from 'bootstrap-touchspin/dist/jquery.bootstrap-touchspin'
t(window, jQuery);


import 'moment/src/moment.js';
import 'daterangepicker/daterangepicker.js';
import 'bootstrap-timepicker/js/bootstrap-timepicker.min.js';
import  'bootstrap-maxlength/dist/bootstrap-maxlength.min.js';

import 'flatpickr/dist/flatpickr.js'
import 'bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js';



$(document).ready(function () {

    var defaultOptions = {};


    $('#timepicker').timepicker({
        "showSeconds": true,
        icons: {
            up: 'ri-arrow-up-s-line',
            down: 'ri-arrow-down-s-line'
        },
        appendWidgetTo: "#timepicker-input-group1"
    });

    $('#timepicker2').timepicker({
        "showSeconds": true,
        showMeridian: false,
        icons: {
            up: 'ri-arrow-up-s-line',
            down: 'ri-arrow-down-s-line'
        },
        appendWidgetTo: "#timepicker-input-group2"
    });

    $('#timepicker3').timepicker({
        "showSeconds": true,
        minuteStep: 15,
        icons: {
            up: 'ri-arrow-up-s-line',
            down: 'ri-arrow-down-s-line'
        },
        appendWidgetTo: "#timepicker-input-group3"
    });

    //Flat picker
    $('#basic-datepicker').flatpickr();

    $('#datetime-datepicker').flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i"
    });

    $('#humanfd-datepicker').flatpickr({
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    });

    $('#minmax-datepicker').flatpickr({
        minDate: "2020-01",
        maxDate: "2020-03"
    });

    $('#disable-datepicker').flatpickr({
        onReady: function () {
            this.jumpToDate("2025-01")
        },
        disable: ["2025-01-10", "2025-01-21", "2025-01-30", new Date(2025, 4, 9)],
        dateFormat: "Y-m-d",
    });

    $('#multiple-datepicker').flatpickr({
        mode: "multiple",
        dateFormat: "Y-m-d"
    });

    $('#conjunction-datepicker').flatpickr({
        mode: "multiple",
        dateFormat: "Y-m-d",
        conjunction: " :: "
    });

    $('#range-datepicker').flatpickr({
        mode: "range"
    });

    $('#inline-datepicker').flatpickr({
        inline: true
    });

    $('#basic-timepicker').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i"
    });

    $('#24hours-timepicker').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    $('#minmax-timepicker').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        minDate: "16:00",
        maxDate: "22:30",
    });

    $('#preloading-timepicker').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        defaultDate: "01:45"
    });

    $('[data-toggle="touchspin"]').each(function (idx, obj) {
        var objOptions = $.extend({}, defaultOptions, $(obj).data());
        $(obj).TouchSpin(objOptions);
        // new TouchSpin($(obj), objOptions)
    });


});


// //
// $(document).ready(function () {
//     // the basics
//     // ----------
//
//     var engine = new Bloodhound({
//         local: ['dog', 'pig', 'moose'],
//         queryTokenizer: Bloodhound.tokenizers.whitespace,
//         datumTokenizer: Bloodhound.tokenizers.whitespace
//     });
//
//     engine.initialize();
//
//
//     var substringMatcher = function (strs) {
//         return function findMatches(q, cb) {
//             var matches, substringRegex;
//
//             // an array that will be populated with substring matches
//             matches = [];
//
//             // regex used to determine if a string contains the substring `q`
//             let substrRegex = new RegExp(q, 'i');
//
//             // iterate through the pool of strings and for any string that
//             // contains the substring `q`, add it to the `matches` array
//             $.each(strs, function (i, str) {
//                 if (substrRegex.test(str)) {
//                     matches.push(str);
//                 }
//             });
//
//             cb(matches);
//         };
//     };
//
//     var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
//         'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
//         'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
//         'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
//         'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
//         'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
//         'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
//         'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
//         'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
//     ];
//
//     $('#the-basics').typeahead({
//         hint: true,
//         highlight: true,
//         minLength: 1
//     },
//         {
//             name: 'states',
//             source: substringMatcher(states)
//         });
//
//     // bloodhound
//     // ----------
//
//     // constructs the suggestion engine
//     var states = new Bloodhound({
//         datumTokenizer: Bloodhound.tokenizers.whitespace,
//         queryTokenizer: Bloodhound.tokenizers.whitespace,
//         // `states` is an array of state names defined in "The Basics"
//         local: states
//     });
//
//     $('#bloodhound').typeahead({
//         hint: true,
//         highlight: true,
//         minLength: 1
//     },
//         {
//             name: 'states',
//             source: states
//         });
//
//     // prefetch
//     // --------
//
//     var countries = new Bloodhound({
//         datumTokenizer: Bloodhound.tokenizers.whitespace,
//         queryTokenizer: Bloodhound.tokenizers.whitespace,
//         // url points to a json file that contains an array of country names, see
//         prefetch: 'https://raw.githubusercontent.com/twitter/typeahead.js/gh-pages/data/countries.json'
//     });
//
//     // passing in `null` for the `options` arguments will result in the default
//     // options being used
//     $('#prefetch').typeahead(null, {
//         name: 'countries',
//         source: countries
//     });
//
//     // remote
//     // ------
//
//     var bestPictures = new Bloodhound({
//         datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
//         queryTokenizer: Bloodhound.tokenizers.whitespace,
//         prefetch: 'https://raw.githubusercontent.com/twitter/typeahead.js/gh-pages/data/films/post_1960.json',
//         remote: {
//             url: '../plugins/typeahead/data/%QUERY.json',
//             wildcard: '%QUERY'
//         }
//     });
//
//     $('#remote').typeahead(null, {
//         name: 'best-pictures',
//         display: 'value',
//         source: bestPictures
//     });
//
//     // default suggestions
//     // -------------------
//
//     var nflTeams = new Bloodhound({
//         datumTokenizer: Bloodhound.tokenizers.obj.whitespace('team'),
//         queryTokenizer: Bloodhound.tokenizers.whitespace,
//         identify: function (obj) {
//             return obj.team;
//         },
//         prefetch: 'https://raw.githubusercontent.com/twitter/typeahead.js/gh-pages/data/nfl.json'
//     });
//
//     function nflTeamsWithDefaults(q, sync) {
//         if (q === '') {
//             sync(nflTeams.get('Detroit Lions', 'Green Bay Packers', 'Chicago Bears'));
//         } else {
//             nflTeams.search(q, sync);
//         }
//     }
//
//     $('#default-suggestions').typeahead({
//         minLength: 0,
//         highlight: true
//     },
//         {
//             name: 'nfl-teams',
//             display: 'team',
//             source: nflTeamsWithDefaults
//         });
//
//     // custom templates
//     // ----------------
//
//     $('#custom-templates').typeahead(null, {
//         name: 'best-pictures',
//         display: 'value',
//         source: bestPictures,
//         templates: {
//             empty: [
//                 '<div class="typeahead-empty-message">',
//                 'Unable to find any Best Picture winners that match the current query',
//                 '</div>'
//             ].join('\n'),
//             suggestion: Handlebars.compile('<div><strong>{{value}}</strong> - {{year}}</div>')
//         }
//     });
//
//     // multiple datasets
//     // -----------------
//
//     var nbaTeams = new Bloodhound({
//         datumTokenizer: Bloodhound.tokenizers.obj.whitespace('team'),
//         queryTokenizer: Bloodhound.tokenizers.whitespace,
//         prefetch: 'https://raw.githubusercontent.com/twitter/typeahead.js/gh-pages/data/nba.json'
//     });
//
//     var nhlTeams = new Bloodhound({
//         datumTokenizer: Bloodhound.tokenizers.obj.whitespace('team'),
//         queryTokenizer: Bloodhound.tokenizers.whitespace,
//         prefetch: 'https://raw.githubusercontent.com/twitter/typeahead.js/gh-pages/data/nhl.json'
//     });
//
//     $('#multiple-datasets').typeahead({
//         highlight: true
//     },
//         {
//             name: 'nba-teams',
//             display: 'team',
//             source: nbaTeams,
//             templates: {
//                 header: '<h5 class="league-name">NBA Teams</h5>'
//             }
//         },
//         {
//             name: 'nhl-teams',
//             display: 'team',
//             source: nhlTeams,
//             templates: {
//                 header: '<h5 class="league-name">NHL Teams</h5>'
//             }
//         });
//
// });
//

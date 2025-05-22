/**
 * Theme: Attex - Responsive Bootstrap 5 Admin Dashboard
 * Author: Coderthemes
 * Module/App: Dashboard
 */

import 'moment/src/moment.js';
import 'daterangepicker/daterangepicker.js';

import ApexCharts from 'apexcharts/dist/apexcharts.min.js';

import 'admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js';
import 'admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js';

! function ($) {
  "use strict";

  var Dashboard = function () {
    this.$body = $("body"),
      this.charts = []
  };


  Dashboard.prototype.initCharts = function () {
    window.Apex = {
      chart: {
        parentHeightOffset: 0,
        toolbar: {
          show: false
        }
      },
      grid: {
        padding: {
          left: 0,
          right: 0
        }
      },
      colors: ["#3e60d5", "#47ad77", "#fa5c7c", "#ffbc00"],
    };

    // --------------------------------------------------
    var colors = ["#3e60d5", "#47ad77"];
    var dataColors = $("#widget-customers").data('colors');
    if (dataColors) {
      colors = dataColors.split(",");
    }
    var options = {
      chart: {
        height: 72,
        width: 72,
        type: 'donut',
      },
      legend: {
        show: false
      },
      plotOptions: {
        pie: {
          donut: {
            size: '80%'
          }
        }
      },
      stroke: {
        colors: ['transparent']
      },
      series: [58, 42],
      dataLabels: {
        enabled: false,
      },
      colors: colors
    }

    var chart = new ApexCharts(
      document.querySelector("#widget-customers"),
      options
    );

    chart.render();

    // --------------------------------------------------
    var colors = ["#3e60d5", "#47ad77"];
    var dataColors = $("#widget-orders").data('colors');
    if (dataColors) {
      colors = dataColors.split(",");
    }
    var options = {
      chart: {
        height: 72,
        width: 72,
        type: 'donut',
      },
      legend: {
        show: false
      },
      stroke: {
        colors: ['transparent']
      },
      plotOptions: {
        pie: {
          donut: {
            size: '80%'
          }
        }
      },
      series: [34, 66],
      dataLabels: {
        enabled: false,
      },
      colors: colors
    }

    var chart = new ApexCharts(
      document.querySelector("#widget-orders"),
      options
    );

    chart.render();

    // --------------------------------------------------
    var colors = ["#3e60d5", "#47ad77"];
    var dataColors = $("#widget-revenue").data('colors');
    if (dataColors) {
      colors = dataColors.split(",");
    }
    var options = {
      chart: {
        height: 72,
        width: 72,
        type: 'donut',
      },
      legend: {
        show: false
      },
      stroke: {
        colors: ['transparent']
      },
      plotOptions: {
        pie: {
          donut: {
            size: '80%'
          }
        }
      },
      series: [87, 13],
      dataLabels: {
        enabled: false,
      },
      colors: colors
    }

    var chart = new ApexCharts(
      document.querySelector("#widget-revenue"),
      options
    );

    chart.render();

    // --------------------------------------------------
    var colors = ["#3e60d5", "#47ad77"];
    var dataColors = $("#widget-growth").data('colors');
    if (dataColors) {
      colors = dataColors.split(",");
    }
    var options = {
      chart: {
        height: 72,
        width: 72,
        type: 'donut',
      },
      legend: {
        show: false
      },
      stroke: {
        colors: ['transparent']
      },
      plotOptions: {
        pie: {
          donut: {
            size: '80%'
          }
        }
      },
      series: [45, 55],
      dataLabels: {
        enabled: false,
      },
      colors: colors
    }

    var chart = new ApexCharts(
      document.querySelector("#widget-growth"),
      options
    );

    chart.render();

    // --------------------------------------------------
    var colors = ["#3e60d5", "#47ad77"];
    var dataColors = $("#widget-conversation").data('colors');
    if (dataColors) {
      colors = dataColors.split(",");
    }
    var options = {
      chart: {
        height: 72,
        width: 72,
        type: 'donut',
      },
      legend: {
        show: false
      },
      stroke: {
        colors: ['transparent']
      },
      plotOptions: {
        pie: {
          donut: {
            size: '80%'
          }
        }
      },
      series: [23, 68],
      dataLabels: {
        enabled: false,
      },
      colors: colors
    }

    var chart = new ApexCharts(
      document.querySelector("#widget-conversation"),
      options
    );

    chart.render();

    var colors = ["#3e60d5", "#47ad77", "#fa5c7c", "#ffbc00"];
    var dataColors = $("#revenue-chart").data('colors');
    if (dataColors) {
      colors = dataColors.split(",");
    }

    var options = {
      series: [{
        name: 'Revenue',
        type: 'column',
        data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
      }, {
        name: 'Sales',
        type: 'line',
        data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16]
      }],
      chart: {
        height: 374,
        type: 'line',
        offsetY: 10
      },
      stroke: {
        width: [2, 3]
      },
      plotOptions: {
        bar: {
          columnWidth: '50%'
        }
      },
      colors: colors,
      dataLabels: {
        enabled: true,
        enabledOnSeries: [1]
      },
      labels: ['01 Jan 2001', '02 Jan 2001', '03 Jan 2001', '04 Jan 2001', '05 Jan 2001', '06 Jan 2001', '07 Jan 2001', '08 Jan 2001', '09 Jan 2001', '10 Jan 2001', '11 Jan 2001', '12 Jan 2001'],
      xaxis: {
        type: 'datetime'
      },
      legend: {
        offsetY: 7,
      },
      grid: {
        padding: {
          bottom: 20
        }
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'light',
          type: "horizontal",
          shadeIntensity: 0.25,
          gradientToColors: undefined,
          inverseColors: true,
          opacityFrom: 0.75,
          opacityTo: 0.75,
          stops: [0, 0, 0]
        },
      },
      yaxis: [{
        title: {
          text: 'Net Revenue',
        },

      }, {
        opposite: true,
        title: {
          text: 'Number of Sales'
        }
      }]
    };

    var chart = new ApexCharts(
      document.querySelector("#revenue-chart"),
      options
    );

    chart.render();

    // --------------------------------------------------
    var colors = ["#3e60d5", "#47ad77", "#fa5c7c", "#ffbc00"];
    var dataColors = $("#average-sales").data('colors');
    if (dataColors) {
      colors = dataColors.split(",");
    }
    var options = {
      chart: {
        height: 286,
        type: 'radialBar',
      },
      plotOptions: {
        radialBar: {
          startAngle: -135,
          endAngle: 135,
          dataLabels: {
            name: {
              fontSize: '14px',
              color: undefined,
              offsetY: 100
            },
            value: {
              offsetY: 55,
              fontSize: '24px',
              color: undefined,
              formatter: function (val) {
                return val + "%";
              }
            }
          },
          track: {
            background: "rgba(170,184,197, 0.2)",
            margin: 0
          },
        }
      },
      fill: {
        gradient: {
          enabled: true,
          shade: 'dark',
          shadeIntensity: 0.2,
          inverseColors: false,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 50, 65, 91]
        },
      },
      stroke: {
        dashArray: 4
      },
      colors: colors,
      series: [67],
      labels: ['Returning Customer'],
      responsive: [{
        breakpoint: 380,
        options: {
          chart: {
            height: 180
          }
        }
      }],
      grid: {
        padding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 0
        }
      }
    }

    var chart = new ApexCharts(
      document.querySelector("#average-sales"),
      options
    );

    chart.render();


    /* ------------- visitors by country */
    var colors = ["#3e60d5", "#47ad77", "#fa5c7c", "#ffbc00"];
    var dataColors = $("#country-chart").data('colors');
    if (dataColors) {
      colors = dataColors.split(",");
    }
    var options = {
      chart: {
        height: 320,
        type: 'bar',
      },
      plotOptions: {
        bar: {
          horizontal: true,
        }
      },
      colors: colors,
      dataLabels: {
        enabled: false
      },
      series: [{
        name: 'Orders',
        data: [90, 75, 60, 50, 45, 36, 28, 20, 15, 12]
      }],
      xaxis: {
        categories: ["India", "China", "United States", "Japan", "France", "Italy", "Netherlands", "United Kingdom", "Canada", "South Korea"],
        axisBorder: {
          show: false,
        },
        labels: {
          formatter: function (val) {
            return val + "%";
          }
        }
      },
      grid: {
        strokeDashArray: [5]
      }
    }

    var chart = new ApexCharts(
      document.querySelector("#country-chart"),
      options
    );

    chart.render();
  },

    // inits the map
    Dashboard.prototype.initMaps = function () {
      //various examples
      if ($('#world-map-markers').length > 0) {
        $('#world-map-markers').vectorMap({
          map: 'world_mill_en',
          normalizeFunction: 'polynomial',
          hoverOpacity: 0.7,
          hoverColor: false,
          regionStyle: {
            initial: {
              fill: 'rgba(145,166,189,.25)'
            }
          },
          markerStyle: {
            initial: {
              r: 9,
              'fill': '#3e60d5',
              'fill-opacity': 0.9,
              'stroke': '#fff',
              'stroke-width': 7,
              'stroke-opacity': 0.4
            },

            hover: {
              'stroke': '#fff',
              'fill-opacity': 1,
              'stroke-width': 1.5
            }
          },
          backgroundColor: 'transparent',
          markers: [{
            latLng: [40.71, -74.00],
            name: 'New York'
          }, {
            latLng: [37.77, -122.41],
            name: 'San Francisco'
          }, {
            latLng: [-33.86, 151.20],
            name: 'Sydney'
          }, {
            latLng: [1.3, 103.8],
            name: 'Singapore'
          }],
          zoomOnScroll: false
        });
      }
    },

    //initializing various components and plugins
    Dashboard.prototype.init = function () {
      var $this = this;
      // font
      // Chart.defaults.global.defaultFontFamily = '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif';

      //default date range picker
      $('#dash-daterange').daterangepicker({
        singleDatePicker: true
      });

      // init charts
      this.initCharts();

      //init maps
      this.initMaps();
    },

    //init flotchart
    $.Dashboard = new Dashboard, $.Dashboard.Constructor = Dashboard
}(window.jQuery),

  //initializing Dashboard
  function ($) {
    "use strict";
    $(document).ready(function (e) {
      $.Dashboard.init();
    });
  }(window.jQuery);

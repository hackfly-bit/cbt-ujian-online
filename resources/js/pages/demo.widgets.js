/**
 * Theme: Attex - Responsive Bootstrap 5 Admin Dashboard
 * Author: Coderthemes
 * Module/App: Widgets
 */

import 'moment/src/moment.js';
import ApexCharts from 'apexcharts/dist/apexcharts.min.js';

import './component.todo'
import './component.chat'

Apex.grid = {
  padding: {
    right: 0,
    left: 0
  }
}

Apex.dataLabels = {
  enabled: false
}

//
// Campaign Sent Chart
//
var colors = ["#3e60d5"];
var dataColors = $("#campaign-sent-chart").data('colors');
if (dataColors) {
  colors = dataColors.split(",");
}
var options1 = {
  chart: {
    type: 'bar',
    height: 60,
    sparkline: {
      enabled: true
    }
  },
  plotOptions: {
    bar: {
      columnWidth: '60%'
    }
  },
  colors: colors,
  series: [{
    data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54]
  }],
  labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
  xaxis: {
    crosshairs: {
      width: 1
    },
  },
  tooltip: {
    fixed: {
      enabled: false
    },
    x: {
      show: false
    },
    y: {
      title: {
        formatter: function (seriesName) {
          return ''
        }
      }
    },
    marker: {
      show: false
    }
  }
}

new ApexCharts(document.querySelector("#campaign-sent-chart"), options1).render();


//
// New Leads Chart
//
var colors = ["#3e60d5"];
var dataColors = $("#new-leads-chart").data('colors');
if (dataColors) {
  colors = dataColors.split(",");
}
var options2 = {
  chart: {
    type: 'line',
    height: 60,
    sparkline: {
      enabled: true
    }
  },
  series: [{
    data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54]
  }],
  stroke: {
    width: 2,
    curve: 'smooth'
  },
  markers: {
    size: 0
  },
  colors: colors,
  tooltip: {
    fixed: {
      enabled: false
    },
    x: {
      show: false
    },
    y: {
      title: {
        formatter: function (seriesName) {
          return ''
        }
      }
    },
    marker: {
      show: false
    }
  }
}


new ApexCharts(document.querySelector("#new-leads-chart"), options2).render();


//
// Deals Charts
//
var colors = ["#3e60d5"];
var dataColors = $("#deals-chart").data('colors');
if (dataColors) {
  colors = dataColors.split(",");
}
var options3 = {
  chart: {
    type: 'bar',
    height: 60,
    sparkline: {
      enabled: true
    }
  },
  plotOptions: {
    bar: {
      columnWidth: '60%'
    }
  },
  colors: colors,
  series: [{
    data: [12, 14, 2, 47, 42, 15, 47, 75, 65, 19, 14]
  }],
  labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
  xaxis: {
    crosshairs: {
      width: 1
    },
  },
  tooltip: {
    fixed: {
      enabled: false
    },
    x: {
      show: false
    },
    y: {
      title: {
        formatter: function (seriesName) {
          return ''
        }
      }
    },
    marker: {
      show: false
    }
  }
}


new ApexCharts(document.querySelector("#deals-chart"), options3).render();

//
// Booked Revenue Chart
//
var colors = ["#3e60d5"];
var dataColors = $("#booked-revenue-chart").data('colors');
if (dataColors) {
  colors = dataColors.split(",");
}
var options4 = {
  chart: {
    type: 'line',
    height: 60,
    sparkline: {
      enabled: true
    }
  },
  plotOptions: {
    bar: {
      columnWidth: '60%'
    }
  },
  colors: colors,
  series: [{
    data: [47, 45, 74, 14, 56, 74, 14, 11, 7, 39, 82]
  }],
  labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
  stroke: {
    width: 2,
    curve: 'smooth'
  },
  markers: {
    size: 0
  },
  colors: colors,
  tooltip: {
    fixed: {
      enabled: false
    },
    x: {
      show: false
    },
    y: {
      title: {
        formatter: function (seriesName) {
          return ''
        }
      }
    },
    marker: {
      show: false
    }
  }
}

new ApexCharts(document.querySelector("#booked-revenue-chart"), options4).render();

/**
 * Theme: Attex - Responsive Bootstrap 5 Admin Dashboard
 * Author: Coderthemes
 * Module/App: Data tables
 */


import DataTable from "datatables.net";
$.fn.dataTable = DataTable;

import "datatables.net-bs5";
// import "datatables.net-buttons/js/buttons.flash";

$(document).ready(function () {
  "use strict";

  new DataTable('#basic-datatable', {
    keys: true,
    language: {
      "paginate": {
        "previous": "<i class='ri-arrow-left-s-line'>",
        "next": "<i class='ri-arrow-right-s-line'>"
      }
    },
    drawCallback: function () {
      $('#basic-datatable_paginate').addClass('pagination-rounded');
    }
  });

  //Buttons examples
  new DataTable('#datatable-buttons', {
    lengthChange: false,
    buttons: ['copy', 'print'],
    "language": {
      "paginate": {
        "previous": "<i class='ri-arrow-left-s-line'>",
        "next": "<i class='ri-arrow-right-s-line'>"
      }
    },
    "drawCallback": function () {
      $('#basic-datatable_paginate').addClass('pagination-rounded');
    }
  });

  // Multi Selection Datatable
  new DataTable('#selection-datatable', {
    select: {
      style: 'multi'
    },
    "language": {
      "paginate": {
        "previous": "<i class='ri-arrow-left-s-line'>",
        "next": "<i class='ri-arrow-right-s-line'>"
      }
    },
    "drawCallback": function () {
      $('#basic-datatable_paginate').addClass('pagination-rounded');
    }
  });




  // Alternative Pagination Datatable
  new DataTable('#alternative-page-datatable', {
    "pagingType": "full_numbers",
    "drawCallback": function () {
      $('#basic-datatable_paginate').addClass('pagination-rounded');
    }
  });

  // Scroll Vertical Datatable
  new DataTable('#scroll-vertical-datatable', {
    "scrollY": "350px",
    "scrollCollapse": true,
    "paging": false,
    "language": {
      "paginate": {
        "previous": "<i class='ri-arrow-left-s-line'>",
        "next": "<i class='ri-arrow-right-s-line'>"
      }
    },
    "drawCallback": function () {
      $('#basic-datatable_paginate').addClass('pagination-rounded');
    }
  });

  // Scroll Vertical Datatable
  new DataTable('#scroll-horizontal-datatable', {
    "scrollX": true,
    "language": {
      "paginate": {
        "previous": "<i class='ri-arrow-left-s-line'>",
        "next": "<i class='ri-arrow-right-s-line'>"
      }
    },
    "drawCallback": function () {
      $('#basic-datatable_paginate').addClass('pagination-rounded');
    }
  });

  // Complex headers with column visibility Datatable
  new DataTable('#complex-header-datatable', {
    "language": {
      "paginate": {
        "previous": "<i class='ri-arrow-left-s-line'>",
        "next": "<i class='ri-arrow-right-s-line'>"
      }
    },
    "drawCallback": function () {
      $('#basic-datatable_paginate').addClass('pagination-rounded');
    },
    "columnDefs": [{
      "visible": false,
      "targets": -1
    }]
  });

  // Row created callback Datatable
  new DataTable('#row-callback-datatable', {
    "language": {
      "paginate": {
        "previous": "<i class='ri-arrow-left-s-line'>",
        "next": "<i class='ri-arrow-right-s-line'>"
      }
    },
    "drawCallback": function () {
      $('#basic-datatable_paginate').addClass('pagination-rounded');
    },
    "createdRow": function (row, data, index) {
      if (data[5].replace(/[\$,]/g, '') * 1 > 150000) {
        $('td', row).eq(5).addClass('text-danger');
      }
    }
  });

  // State Saving Datatable
  new DataTable('#state-saving-datatable', {
    stateSave: true,
    "language": {
      "paginate": {
        "previous": "<i class='ri-arrow-left-s-line'>",
        "next": "<i class='ri-arrow-right-s-line'>"
      }
    },
    "drawCallback": function () {
      $('#basic-datatable_paginate').addClass('pagination-rounded');
    }
  });

  // Fixed header Datatable
  // new DataTable('#fixed-header-datatable', {
  //   fixedHeader: true,
  // });

  // Fixed Columns Datatable
  new DataTable('#fixed-columns-datatable', {
    scrollY: 300,
    scrollX: true,
    scrollCollapse: true,
    paging: false,
    fixedColumns: true
  });

  $(".dataTables_length select").addClass('form-select form-select-sm');
  $(".dataTables_length label").addClass('form-label');

  var table = new DataTable('#fixed-header-datatable', {
    responsive: true,
    "language": {
      "paginate": {
        "previous": "<i class='ri-arrow-left-s-line'>",
        "next": "<i class='ri-arrow-right-s-line'>"
      }
    },
    "drawCallback": function () {
      $('#basic-datatable_paginate').addClass('pagination-rounded');
    }
  });

  // table.buttons().container()
  //   .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

  // new $.fn.dataTable.FixedHeader(table);

});

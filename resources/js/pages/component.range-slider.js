/*
* Theme: Attex - Responsive Bootstrap 5 Admin Dashboard
* Author: Coderthemes
* Component: Range Slider init js
*/

import 'ion-rangeslider/js/ion.rangeSlider.min.js';

!function ($) {
  "use strict";

  var RangeSlider = function () {
    this.$body = $("body")
  };


  /* Initializing */
  RangeSlider.prototype.init = function () {
    $('[data-plugin="range-slider"]').each(function () {
      var opts = $(this).data();
      $(this).ionRangeSlider(opts);
    });
  },

    //init RangeSlider
    $.RangeSlider = new RangeSlider, $.RangeSlider.Constructor = RangeSlider

}(window.jQuery),

  //initializing RangeSlider
  function ($) {
    "use strict";
    $.RangeSlider.init()
  }(window.jQuery);
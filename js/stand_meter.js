function recalculateStandMeter() {
      if ($('tera_value') && $('begin_stand_meter') && !isNaN($('tera_value').value) && !isNaN($('begin_stand_meter').value)) {
          
          var total_value = parseInt($('begin_stand_meter').value) + parseInt($('tera_value').value);
          $('begin_stand_meter').value = parseInt(total_value);
      }
}
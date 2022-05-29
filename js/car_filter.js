$(document).ready(function() {
  if($("#year, #year2").val() == "") {
    $("#filter_car, #filter_car2").attr("disabled", "disabled");
  }

  $("#year").change(function() {
    if($("#year").val()) {
      var $year = $("#year").find(":selected").val();
      var $make = $("#make");
      var prevMake = "";

      $.getJSON('/get_models.php', {year: $year}, function(dat) {
        $make.empty();
        $.each(dat, function(){
          if(this.make != prevMake) {
            $make.append($("<option />").val(this.make).text(this.make));
          }
          prevMake = this.make;
        });

        $make.change(function() {
          $make = $("#make").find(":selected").text();
         
          var $model = $("#model");
          $model.empty();
         
          $.each(dat, function() {
        	  
            if(this.make == $make) {
              $model.append($("<option />").val(this.model).text(this.model));
            }
          });
        });

        $("#make").trigger("change");

        $("#model").trigger("change");
      });

      $("#filter_car").attr("disabled", false);
    }

    else {
      $('#make').html('<option>Select Make</option>');
      $('#model').html('<option>Select Model</option>');
      $("#filter_car").attr("disabled", "disabled");
    }
  });







  $("#year2").change(function() {
    if($("#year2").val()) {
      var $year2 = $("#year2").find(":selected").val();
      var $make2 = $("#make2");
      var prevMake = "";

      $.getJSON('/get_models.php', {year: $year2}, function(dat) {
        $make2.empty();
        $.each(dat, function(){
          if(this.make != prevMake) {
            $make2.append($("<option />").val(this.make).text(this.make));
          }
          prevMake = this.make;
        });

        $make2.change(function() {
          $make2 = $("#make2").find(":selected").text();
          var $model2 = $("#model2");
          $model2.empty();

          $.each(dat, function() {
            if(this.make == $make2) {
              $model2.append($("<option />").val(this.model).text(this.model));
            }
          });
        });

        $("#make2").trigger("change");

        $("#model2").trigger("change");
      });

      $("#filter_car2").attr("disabled", false);
    }

    else {
      $('#make2').html('<option>Make</option>');
      $('#model2').html('<option>Model</option>');
      $("#filter_car2").attr("disabled", "disabled");
    }
  });

  

  

 /* $(window).on('load resize', function() {
    if ( $(window).width() <= 460 ) {
    $('#subm').prop('value', '');
    }

    else {
      $('#subm').prop('value', 'SEARCH');
    }
  }); */
});
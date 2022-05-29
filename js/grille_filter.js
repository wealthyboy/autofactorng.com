$(document).ready(function() {
  if($("#grille_make").val() == "") {
    $("#filter_grille").attr("disabled", "disabled");
  }

  $("#grille_make").one('change', function() {
    $(this).children().first().remove();
  });

  $("#grille_make").change(function() {
    if($("#grille_make").val()) {
      var $make = $("#grille_make").find(":selected").val();
      var $model = $("#grille_model");
      var $grille_option = $("#grille_option").val();
      var prevModel = "";

      $.getJSON('/grille_search.php', {'grille-make': $make, 'grille-option': $grille_option}, function(dat) {
        //console.log(dat);
        $model.empty();
        $.each(dat, function(){
          if(this.model != prevModel) {
            $model.append($("<option />").val(this.model).text(this.model));
          }
          prevModel = this.model;
        });

        $("#grille_model").trigger("change");

        $("#filter_grille").attr("disabled", false);
      });
    }

    else {
      $('#grille_make').html('<option>Select Make</option>');
      $('#grille_model').html('<option>Select Model</option>');
      $("#filter_grille").attr("disabled", "disabled");
    }
  });
});
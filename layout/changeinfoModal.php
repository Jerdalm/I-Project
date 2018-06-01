<!-- Modal -->
<div class="modal fade" id="changeInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Info bijwerken</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= print_r($gebruiker); ?>
      <!-- echo om alle data in een formulier te zetten en te zorgen dat de gegevens aangepast kunnen worden. -->
            <form method="get" class="form-group col-lg-12 edit-user-info">  
                <?php  foreach ($gebruiker as $key => $value) { 
                    echo '<label><b>'.$key.'</b></label>';
                    switch ($key) {
                        case 'geboortedag':
                        echo '<input class="form-control" type="date" name="' . $key . '" value="'. $value .'" required><br>';
                        break;
                        case 'gebruikersnaam':
                        echo '<input class="form-control" type="text" name="' . $key . '" value="'. $value .'" readonly><br>';
                        break;
                        case 'telefoonnummer':
                      
                        break;
                        case 'adresregel2':
                        echo '<input class="form-control" type="text" name="' . $key . '" value="'. $value .'"><br>';
                        break;
                        default:
                        echo '<input class="form-control" type="text" name="' . $key . '" value="'. $value .'" required><br>';
                        break;
                    }
                } 
                ?>
                <div class="input_fields_wrap">
                <?php
                $increment = 0;
                        foreach($telefoonnummers as $nummer){
                         echo '
                              <div><input value="'.$nummer[0]. '" class="form-control" type="text" name="telefoonnummer'.$increment .'"></div>
                              ';
                              $increment++;
                        }
                ?>
                </div>              
                <button class="add_field_button btn btn-orange">Add More Fields</button>
                    

      </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
        <button type="submit" class="btn btn-primary" name="bijwerken">Bijwerken</button>
      </div>
	  </form>
	</form>
    </div>
  </div>
</div>
<script>

$(document).ready(function() {
    var max_fields      = 4 - <?= $aantalTelefoonNummers ?>; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    var counter         = <?= $increment ?>;
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="input-group"><input type="text" class=form-control name="telefoonnummer'+ counter +
			'"/><div class="input-group-append"><a href="#" class="remove_field btn btn-danger"><i class="fas fa-times"></i></a> </div></div>'); //add input box
            counter++;
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
        counter--;
    })
});

</script>



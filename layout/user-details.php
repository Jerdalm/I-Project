         <div class="tab-pane fade show active" id="content-user-details" role="tabpanel" aria-labelledby="list-user-details">
		<?php if(!isset($_GET['changeInfo'])) {?>
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><h3>Gebruikersgegevens</h3></div>
		<div class="row">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-0 "></div>
        <div id="detailsTabel" class="text-center col-lg-8 float-left">
            <!-- alle gegevens van de gebruiker worden met een echo in een tabel gezet -->
			
            <table class="table-striped table table-user-details"> 
                <tbody>
                    <?php foreach($gebruiker as $key => $info ){
                   
                        echo "<tr>" . "<th scope='col'>" . $key . "</th" . "</tr>";
                        echo "<td>" . $info . "</td>";
                     } ?>
                     <tr>
                        <th>Wachtwoord</th>
                        <td><a href="?&changePass=ok"> <b><i>Wachtwoord Wijzigen</a></i></b></td>
                    </tr>
                    <tr> 
                        <td><a href="?&changeInfo=ok"> <b>Info Bewerken</a></b></td>   
                    </tr>
                </tbody>
            </table>
            <A href="upgrade-user.php" class="cta-orange btn">Upgrade account</A>
			
        </div>
		<div class="col-lg-2"></div>
		</div>
        <?php } if(isset($_GET['changePass'])){ ?>
            <div class="formWachtwoordHuidig col-md-4 row">
                <form method="POST" class="form-steps" action="">
                    <div class="form-group">
                        <label for="testvoorvraag"> Huidig Wachtwoord </label>
                        <input type="password" name="huidigWachtwoord" class="form-control" id="testAntwoordvakje" placeholder="Voer hier uw huidige wachtwoord in">
                    </div>
                    <div class="form-group">
                        <label for="registration-password">Wachtwoord</label>
                        <input type="password" placeholder="Voer uw nieuwe wachtwoord in" class="form-control" name="password" id="registration-password">
                    </div>
                    <div class="form-group">
                        <label for="password-repeat">Herhaal wachtwoord</label>
                        <input type="password" class="form-control" placeholder="Herhaal uw nieuwe wachtwoord" name="password-repeat" id="password-repeat">
                    </div>
                    <button type="submit" name="submit-new-password" value="Register" class="btn btn-primary btn-sm">Verzenden</button>
                </form>
            </div>
            <?php 
            echo '<p class="error error-warning">';
            if (isset($messageNewPass)){
                echo $messageNewPass;
            }
            echo '</p>';
        } else if (isset($_GET['changeInfo'])){ ?>
            <form method="get" class="form-group edit-user-info">  
                <?php  foreach ($gebruiker as $key => $value) { 
                    echo '<label><b>'.$key.'</b></label>';
                    switch ($key) {
                        case 'geboortedag':
                        echo '<input type="date" name="' . $key . '" value="'. $value .'"><br>';
                        break;
                        case 'gebruikersnaam':
                        echo '<input type="text" name="' . $key . '" value="'. $value .'" readonly><br>';
                        break;
                        case 'telefoonnummer':
                        echo '<input type="tel" name="' . $key . '" value="'. $value .'"><br>';
                        break;
                        default:
                        echo '<input type="text" name="' . $key . '" value="'. $value .'"><br>';
                        break;
                    }
                } ?>
                    <button type="submit" class="btn btn-primary btn-sm" name="bijwerken">Bijwerken</button>
            </form>
            <?php
        } else if (isset($_GET['bijwerken'])) {
           UpdateInfoUser($_GET, $gebruikersnaam);
       }?> 
	   </div>
<?php

session_start();
if(!isset($_SESSION['idUser'])){ exit; }

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";
include_once($_SERVER['DOCUMENT_ROOT']."/scripts/connectBDD.php");

function chargerClasse($classname){ require $_SERVER['DOCUMENT_ROOT']."/classes/class.".$classname.".php"; }
spl_autoload_register('chargerClasse');

$categorieManager = new CategorieManager($db);

$arrayCategories = $categorieManager->getAllCategoriesFromUser($_SESSION['idUser']);

?>
<script type="text/javascript">
function verifFormAjoutRevenus(form){

    if(!form.prix.value){ return false;}
    if(!form.idCategorie.value){ return false;}
    if(!form.date.value){ return false;}

	var dataToInsert = new Object();
	dataToInsert.prix = form.prix.value;
    dataToInsert.commentaire = form.commentaire.value;
    dataToInsert.idCategorie = form.idCategorie.value;
    dataToInsert.date = form.date.value;

	var requestAjax = $.ajax({
		url: "./modules/transactions/msgBox/scripts/addRevenus.php",
		type: "POST",
		data: dataToInsert,
		dataType: 'json',
		cache: false,
		async:false
	});
	
	requestAjax.done(function(data){
		window.location.reload();
	})	
	
	return false;
}
</script>
<div class="msgBox">
    <div class="titre">Ajout d'un revenus</div>
    <form class="form-horizontal" onsubmit="return verifFormAjoutRevenus(this)">
        <fieldset>
            <div class="control-group required">
                <label class="control-label" for="prix" style="width:auto; float:none;">Prix</label>
                <div class="controls" style="margin:0;">
                    <input name="prix" style="width:456px; resize: none;" required/>
                </div>			
            </div> 
            <div class="control-group required">
                <label class="control-label" for="date" style="width:auto; float:none;">Date</label>
                <div class="controls" style="margin:0;">
                    <input type="date" name="date" style="width:456px; resize: none;" required/>
                </div>			
            </div> 
            <div class="control-group required">
                <label class="control-label" for="commentaire" style="width:auto; float:none;">Commentaire</label>
                <div class="controls" style="margin:0;">
                    <textarea name="commentaire" rows="5" placeholder="ajouter une description ici" style="width:456px; resize: none;"></textarea>
                </div>			
            </div>  
            <div class="control-group required">
                <label class="control-label" for="idCategorie" style="width:auto; float:none;">Cat??gorie</label>
                <div class="controls" style="margin:0;">
                    <select name="idCategorie" style="width:456px; resize: none;">
                        <option value="">Choisir</option> 
                        <?php
							foreach($arrayCategories['result'] as $categorie){
								echo '<option value="'.$categorie->getId().'">'.$categorie->getIntitule().'</option> ';	 
							}
						?>
                    </select>
                </div>			
            </div>
            <div class="boutons center">
                <button type="button" class="btn" onclick="closeMsgBox()">Annuler</button>
                <button type="submit" class="btn btn-info" name="valider">Valider</button>
            </div>
        </fieldset>
    </form>
</div>
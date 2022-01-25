<?php

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";
include_once($_SERVER['DOCUMENT_ROOT']."/scripts/connectBDD.php");

function chargerClasse($classname){ require $_SERVER['DOCUMENT_ROOT']."/classes/class.".$classname.".php"; }
spl_autoload_register('chargerClasse');

$categorieManager = new CategorieManager($db);

$arrayCategories = $categorieManager->getAllCategoriesFromUser($_GET['idUser']);

?>
<script type="text/javascript">
function verifFormAjoutDepense(form){

    if(!form.prix.value){ return false;}
    if(!form.idCategorie.value){ return false;}

	var dataToInsert = new Object();
	dataToInsert.prix = form.prix.value;
    dataToInsert.commentaire = form.commentaire.value;
    dataToInsert.idCategorie = form.idCategorie.value;

	var requestAjax = $.ajax({
		url: "./modules/transactions/msgBox/scripts/addDepense.php",
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
    <div class="titre">Ajout d'une dépense</div>
    <form class="form-horizontal" onsubmit="return verifFormAjoutDepense(this)">
        <fieldset>
            <div class="control-group required">
                <label class="control-label" for="prix" style="width:auto; float:none;">Prix</label>
                <div class="controls" style="margin:0;">
                    <input name="prix" style="width:456px; resize: none;" required/>
                </div>			
            </div> 
            <div class="control-group required">
                <label class="control-label" for="commentaire" style="width:auto; float:none;">Commentaire</label>
                <div class="controls" style="margin:0;">
                    <textarea name="commentaire" rows="5" placeholder="ajouter une description ici" style="width:456px; resize: none;"></textarea>
                </div>			
            </div>  
            <div class="control-group required">
                <label class="control-label" for="idCategorie" style="width:auto; float:none;">Catégorie</label>
                <div class="controls" style="margin:0;">
                    <select name="idCategorie" style="width:456px; resize: none;">
                        <option value="">Choisir</option> 
                        <?php
							foreach($arrayCategories as $categorie){
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
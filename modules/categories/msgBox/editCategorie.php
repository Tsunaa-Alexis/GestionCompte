<?php

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";
include_once($_SERVER['DOCUMENT_ROOT']."/scripts/connectBDD.php");

function chargerClasse($classname){ require $_SERVER['DOCUMENT_ROOT']."/classes/class.".$classname.".php"; }
spl_autoload_register('chargerClasse');

$categorieManager = new CategorieManager($db);

$categorie = $categorieManager->getCategorie($_GET['idCategorie']);

?>
<script type="text/javascript">
function verifFormAjoutCategorie(form){

    if(!form.intitule.value){ return false;}

	var dataToInsert = new Object();
	dataToInsert.intitule = form.intitule.value;
    dataToInsert.description = form.description.value;
    dataToInsert.idCategorie = <?=$_GET['idCategorie']?>;

	var requestAjax = $.ajax({
		url: "./modules/categories/msgBox/scripts/editCategorie.php",
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
    <div class="titre">Modification d'une catégorie</div>
    <form class="form-horizontal" onsubmit="return verifFormAjoutCategorie(this)">
        <fieldset>
            <div class="control-group required">
                <label class="control-label" for="intitule" style="width:auto; float:none;">Intitule</label>
                <div class="controls" style="margin:0;">
                    <input name="intitule" style="width:456px; resize: none;" value="<?=$categorie->getIntitule()?>" required/>
                </div>			
            </div> 
            <div class="control-group required">
                <label class="control-label" for="description" style="width:auto; float:none;">Description</label>
                <div class="controls" style="margin:0;">
                    <textarea name="description" rows="5" placeholder="ajouter une description ici" style="width:456px; resize: none;"><?=$categorie->getDescription()?></textarea>
                </div>			
            </div>  
            <div class="boutons center">
                <button type="button" class="btn" onclick="closeMsgBox()">Annuler</button>
                <button type="submit" class="btn btn-info" name="valider">Valider</button>
            </div>
        </fieldset>
    </form>
</div>
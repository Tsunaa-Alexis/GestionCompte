<?php

$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/GestionCompte";
include_once($_SERVER['DOCUMENT_ROOT']."/scripts/connectBDD.php");

function chargerClasse($classname){ require $_SERVER['DOCUMENT_ROOT']."/classes/class.".$classname.".php"; }
spl_autoload_register('chargerClasse');

$transactionManager = new TransactionManager($db);
$categorieManager = new CategorieManager($db);

$transaction = $transactionManager->getTransaction($_GET['idTransaction']);

$arrayCategories = $categorieManager->getAllCategoriesFromUser($_GET['idUser']);

?>
<script type="text/javascript">
function verifFormAjoutRevenus(form){

    if(!form.prix.value){ return false;}
    if(!form.idCategorie.value){ return false;}
    if(!form.idTransaction.value){ return false;}

	var dataToInsert = new Object();
	dataToInsert.prix = form.prix.value;
    dataToInsert.commentaire = form.commentaire.value;
    dataToInsert.idCategorie = form.idCategorie.value;
    dataToInsert.idTransaction = form.idTransaction.value;

	var requestAjax = $.ajax({
		url: "./modules/transactions/msgBox/scripts/editTransaction.php",
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
    <div class="titre">Modification d'une transaction</div>
    <form class="form-horizontal" onsubmit="return verifFormAjoutRevenus(this)">
        <input type="hidden" name="idTransaction" value="<?=$_GET['idTransaction']?>"/>
        <fieldset>
            <div class="control-group required">
                <label class="control-label" for="prix" style="width:auto; float:none;">Prix</label>
                <div class="controls" style="margin:0;">
                    <input name="prix" style="width:456px; resize: none;" value="<?=$transaction->getPrix()?>" required/>
                </div>			
            </div> 
            <div class="control-group required">
                <label class="control-label" for="commentaire" style="width:auto; float:none;">Commentaire</label>
                <div class="controls" style="margin:0;">
                    <textarea name="commentaire" rows="5" placeholder="ajouter une description ici" style="width:456px; resize: none;"><?=$transaction->getCommentaire()?></textarea>
                </div>			
            </div>  
            <div class="control-group required">
                <label class="control-label" for="idCategorie" style="width:auto; float:none;">Catégorie</label>
                <div class="controls" style="margin:0;">
                    <select name="idCategorie" style="width:456px; resize: none;">
                        <option value="">Choisir</option> 
                        <?php
							foreach($arrayCategories['result'] as $categorie){ ?>
								<option value="<?=$categorie->getId()?>" <?=($categorie->getId() === $transaction->getCategorie()->getId())?'selected':''?>><?=$categorie->getIntitule()?></option>	 
						<?php } ?>
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
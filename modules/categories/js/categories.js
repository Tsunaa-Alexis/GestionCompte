function msgBoxAddCategorie(idUser){
	
	fancyboxParams = fancyboxDefaults;
	fancyboxParams.type = 'ajax';
	fancyboxParams.href = './modules/categories/msgBox/addCategorie.php?idUser='+idUser;
	
	$.fancybox.open(fancyboxParams);
	
}

function msgBoxEditCategorie(idCategorie, idUser){
	
	fancyboxParams = fancyboxDefaults;
	fancyboxParams.type = 'ajax';
	fancyboxParams.href = './modules/categories/msgBox/editCategorie.php?idCategorie='+idCategorie+'&idUser='+idUser;
	
	$.fancybox.open(fancyboxParams);
	
}

function suppCategorie(idCategorie){

    if(!idCategorie){ return false; }

    var dataToInsert = new Object();
	dataToInsert.idCategorie = idCategorie;
	
	var requestAjaxCombo = $.ajax({
	  url: "./modules/categories/scripts/suppCategorie.php",
	  type: "POST",
	  data: dataToInsert,
	  dataType: 'json',
	  cache: false,
	  async:true
	});
	
	requestAjaxCombo.done(function(data){
        window.location.reload();
	});

    return false;

}
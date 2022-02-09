function msgBoxAddDepense(idUser){
	
	fancyboxParams = fancyboxDefaults;
	fancyboxParams.type = 'ajax';
	fancyboxParams.href = './modules/transactions/msgBox/addDepense.php?idUser='+idUser;
	
	$.fancybox.open(fancyboxParams);
	
}

function msgBoxAddRevenus(){
	
	fancyboxParams = fancyboxDefaults;
	fancyboxParams.type = 'ajax';
	fancyboxParams.href = './modules/transactions/msgBox/addRevenus.php';
	
	$.fancybox.open(fancyboxParams);
	
}

function msgBoxEditTransaction(idTransaction){
	
	fancyboxParams = fancyboxDefaults;
	fancyboxParams.type = 'ajax';
	fancyboxParams.href = './modules/transactions/msgBox/editTransaction.php?idTransaction='+idTransaction;
	
	$.fancybox.open(fancyboxParams);
	
}

function suppTransaction(idTransaction){

    if(!idTransaction){ return false; }

    var dataToInsert = new Object();
	dataToInsert.idTransaction = idTransaction;
	
	var requestAjaxCombo = $.ajax({
	  url: "./modules/transactions/scripts/suppTransaction.php",
	  type: "POST",
	  data: dataToInsert,
	  dataType: 'json',
	  cache: false,
	  async:true
	});
	
	requestAjaxCombo.done(function(data){
		if(data === false){ return false; }
        window.location.reload();
	});

    return false;

}




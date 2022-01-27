function verifForm(form){

    $('form').addClass("was-validated")

    if(!form.mail.value){ return false; }
    if(!form.motdepasse.value){ return false; }

	var dataToInsert = new Object();
	dataToInsert.mail = form.mail.value;
	dataToInsert.mdp = form.motdepasse.value;
	
	var requestAjaxCombo = $.ajax({
	  url: "./scripts/login.php",
	  type: "POST",
	  data: dataToInsert,
	  dataType: 'json',
	  cache: false,
	  async:true
	});
	
	requestAjaxCombo.done(function(data){

        if(data === true){
            window.location.replace("./");
        }
        if(data === false){ 
            $(".popUp").removeClass('hide')
            return false;
        }

	});

    return false;
	
}
function verifForm(form){

    $('form').addClass("was-validated")
    $(".email.invalid-feedback").text("Vous devez fournir un email valide.")

    if(!form.nom.value){ return false; }
    if(!form.prenom.value){ return false; }
    if(!form.mail.value){ return false; }
    if(!form.motdepasse1.value){ return false; }

	var dataToInsert = new Object();
	dataToInsert.nom = form.nom.value;
	dataToInsert.prenom = form.prenom.value;
	dataToInsert.mail = form.mail.value;
	dataToInsert.mdp = form.motdepasse1.value;
	dataToInsert.numTel = form.numTel.value;
	
	var requestAjaxCombo = $.ajax({
	  url: "./scripts/addUser.php",
	  type: "POST",
	  data: dataToInsert,
	  dataType: 'json',
	  cache: false,
	  async:true
	});
	
	requestAjaxCombo.done(function(data){

        if(data.emailPresent === true){
            $("input[name=mail]").val("")
            $(".email.invalid-feedback").text("Cette email est déjà utilisé")
            return false;
        }

        window.location.replace("./?action=login");

	});

    return false;
	
}
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawCharts);

function drawCharts() {
	
	let requestAjaxCombo = $.ajax({
	  url: "./modules/statistiques/json/datasForCharts.php",
	  type: "POST",
	  dataType: 'json',
	  cache: false,
	  async:true
	});
	
	requestAjaxCombo.done(function(data){
        
        // let dateDebut = 1642929562
        // let dateFin = 1643361562

        var dateDebut = new Date(1642929562000);
		var dateFin = new Date(1643361562000);
        let arrayDatas = []

		while (dateDebut <= dateFin){

			if(dateDebut.getDay() == 0 || dateDebut.getDay() == 6){
				dateDebut.setDate(dateDebut.getDate() + 1);
				continue;
			}

			var day = dateDebut.getDate()
			var month = dateDebut.getMonth() + 1
			var year = dateDebut.getFullYear()

			if(day < 10){ day = '0' + day; }
			if(month < 10){ month = '0' + month; }

            arrayDatas[day+'/'+month+'/'+year] = []
            arrayDatas[day+'/'+month+'/'+year].depenses = []
            arrayDatas[day+'/'+month+'/'+year].revenus = []

            if(data[day+'/'+month+'/'+year]){
                arrayDatas[day+'/'+month+'/'+year] = data[day+'/'+month+'/'+year]
            }

			dateDebut.setDate(dateDebut.getDate() + 1);

		}
        
        chartDepensesRevenus(arrayDatas)
        chartUniqueDepenseOrRevenus(arrayDatas, 'revenus', 'chart_revenus')
        chartUniqueDepenseOrRevenus(arrayDatas, 'depenses', 'chart_depenses')

         

	});
    
}

function chartDepensesRevenus(arrayDatas){

    if(!arrayDatas){ return false;}

    let arrayForChart = [];
    arrayForChart.push(['day', 'dépenses', 'revenus'])

    for(let day in arrayDatas){

        let totalDepensesDay = 0;
        let totalRevenusDay = 0;
        for(let revenus in arrayDatas[day].revenus){
            totalRevenusDay += parseInt(arrayDatas[day].revenus[revenus].prix,10); 
        }
        for(let depenses in arrayDatas[day].depenses){
            totalDepensesDay += parseInt(arrayDatas[day].depenses[depenses].prix,10); 
        }

        arrayForChart.push([day, totalDepensesDay, totalRevenusDay])

        
    }

    var dataChart = google.visualization.arrayToDataTable(arrayForChart);

    var options = {
    title: 'Stats global',
    hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
    vAxis: {minValue: 0}
    };

    var chart = new google.visualization.AreaChart(document.getElementById('chart_DepensesRevenues'));
    chart.draw(dataChart, options);

}

function chartUniqueDepenseOrRevenus(arrayDatas, type, idChar){

    let arrayCategorie = [];
    let arrayPerDay = [];
    let arrayForChart = [];

    arrayCategorie.push('day')
    for(let day in arrayDatas){

        arrayPerDay[day] = []

        for(let key in arrayDatas[day][type]){

            arrayCategorie.push(arrayDatas[day][type][key].categorie)

            if(arrayPerDay[day][arrayDatas[day][type][key].categorie]){
                arrayPerDay[day][arrayDatas[day][type][key].categorie] += parseInt(arrayDatas[day][type][key].prix,10)
            }
            if(!arrayPerDay[day][arrayDatas[day][type][key].categorie]){
                arrayPerDay[day][arrayDatas[day][type][key].categorie] = parseInt(arrayDatas[day][type][key].prix,10)
            }
            
        }

    }
    
    arrayCategorie = [...new Set(arrayCategorie)]
    arrayForChart.push(arrayCategorie);
    
    for(day in arrayPerDay){

        let arrayTemp = []
        arrayTemp.push(day)
        for(categorie in arrayCategorie){  
            if(arrayCategorie[categorie] === 'day'){ continue }
            if(arrayPerDay[day][arrayCategorie[categorie]]){ arrayTemp.push(arrayPerDay[day][arrayCategorie[categorie]]) }
            if(!arrayPerDay[day][arrayCategorie[categorie]]){ arrayTemp.push(0) }
        }

        arrayForChart.push(arrayTemp);

    }

    var data = google.visualization.arrayToDataTable(arrayForChart);

    var options = {
    title: type,
    width: 600,
    height: 400,
    legend: { position: 'top', maxLines: 1 },
    bar: { groupWidth: '75%' },
    isStacked: true,
    };

    var chart = new google.visualization.ColumnChart(document.getElementById(idChar));
    chart.draw(data, options);    

}
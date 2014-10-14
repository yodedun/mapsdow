var restaurant = getUrlVars()["codpais"];
var employees;
var map;

$(window).load(function() {
	setTimeout(getEmployee, 100);
});

$(document).ajaxError(function(event, request, settings) {
	$('#busy').hide();
	alert("Error accessing the server");
});

function getEmployee() {
		// cargador
	
	$.getJSON('view_json.php?codpais='+restaurant, function(data) {
		// quitar cargador
		
		// leer item de employees
		employees = data.items ;
		$.each(employees, function(index, employee) {
			uno= employee.textCordenadas;
			dos= employee.strName;
			  tres = new google.maps.Polygon({
				    paths: [ 	
	   
				  ],
				    strokeColor: '#FF0000',
				    strokeOpacity: 0.8,
				    strokeWeight: 2,
				    fillColor: '#FF0000',
				    fillOpacity: 0.35
				  });
							
							
		});
		
		        
          
  
		
		
	});
}


        




function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

$(document).ready(function() {

	$(document).keydown("m",function(e){
	
		if(e.ctrlKey) {
		
			$(".jourProf:contains('Bornerie')").slideUp( function() {
			
				$(".jourProf:contains('Bornerie')").slideDown().text("#Censuré#") ;
		
			});
	
		}

	});

	$("tbody tr").find("td:last").css( "border-right-style", "none" );
	
	$("thead tr").find("td:last").css( "border-right-style", "none" );
});



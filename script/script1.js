$(document).ready(function() {

	$(document).keydown("m",function(e){
	
		if(e.ctrlKey) {
		
			$(".jourProf:contains('Bornerie')").slideUp( function() {
			
				$(this).slideDown().text("#Censuré#") ;
		
			})
			
			$(".jourProf:contains('#Censuré#')").slideUp( function() {
			
				$(this).slideDown().text("Bornerie") ;
		
			})
	
		}

	});

	$("tbody tr").find("td:last").css( "border-right-style", "none" );
	
	$("thead tr").find("td:last").css( "border-right-style", "none" );

	if( $("#selectAnnee option:selected").text() == "MMI" ) {
		$("html").css("background-color","#99CC00");
		$("h2").html('<span class="trucUselessMMI">M</span>oderne <span class="trucUselessMMI" >M</span>ignon <span class="trucUselessMMI">I</span>ndépendant');
	}
});



$(document).ready(function() {

	$(document).on('keydown', function(e){

		if(e.ctrlKey && e.which === 77){ 

			$(".jourProf:contains('Bornerie')").slideUp( function() {

				$(this).slideDown().text("#Censuré#") ;

			}),
			
			$(".jourProf:contains('#Censuré#')").slideUp( function() {

				$(this).slideDown().text("Bornerie") ;

			})

			e.preventDefault();
			return false;

		}

		if(e.ctrlKey && e.which === 86){ 

			$("tbody tr").find("td:gt(1)").remove();
			$("tbody tr").find("td").next().attr("colspan","21").html("<p class='jourProf'>Vacances générales</p>");
			
			e.preventDefault();
			return false;

		}
		 if(e.ctrlKey && e.which === 73){

                        $("#tableau").addClass("rotate");
                        e.preventDefault();
                        return false;

                }


	});

	

	$("tbody tr").find("td:last").css( "border-right-style", "none" );
	
	$("thead tr").find("td:last").css( "border-right-style", "none" );

	if( $("#selectFiliere option:selected").text() == "MMI" ) {
		$("html").css("background-color","#99CC00");
		$("h2").html('<span class="trucUselessMMI">M</span>oderne <span class="trucUselessMMI" >M</span>ignon <span class="trucUselessMMI">I</span>ndépendant');
	}

	if( $("span.jourNum").last().text() == "30" && $("span.jourMois").last().text() == "Septembre") {
	$("tr").first().after($("tr").last()) ;
	}


	

});



$(document).ready(function() {

$(document).keypress("m",function(e){

if(e.ctrlKey) {

    $(".jourProf:contains('Bornerie')").slideUp( function() {
	$(".jourProf:contains('Bornerie')").slideDown().text("#Censuré#") ;
    });

}

});

});



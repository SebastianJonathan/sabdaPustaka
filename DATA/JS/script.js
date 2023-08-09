$(document).ready(function() {
    // if the element with id "p1" exists, load home.js
    if ($("#p1_home").length) {
		$.getScript(configPath+"JS/search_result.js");
		$.getScript(configPath+"JS/home.js");
    }
	else if($("#p2_selectedCard").length){
		// $.getScript(configPath+"JS/home.js");
	}
    else if($("#p3_relatedResult").length){
		$.getScript(configPath+"JS/search_result.js");
		$.getScript(configPath+"JS/relatedSearch.js");
    }
});

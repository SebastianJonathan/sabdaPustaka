$(document).ready(function() {
	window.onbeforeunload = function () {
		console.log("halo")
		window.scrollTo(0, 0);
	}
	$.getScript(configPath+"JS/navbar.js");
    if ($("#p1_home").length) {
		$.getScript(configPath+"JS/search_result.js");
		$.getScript(configPath+"JS/home.js");
    }
	else if($("#p2_selectedCard").length){
		$.getScript(configPath+"JS/selectedCard.js");
	}
    else if($("#p3_relatedResult").length){
		$.getScript(configPath+"JS/search_result.js");
		$.getScript(configPath+"JS/relatedSearch.js");
    }
    else if($("#p4_allList").length){
		$.getScript(configPath+"JS/getAllList.js");
    }
	
});

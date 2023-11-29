document.addEventListener('DOMContentLoaded', () => {
  "use strict";

  const preloader = document.getElementById('loader-cont');
  if (preloader) {
      window.addEventListener('load', () => {
          preloader.style.display = "none";
      });
  }
});

$(document).ready(function() {
	window.onbeforeunload = function () {
		window.scrollTo(0, 0);
	}
	$.getScript(configPath+"JS/navbar.js");
  const preloader = document.getElementById('loader-cont');
  preloader.style.display = "none";
  if ($("#p1_home").length) {
  $.getScript(configPath+"JS/search_result.js")
      .then(function(){
          $.getScript(configPath+"JS/home.js");
          
      })
      .catch(function(){
          window.alert("Maaf terjadi kesalahan");
          location.reload();
      })
  
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



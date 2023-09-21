// $(document).ready(function() {
//     window.onbeforeunload = function () {
//         console.log("halo")
//         window.scrollTo(0, 0);
//     }

//     function loadScript(scriptPath) {
//         return new Promise(function(resolve, reject) {
//             $.getScript(scriptPath, function() {
//                 resolve();
//             }).fail(function() {
//                 reject(new Error('Failed to load script: ' + scriptPath));
//             });
//         });
//     }

//     loadScript(configPath + "JS/navbar.js")
//         .then(function() {
//             if ($("#p1_home").length) {
//                 loadScript(configPath + "JS/search_result.js")
//                 .then(function(){
//                     loadScript(configPath + "JS/home.js");
//                 })

//             } else if ($("#p2_selectedCard").length) {
//                 return loadScript(configPath + "JS/selectedCard.js");
//             } else if ($("#p3_relatedResult").length) {
//                 loadScript(configPath + "JS/search_result.js")
//                 .then(function(){
//                     loadScript(configPath + "JS/relatedSearch.js");
//                 })
                
//             } else if ($("#p4_allList").length) {
//                 return loadScript(configPath + "JS/getAllList.js");
//             }
//         })
//         .then(function() {
//             // Code that depends on the loaded scripts can go here
//         })
//         .catch(function(error) {
//             console.error(error);
//         });
// });

$(document).ready(function() {
	window.onbeforeunload = function () {
		console.log("halo")
		window.scrollTo(0, 0);
	}
	$.getScript(configPath+"JS/navbar.js");
    if ($("#p1_home").length) {
		$.getScript(configPath+"JS/search_result.js")
        .then(function(){
            // window.alert("SUCESS SUCESS SUCESS")
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

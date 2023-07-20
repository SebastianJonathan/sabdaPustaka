<!DOCTYPE html>
<html>
<head>
  <title>Search Results</title>
</head>
<body>
  <div class="_cards-container">
    <div class="main">
      <ul class="_cards" id="card_result">
        <!-- Card results will be dynamically added here -->
      </ul>
    </div>
  </div>

  <script>
    const fopen_narasumber = document.getElementById("ffv-filter-naras");
    const fcolumn_narasumber = document.getElementById("ffc-filter-naras");
    const fopen_event = document.getElementById("ffv-filter-event");
    const fcolumn_event = document.getElementById("ffc-filter-event");
    const fopen_tgl = document.getElementById("ffv-filter-tgl");
    const fcolumn_tgl = document.getElementById("ffc-filter-tgl");

    let filterNarasumber = [];
    let filterEvent = [];
    let filterTanggal = [];

    function createCheckbox(id, nama, div_filter) {
        var containerDiv = document.createElement("div");
        containerDiv.className = "checkbox-container";
        var label = document.createElement("label");
        label.setAttribute("for", id);
        label.className = "form-check-label checkbox-label bigger";

        var input = document.createElement("input");
        input.setAttribute("type", "checkbox");
        input.className = "form-check-input bigger";
        input.id = id;
        input.name = id;
        input.value = nama;
        input.onchange = function() {
            first = false;
            syncCheckbox(input.id,input.checked);
            if(id.substring(4,5) == "n"){
                onChangeFilterCheckbox(nama,"narasumber",input.checked);
            }else if(id.substring(4,5) == "e"){
                onChangeFilterCheckbox(nama,"event",input.checked);
            }else if(id.substring(4,5) == "t"){
                onChangeFilterCheckbox(nama,"tanggal",input.checked);
            }
            // console.log(filterNarasumber);
            fetchSearchFilterResult();
        };

        label.appendChild(input);

        label.appendChild(document.createTextNode(nama));

        containerDiv.appendChild(label);

        div_filter.appendChild(containerDiv);
        filterNarasumber.forEach(function(val){
            if(val == nama){
                input.checked = true;
            }
        })
        filterEvent.forEach(function(val){
            if(val == nama){
                input.checked = true;
            }
        })
        filterTanggal.forEach(function(val){
            if(val == nama){
                input.checked = true;
            }
        })
    }

    function onChangeFilterCheckbox(value,type,checked){
        if(type == "narasumber"){
            if(checked == true){
                filterNarasumber.push(value);
            }else{
                filterNarasumber = filterNarasumber.filter(function(item) {
                    return item !== value;
                })
            }
        }
        if(type == "event"){
            if(checked == true){
                filterEvent.push(value);
            }else{
                filterEvent = filterEvent.filter(function(item) {
                    return item !== value;
                })
            }
        }
        if(type == "tanggal"){
            if(checked == true){
                filterTanggal.push(value);
            }else{
                filterTanggal = filterTanggal.filter(function(item) {
                    return item !== value;
                })
            }
        }
    }

    function fetchSearchFilterResult() {
        if(sessionStorage.getItem("query") != null){
            // Define checkbox variables
            const checkbox_judul = document.getElementById('checkbox_judul');
            const checkbox_narasumber = document.getElementById('checkbox_narasumber');
            const checkbox_event = document.getElementById('checkbox_event');

            // Initialize fieldSearch array
            let fieldSearch = [];

            // Check if the respective checkboxes are checked and add fields to fieldSearch array
            if (checkbox_judul.checked) {
                fieldSearch.push('judul_completion.input');
            }
            if (checkbox_narasumber.checked) {
                fieldSearch.push('narasumber_completion.input');
            }
            if (checkbox_event.checked) {
                fieldSearch.push('event_completion.input');
            }
            // Create the filter object
            const filter = {
                "query": sessionStorage.getItem("query"),
                "size": 10,
                "API": "searchFilter",
                "fields": fieldSearch,
                "narasumber": filterNarasumber,
                "event": filterEvent,
                "tanggal": filterTanggal
            };

            // Convert the filter object to JSON
            const filterJson = JSON.stringify(filter);

            // Get the card_result container element
            const cardResultElement = document.getElementById('card_result');

            // Delete all card elements by setting the innerHTML to an empty string
            cardResultElement.innerHTML = '';

            fetch('http://localhost/UI/sabdaPustaka/filterAPI.php', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                },
                body: filterJson,
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                const cardResultElement = document.getElementById('card_result');
                cardResultElement.innerHTML = '';

                data.result.data.forEach(function (item) {
                    const cardItem = document.createElement('li');
                    cardItem.className = '_cards_item';

                    const card = document.createElement('div');
                    card.className = '_card';
                    card.setAttribute('onclick', `window.location.href='selected_card.php?document_id=${item.id}'`);

                    const cardImage = document.createElement('div');
                    cardImage.className = '_card_image';

                    if (item.youtube) {
                        const youtubeUrl = item.youtube;
                        const videoId = getYoutubeVideoId(youtubeUrl);
                        if (videoId) {
                            const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
                            const thumbnailImg = document.createElement('img');
                            thumbnailImg.src = thumbnailUrl;
                            cardImage.appendChild(thumbnailImg);
                        }
                    }

                    const cardContent = document.createElement('div');
                    cardContent.className = '_card_content';

                    const cardTitle = document.createElement('h2');
                    cardTitle.className = '_card_title';
                    cardTitle.textContent = item.judul;

                    const cardText = document.createElement('p');
                    cardText.className = '_card_text';
                    cardText.textContent = item.narasumber;

                    // Append the card content to the card element
                    card.appendChild(cardImage);
                    card.appendChild(cardContent);

                    cardContent.appendChild(cardTitle);
                    cardContent.appendChild(cardText);

                    cardItem.appendChild(card);
                    cardResultElement.appendChild(cardItem);
                });
                fopen_narasumber.innerHTML = '';
                fcolumn_narasumber.innerHTML = '';
                fopen_event.innerHTML = '';
                fcolumn_event.innerHTML = '';
                fopen_tgl.innerHTML = '';
                fcolumn_tgl.innerHTML = '';

                if(data.result.narasumber.length > 0){
                    
                    const titleFFV = document.createElement('h6');
                    titleFFV.textContent = "Filter Berdasarkan Narasumber";
                    titleFFV.id = "ffv-narasumber";
                    titleFFV.style.fontWeight = "bold";
                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Filter Berdasarkan Narasumber";
                    titleFFC.id = "ffc-narasumber";
                    titleFFC.style.fontWeight = "bold";
                    fopen_narasumber.appendChild(titleFFV);
                    fcolumn_narasumber.appendChild(titleFFC);
                    data.result.narasumber.forEach(function (item,index){
                        createCheckbox("ffv-n" + index,item,fopen_narasumber);
                        createCheckbox("ffc-n" + index,item,fcolumn_narasumber);
                    });
                }
                if(data.result.event.length > 0){
                    const titleFFV = document.createElement('h6');
                    titleFFV.textContent = "Filter Berdasarkan Event";
                    titleFFV.id = "ffv-event";
                    titleFFV.style.fontWeight = "bold";
                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Filter Berdasarkan Event";
                    titleFFC.id = "ffc-event";
                    titleFFC.style.fontWeight = "bold";
                    fopen_event.appendChild(titleFFV);
                    fcolumn_event.appendChild(titleFFC);
                    data.result.event.forEach(function (item,index){
                        createCheckbox("ffv-e" + index,item,fopen_event);
                        createCheckbox("ffc-e" + index,item,fcolumn_event);
                    });
                }
                if(data.result.tahun.length > 0){
                    const titleFFV = document.createElement('h6');
                    titleFFV.textContent = "Filter Berdasarkan Tahun";
                    titleFFV.id = "ffv-tanggal";
                    titleFFV.style.fontWeight = "bold";
                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Filter Berdasarkan Tahun";
                    titleFFC.id = "ffc-tanggal";
                    titleFFC.style.fontWeight = "bold";
                    fopen_tgl.appendChild(titleFFV);
                    fcolumn_tgl.appendChild(titleFFC);
                    data.result.tahun.forEach(function (item,index){
                        createCheckbox("ffv-t" + index,item.substring(0,4),fopen_tgl);
                        createCheckbox("ffc-t" + index,item.substring(0,4),fcolumn_tgl);
                    });
                }
            })
            .catch(error => {
            // Handle any errors
            console.error(error);
            });
        }
    }

    function fetchSearchResult() {
        if(document.getElementById('query').value != ""){
            sessionStorage.setItem("query", document.getElementById('query').value);
        }
        if(sessionStorage.getItem("query") != null){
            document.getElementById('query').value = "";
            // Define checkbox variables
            const checkbox_judul = document.getElementById('checkbox_judul');
            const checkbox_narasumber = document.getElementById('checkbox_narasumber');
            const checkbox_event = document.getElementById('checkbox_event');

            // Initialize fieldSearch array
            let fieldSearch = [];

            // Check if the respective checkboxes are checked and add fields to fieldSearch array
            if (checkbox_judul.checked) {
                fieldSearch.push('judul_completion.input');
            }
            if (checkbox_narasumber.checked) {
                fieldSearch.push('narasumber_completion.input');
            }
            if (checkbox_event.checked) {
                fieldSearch.push('event_completion.input');
            }
            // Create the filter object
            const filter = {
                "query": sessionStorage.getItem("query"),
                "size": 10,
                "API": "search",
                "fields": fieldSearch
            };

            // Convert the filter object to JSON
            const filterJson = JSON.stringify(filter);

            // Get the card_result container element
            const cardResultElement = document.getElementById('card_result');

            // Delete all card elements by setting the innerHTML to an empty string
            cardResultElement.innerHTML = '';

            fetch('http://localhost/UI/sabdaPustaka/filterAPI.php', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                },
                body: filterJson,
            })
            .then(response => response.json())
            .then(data => {
                const cardResultElement = document.getElementById('card_result');
                cardResultElement.innerHTML = '';
                if (data.result.data_result.length > 0) {
                    data.result.data_result.forEach(function (item) {
                    const cardItem = document.createElement('li');
                    cardItem.className = '_cards_item';

                    const card = document.createElement('div');
                    card.className = '_card';
                    card.setAttribute('onclick', `window.location.href='selected_card.php?document_id=${item.id}'`);

                    const cardImage = document.createElement('div');
                    cardImage.className = '_card_image';

                    if (item.youtube) {
                        const youtubeUrl = item.youtube;
                        const videoId = getYoutubeVideoId(youtubeUrl);
                        if (videoId) {
                        const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
                        const thumbnailImg = document.createElement('img');
                        thumbnailImg.src = thumbnailUrl;
                        cardImage.appendChild(thumbnailImg);
                        }
                    }

                    const cardContent = document.createElement('div');
                    cardContent.className = '_card_content';

                    const cardTitle = document.createElement('h2');
                    cardTitle.className = '_card_title';
                    cardTitle.textContent = item.judul;

                    const cardText = document.createElement('p');
                    cardText.className = '_card_text';
                    cardText.textContent = item.narasumber;

                    // Append the card content to the card element
                    card.appendChild(cardImage);
                    card.appendChild(cardContent);

                    cardContent.appendChild(cardTitle);
                    cardContent.appendChild(cardText);

                    cardItem.appendChild(card);
                    cardResultElement.appendChild(cardItem);
                });
                } else {
                    const noResults = document.createElement('p');
                    noResults.textContent = 'No results found.';
                    cardResultElement.appendChild(noResults);
                }
                // filterOpenCanvas.innerHTML = '';
                // filterColumnCanvas.innerHTML = '';
                fopen_narasumber.innerHTML = '';
                fcolumn_narasumber.innerHTML = '';
                fopen_event.innerHTML = '';
                fcolumn_event.innerHTML = '';
                fopen_tgl.innerHTML = '';
                fcolumn_tgl.innerHTML = '';

                if(data.result.unique_narasumber.length > 0){
                    
                    const titleFFV = document.createElement('h6');
                    titleFFV.textContent = "Filter Berdasarkan Narasumber";
                    titleFFV.id = "ffv-narasumber";
                    titleFFV.style.fontWeight = "bold";
                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Filter Berdasarkan Narasumber";
                    titleFFC.id = "ffc-narasumber";
                    titleFFC.style.fontWeight = "bold";
                    fopen_narasumber.appendChild(titleFFV);
                    fcolumn_narasumber.appendChild(titleFFC);
                    data.result.unique_narasumber.forEach(function (item,index){
                        createCheckbox("ffv-n" + index,item,fopen_narasumber);
                        createCheckbox("ffc-n" + index,item,fcolumn_narasumber);
                    });
                }
                if(data.result.unique_event.length > 0){
                    const titleFFV = document.createElement('h6');
                    titleFFV.textContent = "Filter Berdasarkan Event";
                    titleFFV.id = "ffv-event";
                    titleFFV.style.fontWeight = "bold";
                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Filter Berdasarkan Event";
                    titleFFC.id = "ffc-event";
                    titleFFC.style.fontWeight = "bold";
                    fopen_event.appendChild(titleFFV);
                    fcolumn_event.appendChild(titleFFC);
                    data.result.unique_event.forEach(function (item,index){
                        createCheckbox("ffv-e" + index,item,fopen_event);
                        createCheckbox("ffc-e" + index,item,fcolumn_event);
                    });
                }
                if(data.result.unique_tanggal.length > 0){
                    const titleFFV = document.createElement('h6');
                    titleFFV.textContent = "Filter Berdasarkan Tahun";
                    titleFFV.id = "ffv-tanggal";
                    titleFFV.style.fontWeight = "bold";
                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Filter Berdasarkan Tahun";
                    titleFFC.id = "ffc-tanggal";
                    titleFFC.style.fontWeight = "bold";
                    fopen_tgl.appendChild(titleFFV);
                    fcolumn_tgl.appendChild(titleFFC);
                    data.result.unique_tanggal.forEach(function (item,index){
                        createCheckbox("ffv-t" + index,item,fopen_tgl);
                        createCheckbox("ffc-t" + index,item,fcolumn_tgl);
                    });
                }
            })
            .catch(error => {
            // Handle any errors
            console.error(error);
            });
        }
    }

    function getYoutubeVideoId(url) {
        const pattern = /(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
        const matches = url.match(pattern);

        if (matches && matches[1]) {
            return matches[1]; // YouTube video ID
        } else {
            return null; // Invalid YouTube URL or ID not found
        }
    }
  </script>
</body>
</html>

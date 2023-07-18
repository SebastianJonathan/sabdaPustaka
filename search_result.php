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
    const filterOpenCanvas = document.getElementById("ffv-filter");
    const filterColumnCanvas = document.getElementById("ffc-filter");
    let filterNarasumber = [];
    let filterEvent = [];
    let filterTanggal = [];

    function createCheckbox(id, nama) {
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
            if(id.substring(4,5) == "n"){
                onChangeFilterCheckbox(nama,"narasumber",input.checked);
            }else if(id.substring(4,5) == "e"){
                onChangeFilterCheckbox(nama,"event",input.checked);
            }else if(id.substring(4,5) == "t"){
                onChangeFilterCheckbox(nama,"tanggal",input.checked);
            }
            console.log(filterNarasumber);
            fetchSearchFilterResult();
        };

        label.appendChild(input);

        label.appendChild(document.createTextNode(nama));

        containerDiv.appendChild(label);

        if (id.substring(0, 3) == "ffv") {
            filterOpenCanvas.appendChild(containerDiv);
        } else {
            filterColumnCanvas.appendChild(containerDiv);
        }
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
                "event": filterEvent
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
                console.log(data);
                const cardResultElement = document.getElementById('card_result');
                cardResultElement.innerHTML = '';

                data.result.forEach(function (item) {
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
                filterOpenCanvas.innerHTML = '';
                filterColumnCanvas.innerHTML = '';
                if(data.result.unique_narasumber.length > 0){
                    const titleFFV = document.createElement('h1');
                    titleFFV.textContent = "Filter Berdasarkan Narasumber";
                    titleFFV.id = "ffv-narasumber";
                    const titleFFC = document.createElement('h1');
                    titleFFC.textContent = "Filter Berdasarkan Narasumber";
                    titleFFC.id = "ffc-narasumber";
                    filterOpenCanvas.appendChild(titleFFV);
                    filterColumnCanvas.appendChild(titleFFC);
                    data.result.unique_narasumber.forEach(function (item,index){
                        createCheckbox("ffv-n" + index,item);
                        createCheckbox("ffc-n" + index,item);
                    });
                }
                if(data.result.unique_event.length > 0){
                    const titleFFV = document.createElement('h1');
                    titleFFV.textContent = "Filter Berdasarkan Event";
                    titleFFV.id = "ffv-event";
                    const titleFFC = document.createElement('h1');
                    titleFFC.textContent = "Filter Berdasarkan Event";
                    titleFFC.id = "ffc-event";
                    filterOpenCanvas.appendChild(titleFFV);
                    filterColumnCanvas.appendChild(titleFFC);
                    data.result.unique_event.forEach(function (item,index){
                        createCheckbox("ffv-e" + index,item);
                        createCheckbox("ffc-e" + index,item);
                    });
                }
                if(data.result.unique_tanggal.length > 0){
                    const titleFFV = document.createElement('h1');
                    titleFFV.textContent = "Filter Berdasarkan Tanggal";
                    titleFFV.id = "ffv-tanggal";
                    const titleFFC = document.createElement('h1');
                    titleFFC.textContent = "Filter Berdasarkan Tanggal";
                    titleFFC.id = "ffc-tanggal";
                    filterOpenCanvas.appendChild(titleFFV);
                    filterColumnCanvas.appendChild(titleFFC);
                    data.result.unique_tanggal.forEach(function (item,index){
                        createCheckbox("ffv-t" + index,item);
                        createCheckbox("ffc-t" + index,item);
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

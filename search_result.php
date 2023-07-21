<!DOCTYPE html>
<html>
<head>
  <title>Search Results</title>
</head>
<body>
  <div class="_cards-container">
    <div class="main">
        <button class="btn filter-sm-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#filter-sm" aria-controls="filter-sm" style="margin-left: 16px;">Filter</button>
        <div id="hs-header" style="padding-left: 16px;">
        
        </div> 
        <ul class="_cards" id="card_result">
        <!-- Card results will be dynamically added here -->
        </ul>
    </div>
  </div>

  <script>
    const hs_head = document.getElementById("hs-header");
    const FilterOpenCanvas = document.getElementById("ffv-filter");
    const FilterColumnCanvas = document.getElementById("ffc-filter");
    
    const fcolumn_narasumber = document.createElement('div');
    const fopen_narasumber = document.createElement('div');
    const fcolumn_event = document.createElement('div');
    const fopen_event = document.createElement('div');
    const fcolumn_tgl = document.createElement('div');
    const fopen_tgl = document.createElement('div');
    // const fopen_narasumber = document.getElementById("ffv-filter-naras");
    // const fcolumn_narasumber = document.getElementById("ffc-filter-naras");
    // const fopen_event = document.getElementById("ffv-filter-event");
    // const fcolumn_event = document.getElementById("ffc-filter-event");
    // const fopen_tgl = document.getElementById("ffv-filter-tgl");
    // const fcolumn_tgl = document.getElementById("ffc-filter-tgl");

    let filterNarasumber = [];
    let filterEvent = [];
    let filterTanggal = [];

    function createCheckbox(id, nama, div_filter,arr) {
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

        label.appendChild(document.createTextNode(nama + " (" + arr[nama] + ")"     ));

        containerDiv.appendChild(label);

        div_filter.appendChild(containerDiv);
        if(nama.substring(0,1) == " "){
            nama = nama.substring(1);
        }
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

    function clrAllFilterCheckbox(){
        filterNarasumber.length = 0;
        filterEvent.length = 0;
        filterTanggal.length = 0;
        fetchSearchFilterResult();
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
        const fullURL = window.location.href;
		const segments = fullURL.split('/');
        let query = segments[segments.length - 1];
        query = query.replace(/%20/g, ' ');
        if(query != null){
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
            if (checkbox_related.checked) {
                fieldSearch.push('deskripsi_pendek');
				fieldSearch.push('ringkasan');
				fieldSearch.push('kata_kunci');
            }
            console.log(fieldSearch)
            // Create the filter object
            const filter = {
                "query": query,
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
                    // console.log("WWWW");
                    // const titleFFV = document.createElement('h6');
                    // titleFFV.textContent = "Filter Berdasarkan Narasumber";
                    // titleFFV.id = "ffv-narasumber";
                    // titleFFV.style.fontWeight = "bold";
                    // const titleFFC = document.createElement('h6');
                    // titleFFC.textContent = "Filter Berdasarkan Narasumber";
                    // titleFFC.id = "ffc-narasumber";
                    // titleFFC.style.fontWeight = "bold";
                    // fopen_narasumber.appendChild(titleFFV);
                    // fcolumn_narasumber.appendChild(titleFFC);
                    data.result.narasumber.forEach(function (item,index){
                        createCheckbox("ffv-n" + index,item,fopen_narasumber,data.result.countNarasumber);
                        createCheckbox("ffc-n" + index,item,fcolumn_narasumber,data.result.countNarasumber);
                    });
                }
                if(data.result.event.length > 0){
                    // const titleFFV = document.createElement('h6');
                    // titleFFV.textContent = "Filter Berdasarkan Event";
                    // titleFFV.id = "ffv-event";
                    // titleFFV.style.fontWeight = "bold";
                    // const titleFFC = document.createElement('h6');
                    // titleFFC.textContent = "Filter Berdasarkan Event";
                    // titleFFC.id = "ffc-event";
                    // titleFFC.style.fontWeight = "bold";
                    // fopen_event.appendChild(titleFFV);
                    // fcolumn_event.appendChild(titleFFC);
                    data.result.event.forEach(function (item,index){
                        createCheckbox("ffv-e" + index,item,fopen_event,data.result.countEvent);
                        createCheckbox("ffc-e" + index,item,fcolumn_event,data.result.countEvent);
                    });
                }
                if(data.result.tahun.length > 0){
                    // const titleFFV = document.createElement('h6');
                    // titleFFV.textContent = "Filter Berdasarkan Tahun";
                    // titleFFV.id = "ffv-tanggal";
                    // titleFFV.style.fontWeight = "bold";
                    // const titleFFC = document.createElement('h6');
                    // titleFFC.textContent = "Filter Berdasarkan Tahun";
                    // titleFFC.id = "ffc-tanggal";
                    // titleFFC.style.fontWeight = "bold";
                    // fopen_tgl.appendChild(titleFFV);
                    // fcolumn_tgl.appendChild(titleFFC);
                    data.result.tahun.forEach(function (item,index){
                        createCheckbox("ffv-t" + index,item.substring(0,4),fopen_tgl,data.result.countTahun);
                        createCheckbox("ffc-t" + index,item.substring(0,4),fcolumn_tgl,data.result.countTahun);
                    });
                }
            })
            .catch(error => {
            // Handle any errors
            console.error(error);
            });
        }
    }

    async function fetchNewest() {
		try {
			const response = await fetch('http://localhost/UI/sabdaPustaka/getNewest.php');
			const data = await response.json();
			const cardResultElement = document.getElementById('card_result');
            cardResultElement.innerHTML = '';
            if (data.hasil.length > 0) {
                hs_head.innerHTML = '';                 
                data.hasil.forEach(function (item) {
                    hs_head.innerHTML = '';
                    const hs_head_t = document.createElement('h5');
                    hs_head_t.textContent = "Terkini:";
                    hs_head_t.style.fontWeight = "bold";
                    hs_head.appendChild(hs_head_t);    

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

                    FilterColumnCanvas.innerHTML = '';
                    FilterOpenCanvas.innerHTML = '';
                });
            } else {
                // const noResults = document.createElement('p');
                // noResults.textContent = 'No results found.';
                // cardResultElement.appendChild(noResults);
                FilterColumnCanvas.innerHTML = '';
                FilterOpenCanvas.innerHTML = '';

                hs_head.innerHTML = '';
                const hs_head_t = document.createElement('h5');
                hs_head_t.textContent = "No Results Found";
                hs_head_t.style.fontWeight = "bold";
                hs_head.appendChild(hs_head_t);  
            }
		} catch (error) {
			console.error('Terjadi kesalahan:', error);
		}
	}

    function fetchSearchResult() {
        filterNarasumber.length = 0;
        filterEvent.length = 0;
        filterTanggal.length = 0;
        const fullURL = window.location.href;
		const segments = fullURL.split('/');
        let query = segments[segments.length - 1];
        query = query.replace(/%20/g, ' ');
        if(query != null){
            document.getElementById('query').value = query;
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
            if (checkbox_related.checked) {
                fieldSearch.push('deskripsi_pendek');
				fieldSearch.push('ringkasan');
				fieldSearch.push('kata_kunci');
            }
            // Create the filter object
            console.log(fieldSearch)
            const filter = {
                "query": query,
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
                    hs_head.innerHTML = '';
                    const hs_head_t = document.createElement('h5');
                    hs_head_t.textContent = "Hasil Search:";
                    hs_head_t.style.fontWeight = "bold";
                    hs_head.appendChild(hs_head_t);                    
                    
                    data.result.data_result.forEach(function (item) {
                    const cardItem = document.createElement('li');
                    cardItem.className = '_cards_item';

                    const card = document.createElement('div');
                    card.className = '_card';
                    card.setAttribute('onclick', `window.location.href='http://localhost/UI/sabdaPustaka/selected_card.php?document_id=${item.id}'`);

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

                    FilterColumnCanvas.innerHTML = '';
                    FilterOpenCanvas.innerHTML = '';

                    const titleFFC = document.createElement('h5');
                    titleFFC.textContent = 'Filter By';
                    titleFFC.style.marginTop = '20px';
                    titleFFC.style.marginBottom = '18px';
                    titleFFC.style.fontWeight = 'bold';
                    titleFFC.style.paddingTop = '15px';
                    titleFFC.style.borderTop = '2px goldenrod solid';
                    titleFFC.style.color = 'gold';
                    FilterColumnCanvas.appendChild(titleFFC);

                    const titleFFV = document.createElement('h5');
                    titleFFV.textContent = 'Filter By';
                    titleFFV.style.marginTop = '20px';
                    titleFFV.style.marginBottom = '20px';
                    titleFFV.style.fontWeight = 'bold';
                    titleFFV.style.paddingTop = '10px';
                    titleFFV.style.borderTop = '2px goldenrod solid';
                    titleFFV.style.color = 'gold';
                    FilterOpenCanvas.appendChild(titleFFV);

                });
                } else {
                    // const noResults = document.createElement('p');
                    // noResults.textContent = 'No results found.';
                    // cardResultElement.appendChild(noResults);
                    FilterColumnCanvas.innerHTML = '';
                    FilterOpenCanvas.innerHTML = '';

                    hs_head.innerHTML = '';
                    const hs_head_t = document.createElement('h5');
                    hs_head_t.textContent = "No Results Found";
                    hs_head_t.style.fontWeight = "bold";
                    hs_head.appendChild(hs_head_t);  
                }
                // filterOpenCanvas.innerHTML = '';
                // filterColumnCanvas.innerHTML = '';
                // fopen_narasumber.innerHTML = '';
                // fcolumn_narasumber.innerHTML = '';
                // fopen_event.innerHTML = '';
                // fcolumn_event.innerHTML = '';
                // fopen_tgl.innerHTML = '';
                // fcolumn_tgl.innerHTML = '';



                if(data.result.unique_narasumber.length > 0){

                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Narasumber";
                    titleFFC.id = "ffc-narasumber";
                    titleFFC.className = "ffc_head";
                    // titleFFC.style.fontWeight = "bold";
                    FilterColumnCanvas.appendChild(titleFFC);

                    const titleFFV = document.createElement('h6');
                    titleFFV.textContent = "Narasumber";
                    titleFFV.id = "ffv-narasumber";
                    titleFFV.className = "ffv_head";
                    // titleFFV.style.fontWeight = "bold";
                    FilterOpenCanvas.appendChild(titleFFV);

                    fcolumn_narasumber.innerHTML = '';
                    fcolumn_narasumber.className = "row ffc ";
                    // fcolumn_narasumber.style.paddingTop = '15px';
                    // fcolumn_narasumber.style.marginTop = '10px';
                    // fcolumn_narasumber.style.borderTop = '1px solid black';
                    fcolumn_narasumber.id = 'ffc-filter-naras';
                    FilterColumnCanvas.appendChild(fcolumn_narasumber);

                    fopen_narasumber.innerHTML = '';
                    fopen_narasumber.className = "row ffv";
                    // fopen_narasumber.style.paddingTop = '15px';
                    // fopen_narasumber.style.marginTop = '10px';
                    // fopen_narasumber.style.borderTop = '1px solid black';
                    fopen_narasumber.id = 'ffv-filter-naras';
                    FilterOpenCanvas.appendChild(fopen_narasumber);

                    data.result.unique_narasumber.forEach(function (item,index){
                        createCheckbox("ffv-n" + index,item,fopen_narasumber,data.result.countNarasumber);
                        createCheckbox("ffc-n" + index,item,fcolumn_narasumber,data.result.countNarasumber);
                    });
                }
                if(data.result.unique_event.length > 0){
                    const titleFFV = document.createElement('h6');
                    titleFFV.textContent = "Event";
                    titleFFV.id = "ffv-event";
                    titleFFV.className = "ffv_head";
                    // titleFFV.style.fontWeight = "bold";
                    FilterOpenCanvas.appendChild(titleFFV);

                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Event";
                    titleFFC.id = "ffc-event";
                    titleFFC.className = "ffc_head";
                    // titleFFC.style.fontWeight = "bold";
                    FilterColumnCanvas.appendChild(titleFFC);

                    fcolumn_event.innerHTML = '';
                    fcolumn_event.className = "row ffc";
                    // fcolumn_event.style.paddingTop = '15px';
                    // fcolumn_event.style.marginTop = '10px';
                    // fcolumn_event.style.borderTop = '1px solid black';
                    fcolumn_event.id = 'ffc-filter-event';
                    FilterColumnCanvas.appendChild(fcolumn_event);

                    fopen_event.innerHTML = '';
                    fopen_event.className = "row ffv";
                    // fopen_event.style.paddingTop = '15px';
                    // fopen_event.style.marginTop = '10px';
                    // fopen_event.style.borderTop = '1px solid black';
                    fopen_event.id = 'ffv-filter-event';
                    FilterOpenCanvas.appendChild(fopen_event);

                    data.result.unique_event.forEach(function (item,index){
                        createCheckbox("ffv-e" + index,item,fopen_event,data.result.countEvent);
                        createCheckbox("ffc-e" + index,item,fcolumn_event,data.result.countEvent);
                    });
                }
                if(data.result.unique_tanggal.length > 0){
                    const titleFFV = document.createElement('h6');
                    titleFFV.textContent = "Tahun";
                    titleFFV.id = "ffv-tanggal";
                    titleFFV.className = "ffv_head";
                    // titleFFV.style.fontWeight = "bold";
                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Tahun";
                    titleFFC.id = "ffc-tanggal";
                    titleFFC.className = "ffc_head";
                    // titleFFC.style.fontWeight = "bold";
                    FilterOpenCanvas.appendChild(titleFFV);
                    FilterColumnCanvas.appendChild(titleFFC);

                    fcolumn_tgl.innerHTML = '';
                    fcolumn_tgl.className = "row ffc";
                    // fcolumn_tgl.style.paddingTop = '15px';
                    // fcolumn_tgl.style.marginTop = '10px';
                    // fcolumn_tgl.style.borderTop = '1px solid black';
                    
                    fcolumn_tgl.id = 'ffc-filter-tgl';
                    FilterColumnCanvas.appendChild(fcolumn_tgl);

                    fopen_tgl.innerHTML = '';
                    fopen_tgl.className = "row ffv";
                    // fopen_tgl.style.paddingTop = '15px';
                    // fopen_tgl.style.marginTop = '10px';
                    // fopen_tgl.style.borderTop = '1px solid black';
                    fopen_tgl.id = 'ffv-filter-tgl';
                    FilterOpenCanvas.appendChild(fopen_tgl);

                    data.result.unique_tanggal.forEach(function (item,index){
                        createCheckbox("ffv-t" + index,item,fopen_tgl,data.result.countTahun);
                        createCheckbox("ffc-t" + index,item,fcolumn_tgl,data.result.countTahun);
                    });
                }

                const clrFilterBtn = document.createElement('button');
                clrFilterBtn.type = 'button';
                clrFilterBtn.className = "button clrfilter_btn";
                clrFilterBtn.textContent = 'Clear All Filter';
                clrFilterBtn.style.backgroundColor = 'goldenrod';
                clrFilterBtn.style.color = 'black';
                clrFilterBtn.onclick = clrAllFilterCheckbox;
                FilterOpenCanvas.appendChild(clrFilterBtn);
                FilterColumnCanvas.appendChild(clrFilterBtn);



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

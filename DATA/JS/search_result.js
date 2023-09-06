const hs_head = document.getElementById("hs-header");
const FilterOpenCanvas = document.getElementById("ffv-filter");
const FilterColumnCanvas = document.getElementById("ffc-filter");

const fcolumn_narasumber = document.createElement('div');
const fopen_narasumber = document.createElement('div');
const fcolumn_event = document.createElement('div');
const fopen_event = document.createElement('div');
const fcolumn_tgl = document.createElement('div');
const fopen_tgl = document.createElement('div');

let filterNarasumber = [];
let filterEvent = [];
let filterTanggal = [];
let rowsPassed = 0;
let cardHeight = window.innerHeight / 2;

var pageSize = 12;
var currPage = 1;
var maxPage = 1;
var showAll = false;
var loadPage = 8;
var totalPage = 0;

var errorConn = false;

function errorConnHandling(){
    if (!errorConn){
        // alert("Terjadi Kesalahan dalam Koneksi Data");
        // location.reload();
        location.href = configPath + "PHP/errorConn.php";
    }
    errorConn = true;
}

function errorConnNoMore(){
    errorConn = false;
}

function setMaxPage(total_data){
    maxPage = Math.ceil(total_data / pageSize);
}

// function createListItem2(pageNumber) {
//     const li = document.createElement('li');
//     li.className = "page-item";

//     var a = document.createElement('a');
//     a.className = "page-link";
//     a.id = "pagi_"+pageNumber;
//     if (pageNumber === "Show All"){
//         if (showAll){
//             a.innerText = "Unshow All";
//         }else {
//             a.innerText = pageNumber;
//         }
//     }else{
//         a.innerText = pageNumber;
//     }
    
//     if (pageNumber === currPage){
//         a.setAttribute("style","color: gold;")
//         a.style.backgroundColor = "#1e0049";
//     }

//     a.onclick = function(){
//         if (pageNumber != currPage){
//             if (pageNumber === "Show All"){
//                 if(a.innerText == "Show All"){
//                     pageSize = maxPage * 12;
//                     showAll = true;
//                 }else{
//                     pageSize = 12;
//                     showAll = false;
//                 }
//                 currPage = 1;
//             }
//             else if(pageNumber == "Next"){
//                 if((currPage + 1) <= maxPage){
//                     currPage += 1;
//                 }
//             }
//             else if(pageNumber == "Prev"){
//                 if((currPage - 1) >= 1){
//                     currPage -= 1;
//                 }
//             }
//             else if(pageNumber == "<<"){
//                 currPage = 1;
//             }
//             else if(pageNumber == ">>"){
//                 currPage = maxPage;
//             }
//             else{
//                 currPage = pageNumber;
//             }
//             if(sessionStorage.getItem("mode") == "list"){
//                 if(filterNarasumber.length != 0 || filterEvent.length != 0 || filterTanggal.length != 0){
//                     fetchSearchFilterResult2();
//                 }else{
//                     fetchSearchResult2();
//                 }
//             }else{
//                 if(filterNarasumber.length != 0 || filterEvent.length != 0 || filterTanggal.length != 0){
//                     fetchSearchFilterResult();
//                 }else{
//                     fetchSearchResult();
//                 }
//             }
//             window.scrollTo({
//                 top: 0,
//                 behavior: 'smooth'
//             })
//         }
//     };

//     li.appendChild(a);
//     return li;
// }

function createCheckbox(id, nama, div_filter, arr) {
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
        currPage = 1;
        pageSize = 12;
        rowsPassed = 0;
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
        if(sessionStorage.getItem("mode") == "card"){
            fetchSearchFilterResult();
        }else if(sessionStorage.getItem("mode") == "list"){
            fetchSearchFilterResult2();
        }
    };

    label.appendChild(input);
    label.appendChild(document.createTextNode(nama + " (" + arr[nama] + ")"));
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
    if(sessionStorage.getItem("mode") == "list"){
        fetchSearchFilterResult2();
    }else{
        fetchSearchFilterResult();
    }
}

function onChangeFilterCheckbox(value, type, checked){
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

function initFetchSearchFilter(isFilter){
    const fullURL = window.location.href;
    const segments = fullURL.split('/');
    let query = segments[segments.length - 1];
    query = query.replace(/%20/g, ' ');
    document.getElementById("query").value = query;
    if(query != null){
        let fieldSearch = [];

        // Check if the respective checkboxes are checked and add fields to fieldSearch array
        if (sessionStorage.getItem("checkboxJudul") == "true") {
            fieldSearch.push('judul_completion.input');
        }
        if (sessionStorage.getItem("checkboxNarasumber") == "true") {
            fieldSearch.push('narasumber_completion.input');
        }
        if (sessionStorage.getItem("checkboxEvent") == "true") {
            fieldSearch.push('event_completion.input');
        }
        if (sessionStorage.getItem("checkboxRelated") == "true") {
            fieldSearch.push('deskripsi_pendek');
            fieldSearch.push('ringkasan');
            fieldSearch.push('kata_kunci');
            fieldSearch.push('judul_completion.input');
        }
        // Create the filter object
        let filter = "";
        if(isFilter){
            filter = {
                "query": query == "" ? "Kosong" : query, //Kalau query kosong
                "size": pageSize,
                "API": "searchFilter",
                "fields": fieldSearch,
                "narasumber": filterNarasumber,
                "event": filterEvent,
                "tanggal": filterTanggal,
                "currPage": (currPage - 1) * 12
            };
        }else{
            if(query == ""){
                filter = {
                    "size": pageSize,
                    "API": "getAll",
                    "currPage": (currPage - 1) * 12,
                    "fields": fieldSearch
                };
            }else{
                filter = {
                    "query": query,
                    "size": pageSize,
                    "API": "search",
                    "fields": fieldSearch,
                    "currPage": (currPage - 1) * 12
                };
            }
        }
        const filterJson = JSON.stringify(filter);

        return [filterJson, query];
    }else{
        return ["-1"];
    }

}

function fetchSearchFilterResult2() {
    var fetchinit = initFetchSearchFilter(true);
    var filterJson = fetchinit[0];
    if(pageSize > 12){
        filterJson = JSON.parse(filterJson);
        filterJson.currPage = pageSize - loadPage;
        filterJson.size = loadPage;
        filterJson = JSON.stringify(filterJson);
    }
    let query = fetchinit[1];

    if (filterJson != "-1"){
        const cardResultElement = document.getElementById('card_result');
        if(pageSize == 12){
            cardResultElement.classList.add('container-list');
            cardResultElement.classList.add('_card2');
            cardResultElement.classList.remove('_cards');

            // Delete all card elements by setting the innerHTML to an empty string
            cardResultElement.innerHTML = '';
        }
        fetch(configPath + 'API/filterAPI.php', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            },
            body: filterJson,
        })
        .then(response => response.json())
        .then(data => {
            if (data.result === "E-CONN"){
                // location.href = configPath+"PHP/errorConn.php";
                errorConnHandling();
            }else{
                errorConnNoMore();
                setMaxPage(data.result.total);
                const cardResultElement = document.getElementById('card_result');

                data.result.data.forEach(function (item) {
                    // Create a card element
                    const cardItem = document.createElement('div');
                    cardItem.className = '_cards_item2';

                    const card = document.createElement('div');
                    card.className = '_card';
                    card.setAttribute('onclick', `window.location.href='${configPath}PHP/selected_card.php?document_id=${item.id}'`);

                    const cardContent = document.createElement('div');
                    cardContent.className = '_card_content';

                    const cardEvent = document.createElement('a');
                    cardEvent.className = '_card_text';
                    cardEvent.textContent = item.event;
                    cardEvent.onclick = function(event){
                        window.location.href = configPath+'PHP/related_results.php?event='+item.event;
                        event.stopPropagation();
                    }
                    cardEvent.style.textDecoration = 'none';

                    const cardTitle = document.createElement('h2');
                    cardTitle.className = '_card_title';
                    cardTitle.textContent = item.judul;

                    // Create a button to show item.ringkasan
                    const showSummaryButton = document.createElement('button');
                    showSummaryButton.className = 'show-summary-button';
                    showSummaryButton.textContent = 'V';


                    // Append the card content to the card element
                    card.appendChild(cardContent);

                    cardContent.appendChild(cardEvent);
                    cardContent.appendChild(cardTitle);
                    const divNarsum = document.createElement('div');
                    var count = 0;
                    fetchNarsum(item.narasumber).forEach(element => {
                        const cardText = document.createElement('a');
                        cardText.className = '_card_text';
                        if(fetchNarsum(item.narasumber).length - 1 == count){
                            cardText.textContent = element;
                        }else{
                            cardText.textContent = element + ", ";
                        }
                        count++;
                        cardText.onclick = function(event){
                            window.location.href = configPath+'PHP/related_results.php?narasumber='+element;
                            event.stopPropagation();
                        }
                        cardText.style.textDecoration = 'none';
                        divNarsum.appendChild(cardText);
                    });
                    divNarsum.style.display = 'block'
                    cardContent.appendChild(divNarsum);

                    // Append the card to the main container
                    cardItem.appendChild(card);
                    cardResultElement.appendChild(cardItem);

                    const cardRingkasan = document.createElement('p');
                    cardRingkasan.className = '_card_ringkasan';
                    cardRingkasan.textContent = item.deskripsi_pendek;
                    cardRingkasan.style.color = 'white'; // Set the text color to white

                    cardRingkasan.style.maxHeight = '4.1em'; // Adjust the height as needed
                    cardRingkasan.style.overflow = 'hidden';        
                    cardRingkasan.style.textOverflow = 'ellipsis';

                    cardContent.appendChild(showSummaryButton);

                    showSummaryButton.addEventListener('mouseenter', function () {
                        // Display the item.ringkasan content in cardContent
                        card.innerHTML = "";
                        card.appendChild(cardContent);
                        cardContent.removeChild(cardEvent);
                        cardContent.removeChild(cardTitle);
                        cardContent.removeChild(divNarsum);
                        cardContent.appendChild(cardRingkasan);
                        cardContent.appendChild(showSummaryButton);
                    });
                    
                    showSummaryButton.addEventListener('mouseleave', function () {
                        // Remove the item.ringkasan content when the mouse leaves the button
                        cardContent.innerHTML = "";
                        card.appendChild(cardContent);
                        cardContent.appendChild(cardEvent);
                        cardContent.appendChild(cardTitle);
                        cardContent.appendChild(divNarsum);
                        cardContent.appendChild(showSummaryButton);
                    });  
                });

                fopen_narasumber.innerHTML = '';
                fcolumn_narasumber.innerHTML = '';
                fopen_event.innerHTML = '';
                fcolumn_event.innerHTML = '';
                fopen_tgl.innerHTML = '';
                fcolumn_tgl.innerHTML = '';

                if(data.result.narasumber.length > 0){
                    data.result.narasumber.forEach(function (item,index){
                        createCheckbox("ffv-n" + index,item,fopen_narasumber,data.result.countNarasumber);
                        createCheckbox("ffc-n" + index,item,fcolumn_narasumber,data.result.countNarasumber);
                    });
                }
                if(data.result.event.length > 0){
                    data.result.event.forEach(function (item,index){
                        createCheckbox("ffv-e" + index,item,fopen_event,data.result.countEvent);
                        createCheckbox("ffc-e" + index,item,fcolumn_event,data.result.countEvent);
                    });
                }
                if(data.result.tahun.length > 0){
                    data.result.tahun.forEach(function (item,index){
                        createCheckbox("ffv-t" + index,item.substring(0,4),fopen_tgl,data.result.countTahun);
                        createCheckbox("ffc-t" + index,item.substring(0,4),fcolumn_tgl,data.result.countTahun);
                    });
                }
            }
        })
        .catch(error => {
        console.error(error);
        });
    }
}


function fetchSearchFilterResult() {
    var fetchinit = initFetchSearchFilter(true);
    var filterJson = fetchinit[0];
    if(pageSize > 12){
        filterJson = JSON.parse(filterJson);
        filterJson.currPage = pageSize - loadPage;
        filterJson.size = loadPage;
        filterJson = JSON.stringify(filterJson);
    }
    let query = fetchinit[1];

    if (filterJson != "-1"){
        const cardResultElement = document.getElementById('card_result');
        if(pageSize == 12){
            cardResultElement.classList.remove('container-list');
            cardResultElement.classList.remove('_card2');
            cardResultElement.classList.add('_cards');

            // Delete all card elements by setting the innerHTML to an empty string
            cardResultElement.innerHTML = '';
        }
        fetch(configPath + 'API/filterAPI.php', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            },
            body: filterJson,
        })
        .then(response => response.json())
        .then(data => {
            if (data.result === "E-CONN"){
                // location.href = configPath+"PHP/errorConn.php";
                errorConnHandling();
            }else{
                errorConnNoMore();
                setMaxPage(data.result.total);
                const cardResultElement = document.getElementById('card_result');

                data.result.data.forEach(function (item) {
                    const cardItem = document.createElement('li');
                    cardItem.className = '_cards_item';

                    const card = document.createElement('div');
                    card.className = '_card';
                    card.setAttribute('onclick', `window.location.href='${configPath}PHP/selected_card.php?document_id=${item.id}'`);

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

                    const cardEvent = document.createElement('a');
                    cardEvent.className = '_card_text';
                    cardEvent.textContent = item.event;
                    cardEvent.onclick = function(event){
                        window.location.href = configPath+'PHP/related_results.php?event='+item.event;
                        event.stopPropagation();
                    }
                    cardEvent.style.textDecoration = 'none';

                    const cardTitle = document.createElement('h2');
                    cardTitle.className = '_card_title';
                    cardTitle.textContent = item.judul;

                    // Append the card content to the card element
                    card.appendChild(cardImage);
                    card.appendChild(cardContent);

                    cardContent.appendChild(cardEvent);
                    cardContent.appendChild(cardTitle);
                    const divNarsum = document.createElement('div');
                    var count = 0;
                    fetchNarsum(item.narasumber).forEach(element => {
                        const cardText = document.createElement('a');
                        cardText.className = '_card_text';
                        if(fetchNarsum(item.narasumber).length - 1 == count){
                            cardText.textContent = element;
                        }else{
                            cardText.textContent = element + ", ";
                        }
                        count++;
                        cardText.onclick = function(event){
                            window.location.href = configPath+'PHP/related_results.php?narasumber='+element;
                            event.stopPropagation();
                        }
                        cardText.style.textDecoration = 'none';
                        divNarsum.appendChild(cardText);
                    });
                    divNarsum.style.display = 'block'
                    cardContent.appendChild(divNarsum);

                    cardItem.appendChild(card);
                    cardResultElement.appendChild(cardItem);

                    const cardRingkasan = document.createElement('p');

                    cardRingkasan.className = '_card_ringkasan';
                    cardRingkasan.textContent = item.deskripsi_pendek;
                    cardRingkasan.style.color = 'white'; // Set the text color to white

                    cardRingkasan.style.maxHeight = '15em'; // Adjust the height as needed
                    cardRingkasan.style.overflow = 'hidden';        
                    cardRingkasan.style.textOverflow = 'ellipsis';

                    cardTitle.addEventListener('mouseenter', function () {
                        // Display the item.ringkasan content in cardContent
                        card.innerHTML = "";
                        card.appendChild(cardContent);
                        cardContent.removeChild(cardEvent);
                        cardContent.removeChild(cardTitle);
                        cardContent.removeChild(divNarsum);
                        cardContent.appendChild(cardRingkasan);
                        cardContent.appendChild(showSummaryButton);
                    });
                    
                    card.addEventListener('mouseleave', function () {
                        // Remove the item.ringkasan content when the mouse leaves the button
                        cardContent.innerHTML = "";
                        card.appendChild(cardContent);
                        card.appendChild(cardImage);
                        card.appendChild(cardContent);
                        cardContent.appendChild(cardEvent);
                        cardContent.appendChild(cardTitle);
                        cardContent.appendChild(divNarsum);
                        cardContent.appendChild(showSummaryButton);
                    });  



                });
                fopen_narasumber.innerHTML = '';
                fcolumn_narasumber.innerHTML = '';
                fopen_event.innerHTML = '';
                fcolumn_event.innerHTML = '';
                fopen_tgl.innerHTML = '';
                fcolumn_tgl.innerHTML = '';

                if(data.result.narasumber.length > 0){
                    data.result.narasumber.forEach(function (item,index){
                        createCheckbox("ffv-n" + index,item,fopen_narasumber,data.result.countNarasumber);
                        createCheckbox("ffc-n" + index,item,fcolumn_narasumber,data.result.countNarasumber);
                    });
                }
                if(data.result.event.length > 0){
                    data.result.event.forEach(function (item,index){
                        createCheckbox("ffv-e" + index,item,fopen_event,data.result.countEvent);
                        createCheckbox("ffc-e" + index,item,fcolumn_event,data.result.countEvent);
                    });
                }
                if(data.result.tahun.length > 0){
                    data.result.tahun.forEach(function (item,index){
                        createCheckbox("ffv-t" + index,item.substring(0,4),fopen_tgl,data.result.countTahun);
                        createCheckbox("ffc-t" + index,item.substring(0,4),fcolumn_tgl,data.result.countTahun);
                    });
                }
            }
        })
        .catch(error => {
        // Handle any errors
        console.error(error);
        });
    }
}


function fetchNewest() {
    try {
        const main = document.getElementById('main');
        fetch(configPath + 'API/getNewest.php')
        .then(response => response.json())
        .then(data => {
            if (data.result === "E-CONN"){
                // location.href = configPath+"PHP/errorConn.php";
                errorConnHandling();
            }else{
                errorConnNoMore();
                const cardResultElement = document.getElementById('card_result');
                cardResultElement.innerHTML = '';
                if (data.hasil.length > 0) {
                    hs_head.innerHTML = ''; 
                    counter = 0;                
                    data.hasil.forEach(function (item) {
                        counter = counter + 1;

                        hs_head.innerHTML = '';
                        const hs_head_t = document.createElement('h5');
                        hs_head_t.textContent = "Terkini:";
                        hs_head_t.style.fontWeight = "bold";
                        hs_head.appendChild(hs_head_t);    

                        const cardItem = document.createElement('li');
                        cardItem.className = '_cards_item';

                        const card = document.createElement('div');
                        card.className = '_card';
                        card.id = "_card_"+counter;

                        card.setAttribute('onclick', `window.location.href='${configPath}PHP/selected_card.php?document_id=${item.id}'`);

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

                        const cardEvent = document.createElement('a');
                        cardEvent.className = '_card_text';
                        cardEvent.textContent = item.event;
                        cardEvent.onclick = function(event){
                            window.location.href = configPath+'PHP/related_results.php?event='+item.event;
                            event.stopPropagation();
                        }
                        cardEvent.style.textDecoration = 'none';

                        const cardTitle = document.createElement('h2');
                        cardTitle.className = '_card_title';
                        cardTitle.textContent = item.judul;

                        // Append the card content to the card element
                        card.appendChild(cardImage);
                        card.appendChild(cardContent);

                        cardContent.appendChild(cardEvent);
                        cardContent.appendChild(cardTitle);
                        const divNarsum = document.createElement('div');
                        var count = 0;
                        fetchNarsum(item.narasumber).forEach(element => {
                            const cardText = document.createElement('a');
                            cardText.className = '_card_text';
                            if(fetchNarsum(item.narasumber).length - 1 == count){
                                cardText.textContent = element;
                            }else{
                                cardText.textContent = element + ", ";
                            }
                            count++;
                            cardText.onclick = function(event){
                                window.location.href = configPath+'PHP/related_results.php?narasumber='+element;
                                event.stopPropagation();
                            }
                            cardText.style.textDecoration = 'none';
                            divNarsum.appendChild(cardText);
                        });
                        divNarsum.style.display = 'block'
                        cardContent.appendChild(divNarsum);

                        cardItem.appendChild(card);
                        cardResultElement.appendChild(cardItem);

                        const cardRingkasan = document.createElement('p');
                        cardRingkasan.className = '_card_ringkasan';
                        cardRingkasan.textContent = item.deskripsi_pendek;
                        cardRingkasan.style.fontSize = '15px';
                        cardRingkasan.style.color = 'white'; // Set the text color to white

                        cardRingkasan.style.maxHeight = '15em'; // Adjust the height as needed
                        cardRingkasan.style.overflow = 'hidden';        
                        cardRingkasan.style.textOverflow = 'ellipsis';

                        cardTitle.addEventListener('mouseenter', function () {
                            // Display the item.ringkasan content in cardContent
                            card.innerHTML = "";
                            card.appendChild(cardContent);
                            cardContent.removeChild(cardEvent);
                            cardContent.removeChild(cardTitle);
                            cardContent.removeChild(divNarsum);
                            cardContent.appendChild(cardRingkasan);
                        });
                        
                        card.addEventListener('mouseleave', function () {
                            // Remove the item.ringkasan content when the mouse leaves the button
                            cardContent.innerHTML = "";
                            card.appendChild(cardContent);
                            card.appendChild(cardImage);
                            card.appendChild(cardContent);
                            cardContent.appendChild(cardEvent);
                            cardContent.appendChild(cardTitle);
                            cardContent.appendChild(divNarsum);
                        });  

                        FilterColumnCanvas.innerHTML = '';
                        FilterOpenCanvas.innerHTML = '';
                    });
                } else {
                    FilterColumnCanvas.innerHTML = '';
                    FilterOpenCanvas.innerHTML = '';

                    hs_head.innerHTML = '';
                    const hs_head_t = document.createElement('h5');
                    hs_head_t.textContent = "No Results Found";
                    hs_head_t.style.fontWeight = "bold";
                    hs_head.appendChild(hs_head_t);  
                }

                const showAllDiv = document.createElement('div');
                showAllDiv.setAttribute("style", "display: flex; justify-content: center; margin-top: 15px;");

                const showAllBtn = document.createElement('button');
                showAllBtn.type = "button";
                showAllBtn.className = "button";
                showAllBtn.style.maxWidth = "210px";
                showAllBtn.style.width = "200px";
                showAllBtn.style.height = "40px";
                showAllBtn.textContent = "Tampilkan Semua Data";
                showAllBtn.style.backgroundColor = "#1e0049";
                showAllBtn.style.color= "white";
                showAllBtn.onclick = function(){
                    window.location.href = configPath + "PHP/home.php/search/ ";
                }
                showAllDiv.appendChild(showAllBtn);
                main.appendChild(showAllDiv);
            }
        })
        
    } catch (error) {
        console.error('Terjadi kesalahan:', error);
    }
    resizeListEN()
}

function resizeListEN(){
    var contEN = document.getElementById('contEventNarsum');
    var c1 = document.getElementById('_card_1');
    if (c1 != null){
        var colFilter = document.getElementById('col-filter-md');
        var kontenS = document.getElementById('kontenS');
        var contEvent = document.getElementById('contEvent');
        var contNarsum = document.getElementById('contNarsum');
        
        var unitL = c1.clientWidth + 32;
        var availSpace = kontenS.clientWidth - colFilter.clientWidth - 16;
        var totalUnit = Math.floor(availSpace / unitL);
        var totalWidth = (totalUnit * unitL) - 25;
        // console.log(availSpace);
        contEN.setAttribute("style","width:"+availSpace+"px;");
        contEvent.setAttribute("style","width:"+totalWidth+"px");
        contNarsum.setAttribute("style","width:"+totalWidth+"px");
    }
}
window.addEventListener('resize', resizeListEN);

function fetchSearchResult() {
    // clrAllFilterCheckbox();
    filterNarasumber.length = 0;
    filterEvent.length = 0;
    filterTanggal.length = 0;

    var fetchinit = initFetchSearchFilter(false);
    var filterJson = fetchinit[0];
    if(pageSize > 12){
        filterJson = JSON.parse(filterJson);
        filterJson.currPage = pageSize - loadPage;
        filterJson.size = loadPage;
        filterJson = JSON.stringify(filterJson);
    }
    let query = fetchinit[1];
    if (filterJson != "-1"){

        // Get the card_result container element
        const cardResultElement = document.getElementById('card_result');
        if(pageSize == 12){
            cardResultElement.classList.remove('container-list');
            cardResultElement.classList.add('_cards');
            cardResultElement.classList.remove('_cards2');

            // Delete all card elements by setting the innerHTML to an empty string
            cardResultElement.innerHTML = '';
        }
        fetch(configPath + 'API/filterAPI.php', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            },
            body: filterJson,
        })
        .then(response => response.json())
        .then(data => {
            if (data.result === "E-CONN"){
                // location.href = configPath+"PHP/errorConn.php";
                errorConnHandling();
            }else{
                errorConnNoMore();
                // setMaxPage(data.result.total);

                const cardResultElement = document.getElementById('card_result');
                // cardResultElement.classList.remove('container-list');
                // cardResultElement.innerHTML = '';
                if (data.result.data_result.length > 0) {      
                    setHeadSearch(query,data.result.total);
                    // FOR EACH
                    data.result.data_result.forEach(function (item) {

                    const cardItem = document.createElement('li');
                    cardItem.className = '_cards_item';

                    const card = document.createElement('div');
                    card.className = '_card';
                    card.setAttribute('onclick', `window.location.href='${configPath}PHP/selected_card.php?document_id=${item.id}'`);

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
        
                    const cardEvent = document.createElement('a');
                    cardEvent.className = '_card_text';
                    cardEvent.textContent = item.event;
                    cardEvent.onclick = function(event){
                        window.location.href = configPath+'PHP/related_results.php?event='+item.event;
                        event.stopPropagation();
                    }
                    cardEvent.style.textDecoration = 'none';

                    const cardTitle = document.createElement('h2');
                    cardTitle.className = '_card_title';
                    cardTitle.textContent = item.judul;

                    //  // Create a button to show item.ringkasan
                    // const showSummaryButton = document.createElement('button');
                    // showSummaryButton.className = 'show-summary-button';
                    // showSummaryButton.textContent = 'V';

                    card.appendChild(cardImage);
                    card.appendChild(cardContent);

                    cardContent.appendChild(cardEvent);
                    cardContent.appendChild(cardTitle);
                    const divNarsum = document.createElement('div');
                    var count = 0;
                    fetchNarsum(item.narasumber).forEach(element => {
                        const cardText = document.createElement('a');
                        cardText.className = '_card_text';
                        if(fetchNarsum(item.narasumber).length - 1 == count){
                            cardText.textContent = element;
                        }else{
                            cardText.textContent = element + ", ";
                        }
                        count++;
                        cardText.onclick = function(event){
                            window.location.href = configPath+'PHP/related_results.php?narasumber='+element;
                            event.stopPropagation();
                        }
                        cardText.style.textDecoration = 'none';
                        divNarsum.appendChild(cardText);
                    });
                    divNarsum.style.display = 'block'
                    cardContent.appendChild(divNarsum);

                    cardItem.appendChild(card);
                    cardResultElement.appendChild(cardItem);

                    const cardRingkasan = document.createElement('p');
                    cardRingkasan.className = '_card_ringkasan';
                    cardRingkasan.textContent = item.deskripsi_pendek;
                    cardRingkasan.style.color = 'white'; // Set the text color to white

                    cardRingkasan.style.maxHeight = '15em'; // Adjust the height as needed
                    cardRingkasan.style.overflow = 'hidden';        
                    cardRingkasan.style.textOverflow = 'ellipsis';

                    // cardContent.appendChild(showSummaryButton);

                    cardTitle.addEventListener('mouseenter', function () {
                        // Display the item.ringkasan content in cardContent
                        card.innerHTML = "";
                        card.appendChild(cardContent);
                        cardContent.removeChild(cardEvent);
                        cardContent.removeChild(cardTitle);
                        cardContent.removeChild(divNarsum);
                        cardContent.appendChild(cardRingkasan);
                        cardContent.appendChild(showSummaryButton);
                    });
                    
                    card.addEventListener('mouseleave', function () {
                        // Remove the item.ringkasan content when the mouse leaves the button
                        cardContent.innerHTML = "";
                        card.appendChild(cardContent);
                        card.appendChild(cardImage);
                        card.appendChild(cardContent);
                        cardContent.appendChild(cardEvent);
                        cardContent.appendChild(cardTitle);
                        cardContent.appendChild(divNarsum);
                        cardContent.appendChild(showSummaryButton);
                    });  

                });
                } else {
                    if(pageSize == 12){
                        FilterColumnCanvas.innerHTML = '';
                        FilterOpenCanvas.innerHTML = '';

                        hs_head.innerHTML = '';
                        const hs_head_t = document.createElement('h5');
                        hs_head_t.textContent = "No Results Found";
                        hs_head_t.style.fontWeight = "bold";
                        hs_head.appendChild(hs_head_t);  
                    }
                }
                    
                FilterColumnCanvas.innerHTML = '';
                FilterOpenCanvas.innerHTML = '';
                const titleFFC = document.createElement('h5');
                titleFFC.textContent = 'Filter';
                titleFFC.style.marginTop = '20px';
                titleFFC.style.marginBottom = '18px';
                titleFFC.style.fontWeight = 'bold';
                titleFFC.style.paddingTop = '15px';
                titleFFC.style.borderTop = '2px goldenrod solid';
                titleFFC.style.color = 'gold';
                FilterColumnCanvas.appendChild(titleFFC);

                const titleFFV = document.createElement('h5');
                titleFFV.textContent = 'Filter';
                titleFFV.style.marginTop = '20px';
                titleFFV.style.marginBottom = '20px';
                titleFFV.style.fontWeight = 'bold';
                titleFFV.style.paddingTop = '10px';
                titleFFV.style.borderTop = '2px goldenrod solid';
                titleFFV.style.color = 'gold';
                FilterOpenCanvas.appendChild(titleFFV);

                if(data.result.unique_narasumber.length > 0){

                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Narasumber";
                    titleFFC.id = "ffc-narasumber";
                    titleFFC.className = "ffc_head";
                    FilterColumnCanvas.appendChild(titleFFC);

                    const titleFFV = document.createElement('h6');
                    titleFFV.textContent = "Narasumber";
                    titleFFV.id = "ffv-narasumber";
                    titleFFV.className = "ffv_head";
                    FilterOpenCanvas.appendChild(titleFFV);

                    fcolumn_narasumber.innerHTML = '';
                    fcolumn_narasumber.className = "row ffc ";
                    fcolumn_narasumber.id = 'ffc-filter-naras';
                    FilterColumnCanvas.appendChild(fcolumn_narasumber);

                    fopen_narasumber.innerHTML = '';
                    fopen_narasumber.className = "row ffv";
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
                    FilterOpenCanvas.appendChild(titleFFV);

                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Event";
                    titleFFC.id = "ffc-event";
                    titleFFC.className = "ffc_head";
                    FilterColumnCanvas.appendChild(titleFFC);

                    fcolumn_event.innerHTML = '';
                    fcolumn_event.className = "row ffc";
                    fcolumn_event.id = 'ffc-filter-event';
                    FilterColumnCanvas.appendChild(fcolumn_event);

                    fopen_event.innerHTML = '';
                    fopen_event.className = "row ffv";
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
                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Tahun";
                    titleFFC.id = "ffc-tanggal";
                    titleFFC.className = "ffc_head";
                    FilterOpenCanvas.appendChild(titleFFV);
                    FilterColumnCanvas.appendChild(titleFFC);

                    fcolumn_tgl.innerHTML = '';
                    fcolumn_tgl.className = "row ffc";
                    
                    fcolumn_tgl.id = 'ffc-filter-tgl';
                    FilterColumnCanvas.appendChild(fcolumn_tgl);

                    fopen_tgl.innerHTML = '';
                    fopen_tgl.className = "row ffv";
                    fopen_tgl.id = 'ffv-filter-tgl';
                    FilterOpenCanvas.appendChild(fopen_tgl);

                    data.result.unique_tanggal.forEach(function (item,index){
                        createCheckbox("ffv-t" + index,item,fopen_tgl,data.result.countTahun);
                        createCheckbox("ffc-t" + index,item,fcolumn_tgl,data.result.countTahun);
                    });

                    const clrFilterBtn = document.createElement('button');
                    clrFilterBtn.type = 'button';
                    clrFilterBtn.className = "button clrfilter_btn";
                    clrFilterBtn.textContent = 'Hapus Semua Filter';
                    clrFilterBtn.style.color = 'black';
                    clrFilterBtn.onclick = clrAllFilterCheckbox;
                    FilterOpenCanvas.appendChild(clrFilterBtn);
                    FilterOpenCanvas.appendChild(clrFilterBtn);
                    const clrFilterBtn2 = document.createElement('button');
                    clrFilterBtn2.type = 'button';
                    clrFilterBtn2.className = "button clrfilter_btn";
                    clrFilterBtn2.textContent = 'Hapus Semua Filter';
                    clrFilterBtn2.style.color = 'black';
                    clrFilterBtn2.onclick = clrAllFilterCheckbox;
                    FilterOpenCanvas.appendChild(clrFilterBtn2);
                    FilterColumnCanvas.appendChild(clrFilterBtn2);
                }
            }
        })
        .catch(error => {
        // Handle any errors
        console.error(error);
        });
    }
}

function fetchNarsum(narsum_ori){
    let pembicara = narsum_ori;
    pembicara = pembicara.replace(/,S\./g, '|S.');
    pembicara = pembicara.replace(/, S\./g, '| S.');
    pembicara = pembicara.replace(/,B\./g, '|B.');
    pembicara = pembicara.replace(/, B\./g, '| B.');
    pembicara = pembicara.replace(/,M\./g, '|M.');
    pembicara = pembicara.replace(/, M\./g, '| M.');
    pembicara = pembicara.replace(/,Ph\./g, '|Ph.');
    pembicara = pembicara.replace(/, Ph\./g, '| Ph.');
    pembicara = pembicara.split(',');
    pembicara = pembicara.map(item => item.replace("|", ",").trim());
    return pembicara;
}

function fetchSearchResult2() {
    // clrAllFilterCheckbox();
    filterNarasumber.length = 0;
    filterEvent.length = 0;
    filterTanggal.length = 0;
    var fetchinit = initFetchSearchFilter(false);
    var filterJson = fetchinit[0];
    if(pageSize > 12){
        filterJson = JSON.parse(filterJson);
        filterJson.currPage = pageSize - loadPage;
        filterJson.size = loadPage;
        filterJson = JSON.stringify(filterJson);
        console.log(filterJson);
    }
    let query = fetchinit[1];

    if (filterJson != "-1"){
        const cardResultElement = document.getElementById('card_result');
        if(pageSize == 12){
            cardResultElement.classList.add('container-list');
            cardResultElement.classList.remove('_cards');
            cardResultElement.classList.add('_cards2');
            // Delete all card elements by setting the innerHTML to an empty string
            cardResultElement.innerHTML = '';
        }

        fetch(configPath + 'API/filterAPI.php', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            },
            body: filterJson,
        })
        .then(response => response.json())
        .then(data => {
            if (data.result === "E-CONN"){
                errorConnHandling();
            }else{
                errorConnNoMore();
                // setMaxPage(data.result.total);
                const cardResultElement = document.getElementById('card_result');
                if (data.result.data_result.length > 0) {

                    data.result.data_result.forEach(function (item) {
                        setHeadSearch(query,data.result.total);
                        // Create a card element
                        const cardItem = document.createElement('div');
                        cardItem.className = '_cards_item2';

                        const card = document.createElement('div');
                        card.className = '_card';
                        card.setAttribute('onclick', `window.location.href='${configPath}PHP/selected_card.php?document_id=${item.id}'`);

                        const cardContent = document.createElement('div');
                        cardContent.className = '_card_content';

                        const cardEvent = document.createElement('a');
                        cardEvent.className = '_card_text';
                        cardEvent.textContent = item.event;
                        cardEvent.onclick = function(event){
                            window.location.href = configPath+'PHP/related_results.php?event='+item.event;
                            event.stopPropagation();
                        }
                        cardEvent.style.textDecoration = 'none';

                        const cardTitle = document.createElement('h2');
                        cardTitle.className = '_card_title';
                        cardTitle.textContent = item.judul;

                        // Create a button to show item.ringkasan
                        const showSummaryButton = document.createElement('button');
                        showSummaryButton.className = 'show-summary-button';
                        showSummaryButton.textContent = 'V';

                        // Append the card content to the card element
                        card.appendChild(cardContent);

                        cardContent.appendChild(cardEvent);
                        cardContent.appendChild(cardTitle);
                        const divNarsum = document.createElement('div');
                        var count = 0;
                        fetchNarsum(item.narasumber).forEach(element => {
                            const cardText = document.createElement('a');
                            cardText.className = '_card_text';
                            if(fetchNarsum(item.narasumber).length - 1 == count){
                                cardText.textContent = element;
                            }else{
                                cardText.textContent = element + ", ";
                            }
                            count++;
                            cardText.onclick = function(event){
                                window.location.href = configPath+'PHP/related_results.php?narasumber='+element;
                                event.stopPropagation();
                            }
                            cardText.style.textDecoration = 'none';
                            divNarsum.appendChild(cardText);
                        });
                        divNarsum.style.display = 'block'
                        cardContent.appendChild(divNarsum);

                        // Append the card to the main container
                        cardItem.appendChild(card);
                        cardResultElement.appendChild(cardItem);

                        const cardRingkasan = document.createElement('p');
                        cardRingkasan.className = '_card_ringkasan';
                        cardRingkasan.textContent = item.deskripsi_pendek;
                        cardRingkasan.style.color = 'white'; // Set the text color to white

                        cardRingkasan.style.maxHeight = '4.4em'; // Adjust the height as needed
                        cardRingkasan.style.overflow = 'hidden';        
                        cardRingkasan.style.textOverflow = 'ellipsis';

                        cardContent.appendChild(showSummaryButton);

                        showSummaryButton.addEventListener('mouseenter', function () {
                            // Display the item.ringkasan content in cardContent
                            card.innerHTML = "";
                            card.appendChild(cardContent);
                            cardContent.removeChild(cardEvent);
                            cardContent.removeChild(cardTitle);
                            cardContent.removeChild(divNarsum);
                            cardContent.appendChild(cardRingkasan);
                            cardContent.appendChild(showSummaryButton);
                        });
                        
                        showSummaryButton.addEventListener('mouseleave', function () {
                            // Remove the item.ringkasan content when the mouse leaves the button
                            cardContent.innerHTML = "";
                            card.appendChild(cardContent);
                            cardContent.appendChild(cardEvent);
                            cardContent.appendChild(cardTitle);
                            cardContent.appendChild(divNarsum);
                            cardContent.appendChild(showSummaryButton);
                        });  
                    });
                }
                else {
                    if(pageSize == 12){
                        FilterColumnCanvas.innerHTML = '';
                        FilterOpenCanvas.innerHTML = '';

                        hs_head.innerHTML = '';
                        const hs_head_t = document.createElement('h5');
                        hs_head_t.textContent = "No Results Found";
                        hs_head_t.style.fontWeight = "bold";
                        hs_head.appendChild(hs_head_t);  
                    }
                }

                FilterColumnCanvas.innerHTML = '';
                FilterOpenCanvas.innerHTML = '';
                const titleFFC = document.createElement('h5');
                titleFFC.textContent = 'Filter';
                titleFFC.style.marginTop = '20px';
                titleFFC.style.marginBottom = '18px';
                titleFFC.style.fontWeight = 'bold';
                titleFFC.style.paddingTop = '15px';
                titleFFC.style.borderTop = '2px goldenrod solid';
                titleFFC.style.color = 'gold';
                FilterColumnCanvas.appendChild(titleFFC);

                const titleFFV = document.createElement('h5');
                titleFFV.textContent = 'Filter';
                titleFFV.style.marginTop = '20px';
                titleFFV.style.marginBottom = '20px';
                titleFFV.style.fontWeight = 'bold';
                titleFFV.style.paddingTop = '10px';
                titleFFV.style.borderTop = '2px goldenrod solid';
                titleFFV.style.color = 'gold';
                FilterOpenCanvas.appendChild(titleFFV);

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
                    fcolumn_narasumber.id = 'ffc-filter-naras';
                    FilterColumnCanvas.appendChild(fcolumn_narasumber);

                    fopen_narasumber.innerHTML = '';
                    fopen_narasumber.className = "row ffv";
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
                    FilterOpenCanvas.appendChild(titleFFV);

                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Event";
                    titleFFC.id = "ffc-event";
                    titleFFC.className = "ffc_head";
                    FilterColumnCanvas.appendChild(titleFFC);

                    fcolumn_event.innerHTML = '';
                    fcolumn_event.className = "row ffc";
                    fcolumn_event.id = 'ffc-filter-event';
                    FilterColumnCanvas.appendChild(fcolumn_event);

                    fopen_event.innerHTML = '';
                    fopen_event.className = "row ffv";
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
                    const titleFFC = document.createElement('h6');
                    titleFFC.textContent = "Tahun";
                    titleFFC.id = "ffc-tanggal";
                    titleFFC.className = "ffc_head";
                    FilterOpenCanvas.appendChild(titleFFV);
                    FilterColumnCanvas.appendChild(titleFFC);

                    fcolumn_tgl.innerHTML = '';
                    fcolumn_tgl.className = "row ffc";
                    fcolumn_tgl.id = 'ffc-filter-tgl';
                    FilterColumnCanvas.appendChild(fcolumn_tgl);

                    fopen_tgl.innerHTML = '';
                    fopen_tgl.className = "row ffv";
                    fopen_tgl.id = 'ffv-filter-tgl';
                    FilterOpenCanvas.appendChild(fopen_tgl);

                    data.result.unique_tanggal.forEach(function (item,index){
                        createCheckbox("ffv-t" + index,item,fopen_tgl,data.result.countTahun);
                        createCheckbox("ffc-t" + index,item,fcolumn_tgl,data.result.countTahun);
                    });

                    const clrFilterBtn = document.createElement('button');
                    clrFilterBtn.type = 'button';
                    clrFilterBtn.className = "button clrfilter_btn";
                    clrFilterBtn.textContent = 'Hapus Semua Filter';
                    clrFilterBtn.style.color = 'black';
                    clrFilterBtn.onclick = clrAllFilterCheckbox;
                    FilterOpenCanvas.appendChild(clrFilterBtn);
                    const clrFilterBtn2 = document.createElement('button');
                    clrFilterBtn2.type = 'button';
                    clrFilterBtn2.className = "button clrfilter_btn";
                    clrFilterBtn2.textContent = 'Hapus Semua Filter';
                    clrFilterBtn2.style.color = 'black';
                    clrFilterBtn2.onclick = clrAllFilterCheckbox;
                    FilterOpenCanvas.appendChild(clrFilterBtn2);
                    FilterColumnCanvas.appendChild(clrFilterBtn2);
                }
            }
        })
        .catch(error => {
        console.error(error);
        });
    }
}

function setHeadSearch(query,jumlah){
    hs_head.innerHTML = '';

    const hs_head_col1 = document.createElement('div');
    hs_head_col1.className = 'col-10 hshc1';
    
    const hs_head_t = document.createElement('h5');
    if (query === ""){
            hs_head_t.textContent = "Hasil Pencarian untuk Semua Data (" + jumlah + " data)";
    }else {
            hs_head_t.textContent = "Hasil Pencarian untuk : " + query + " (" + jumlah + " data)";
    }

    hs_head_t.style.fontWeight = "bold";
    hs_head_col1.appendChild(hs_head_t);   

    const hs_head_col2 = document.createElement('div');
    hs_head_col2.className = 'col-2 hshc2';
    hs_head_col2.setAttribute("style", "display: flex; justify-content: right;");

    var dropd = document.createElement('div');
    dropd.className = "dropdown";

    var dropBtn = document.createElement('button');
    dropBtn.className = "btn btn-secondary dropdown-toggle drop-btn";
    dropBtn.type = "button";
    dropBtn.textContent = "View As :  ";
    dropBtn.style.width = "100px";
    dropBtn.style.height = "30px";
    dropBtn.dataset.bsToggle = 'dropdown';
    dropBtn.setAttribute('aria-expanded', false);
    dropBtn.style.backgroundColor = "#1e0049";
    dropd.appendChild(dropBtn);

    var dropUl = document.createElement('ul');
    dropUl.className = "dropdown-menu";

    var dropLi1 = document.createElement('li');
    var dropLi_Grid = document.createElement('a');
    dropLi_Grid.className = "dropdown-item drop-li-a";
    dropLi_Grid.textContent = "Grid";
    dropLi_Grid.style.color = "black";
    dropLi_Grid.onclick = function(){
        sessionStorage.setItem("mode", "card");
        pageSize = 12;
        rowsPassed = 0;
        if(filterEvent.length == 0 && filterNarasumber == 0 && filterTanggal == 0){
            fetchSearchResult();
        }else{
            fetchSearchFilterResult();
        }
    }
    dropLi1.appendChild(dropLi_Grid);

    var dropLi2 = document.createElement('li');
    var dropLi_List = document.createElement('a');
    dropLi_List.className = "dropdown-item drop-li-a";
    dropLi_List.textContent = "List";
    dropLi_List.style.color = "black";
    dropLi_List.onclick = function(){
        sessionStorage.setItem("mode", "list");
        pageSize = 12;
        rowsPassed = 0;
        if(filterEvent.length == 0 && filterNarasumber == 0 && filterTanggal == 0){
            fetchSearchResult2();
        }else{
            fetchSearchFilterResult2();
        }
    }
    dropLi2.appendChild(dropLi_List);

    dropUl.appendChild(dropLi1);
    dropUl.appendChild(dropLi2);
    dropd.appendChild(dropUl);

    hs_head_col2.appendChild(dropd);
    hs_head.appendChild(hs_head_col1);
    hs_head.appendChild(hs_head_col2);
}

// function setPagination(){
//     const showDiv = document.getElementById("show");
//     showDiv.innerHTML = '';

//     const pagiCont = document.createElement("div");
//     pagiCont.innerHTML = '';
//     pagiCont.id = "show";
//     pagiCont.style.display = "flex";
//     pagiCont.style.justifyContent = "end";

//     const pagiUl = document.createElement("ul");
//     pagiUl.className = "pagination"

//     pagiUl.appendChild(createListItem2("<<"));
//     if ((currPage - 1) > 0){
//         pagiUl.appendChild(createListItem2("Prev"));
//     }
//     c_pagi = 0;
//     p_pagi = -8;
//     while (c_pagi < 17){
//         if ((currPage + p_pagi) > maxPage ){
//                 break;
//         }
//         if ((currPage + p_pagi) > 0){
//                 pagiUl.appendChild(createListItem2(currPage + p_pagi));
//                 c_pagi += 1;
//         }
//         p_pagi += 1;
//     }
//     if ((currPage + 1) < maxPage ){
//         pagiUl.appendChild(createListItem2("Next"));
//     }
//     pagiUl.appendChild(createListItem2(">>"));
//     pagiUl.appendChild(createListItem2("Show All"));
//     pagiCont.appendChild(pagiUl);
//     showDiv.appendChild(pagiCont);

//     // Menampilkan nomer halaman sekarang dan terakhir
//     var showPagiProg = document.createElement("p");
//     showPagiProg.style.textAlign = "end";
//     showPagiProg.style.marginRight = "16px";
//     showPagiProg.textContent = "Page " + currPage + " of " + maxPage;
//     showDiv.appendChild(showPagiProg);
// }

function getYoutubeVideoId(url) {
    const pattern = /(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/;
    const matches = url.match(pattern);

    if (matches && matches[1]) {
        return matches[1]; // YouTube video ID
    } else {
        return null; // Invalid YouTube URL or ID not found
    }
}

window.addEventListener('scroll', () => {
    // Dapatkan posisi scroll dari window
    const scrolled = window.scrollY;

    // Hitung jumlah baris yang sudah dilewati
    const passedRows = Math.floor(scrolled / cardHeight);

    // Cek apakah jumlah baris yang sudah dilewati berubah
    if (passedRows > rowsPassed) {
        pageSize += loadPage;
        if(filterEvent.length == 0 && filterNarasumber.length == 0 && filterTanggal == 0){
            if(sessionStorage.getItem("mode") == "card"){
                fetchSearchResult();
            }else if(sessionStorage.getItem("mode") == "list"){
                fetchSearchResult2();
            }
        }else{
            if(sessionStorage.getItem("mode") == "card"){
                fetchSearchFilterResult();
            }else if(sessionStorage.getItem("mode") == "list"){
                fetchSearchFilterResult2();
            }
        }
        rowsPassed = passedRows;
    }
});

var errorConn = false;
var pageSizes = 12
let rowsPasseds = 0;
let cardHeights = window.innerHeight / 2;

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

if (keyword) {
    fetch(configPath + `API/getKeyword.php?query=${encodeURIComponent(keyword)}`)
        .then(response => response.json())
        .then(data => {
            const hasil = data.hasil;
            if (hasil === "E-CONN"){
                errorConnHandling();
            }else{
                errorConnNoMore();
                showResults(hasil);
            }
            // Display the results
            
        })
        .catch(error => {
            console.error(error);
        });
} else {
    console.log("No keyword provided.");
}

function scrollToBottom() {
    const fullHeight = Math.max(
        document.body.scrollHeight,
        document.body.offsetHeight,
        document.documentElement.clientHeight,
        document.documentElement.scrollHeight,
        document.documentElement.offsetHeight
    );

    window.scrollTo({
        top: fullHeight,
        behavior: 'smooth'
    });
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

function buttonVisibility() {
    const buttonScrollDown = document.getElementById('down-button');
    const buttonScrollUp = document.getElementById('up-button');
    const windowHeight = window.innerHeight;
    const scrollPosition = window.scrollY;
    const bodyHeight = document.body.scrollHeight;

    // Menghitung batas atas dan bawah untuk menampilkan tombol scroll
    const scrollDownThreshold = bodyHeight - windowHeight - 100;
    const scrollUpThreshold = 100; 

    if (scrollPosition > scrollDownThreshold) {
        buttonScrollDown.style.display = 'none';
    } else {
        buttonScrollDown.style.display = 'block';
    }

    if (scrollPosition > scrollUpThreshold) {
        buttonScrollUp.style.display = 'block';
    } else {
        buttonScrollUp.style.display = 'none';
    }
}

window.addEventListener('scroll', buttonVisibility);

const buttonScrollUp = document.getElementById('up-button')
buttonScrollUp.style.display = 'none';

if (narsum) {
    // Fetch the related results using the getKeyword.php API
    console.log(narsum)
    fetch(configPath + `API/getNarsum.php?query=${encodeURIComponent(narsum)}`)
        .then(response => response.json())
        .then(data => {
            const hasil = data.hasil;
            if (hasil === "E-CONN"){
                errorConnHandling();
            }else{
                errorConnNoMore();
                showResults(hasil);
            }
        })
        .catch(error => {
            console.error(error);
        });
} else {
    console.log("No keyword provided.");
}

if (event_) {
    // Fetch the related results using the getEvent_.php API
    console.log(event_)
    fetch(configPath + `API/getEvent.php?query=${encodeURIComponent(event_)}`)
        .then(response => response.json())
        .then(data => {
            const hasil = data.hasil;
            if (hasil === "E-CONN"){
                errorConnHandling();
            }else{
                errorConnNoMore();
                showResults(hasil);
            }
        })
        .catch(error => {
            console.error(error);
        });
} else {
    console.log("No keyword provided.");
}

/*
    CODE UNTUK LIST SEMUA NARASUMBER DAN EVENT
*/
// Get the value of the 'event' query parameter from the URL
const urlParams = new URLSearchParams(window.location.search);
const eventParam = urlParams.get('event');
const narsumParam = urlParams.get('narasumber');


if (eventParam) {
    // Fetch the related results using the getEvent.php API
    fetch(configPath + `API/getEvent.php?query=${encodeURIComponent(eventParam)}`)
        .then(response => response.json())
        .then(data => {
            const hasil = data.hasil;
            if (hasil === "E-CONN"){
                errorConnHandling();
            }else{
                errorConnNoMore();
                showResults(hasil);
            }
        })
        .catch(error => {
            console.error(error);
        });
} else {
    console.log("No event parameter provided.");
}

if (narsumParam) {
    // Fetch the related results using the getEvent.php API
    fetch(configPath + `API/getNarsum.php?query=${encodeURIComponent(narsumParam)}`)
        .then(response => response.json())
        .then(data => {
            const hasil = data.hasil;
            if (hasil === "E-CONN"){
                errorConnHandling();
            }else{
                errorConnNoMore();
                showResults(hasil);
            }
        })
        .catch(error => {
            console.error(error);
        });
} else {
    console.log("No event parameter provided.");
}

var pageSizeRel = 12;
var currPageRel = 1;
var maxPageRel = 1;
var showAllRel = false;

function PageRel(pageNumber) {
    const li = document.createElement('li');
    li.className = "page-item";

    var a = document.createElement('a');
    a.className = "page-link";
    a.id = "pagiRel_"+pageNumber;
    if (pageNumber === "Show All"){
        if (showAllRel){
            a.innerText = "Unshow All";
        }else {
            a.innerText = pageNumber;
        }
    }else{
        a.innerText = pageNumber;
    }
    
    if (pageNumber === currPageRel){
        a.setAttribute("style","color: gold;")
        a.style.backgroundColor = "#1e0049";
    }

    a.onclick = function(event){
        if (pageNumber != currPageRel){
            if (pageNumber === "Show All"){
                if(!showAllRel){
                    pageSizeRel = maxPageRel * 12;
                    showAllRel = true;
                }else{
                    pageSizeRel = 12;
                    showAllRel = false;
                }
                currPageRel = 1;
                showResults(relResult);
            }
            else if(pageNumber == "Next"){
                if((currPageRel + 1) <= maxPageRel){
                    currPageRel += 1;
                }
            }
            else if(pageNumber == "Prev"){
                if((currPageRel - 1) >= 1){
                    currPageRel -= 1;
                }
            }
            else if(pageNumber == "<<"){
                currPage = 1;
            }
            else if(pageNumber == ">>"){
                currPage = maxPage;
            }
            else{
                currPageRel = pageNumber;
            }
            generateCard(paginate(relResult));
            setPagiRel();

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            })
            
        }
    };
    
    li.appendChild(a);
    return li;
}  

function setPagiRel(){
    const showDiv = document.getElementById("show");//document.createElement("div");
    showDiv.innerHTML = '';

    const pagiCont = document.createElement("div");
    pagiCont.innerHTML = '';
    pagiCont.id = "showRel";
    pagiCont.style.display = "flex";
    pagiCont.style.justifyContent = "end";

    const pagiUl = document.createElement("ul");
    pagiUl.className = "pagination"

    // Mengisi Pagination

    pagiUl.appendChild(PageRel("<<"));

    if ((currPageRel - 1) > 0){
        pagiUl.appendChild(PageRel("Prev"));
    }
    c_pagi = 0;
    p_pagi = -8;
    while (c_pagi < 17){
        if ((currPageRel + p_pagi) > maxPageRel){
                break;
        }
        if ((currPageRel + p_pagi) > 0){
                pagiUl.appendChild(PageRel(currPageRel + p_pagi));
                c_pagi += 1;
        }
        p_pagi += 1;
    }
    if ((currPageRel + 1) < maxPageRel ){
        pagiUl.appendChild(PageRel("Next"));
    }

    pagiUl.appendChild(PageRel(">>"));

    
    pagiUl.appendChild(PageRel("Show All"));
    pagiCont.appendChild(pagiUl);
    showDiv.appendChild(pagiCont);

    // Menampilkan nomer halaman sekarang dan terakhir
    var showPagiProg = document.createElement("p");
    showPagiProg.id = "dispPagiRel";
    showPagiProg.style.textAlign = "end";
    showPagiProg.style.marginRight = "16px";
    showPagiProg.textContent = "Page " + currPageRel + " of " + maxPageRel;
    showDiv.appendChild(showPagiProg);
}

var relResult = [];
function showResults(results) {
    relResult = results
    console.log(results.length);
    maxPageRel = Math.ceil(results.length / pageSizeRel);
    setPagiRel()
    generateCard(paginate(results));
}

function paginate(array) {
    if(pageSizes == 12){
        return array.slice(0,pageSizes)
    }else{
        return array.slice(pageSizes - 4 , pageSizes);
    }
}

function generateCard(results){
    
    // Get the card_result container element
    const cardResultElement = document.querySelector('#p3_relatedResult #card_result');

    const colKontenHeadElement = document.querySelector('.col-konten-head.terkait');

    // Delete all card elements by setting the innerHTML to an empty string
    const testParagraph = document.getElementById('related-search');
    if(pageSizes == 12){
        cardResultElement.innerHTML = '';
        if (eventParam) {
            testParagraph.innerHTML = '<h2 class="centered-text">Pencarian Terkait</h2><h4 class="centered-text large-text">' + eventParam + '</h4>';
        }
        if (narsumParam) {
            testParagraph.innerHTML = '<h2 class="centered-text">Pencarian Terkait</h2><h4 class="centered-text large-text">' + narsumParam + '</h4>';
        }
    }

    if (results.length > 0) {
        results.forEach(function (item) {
            const cardItem = document.createElement('li');
            cardItem.className = '_cards_item';

            const card = document.createElement('div');
            card.className = '_card';
            card.setAttribute('onclick', `window.location.href='selected_card.php?document_id=${item.id}'`);

            const cardImage = document.createElement('div');
            cardImage.className = '_card_image';

            if (item.youtube) {
                console.log("Test");
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


            // Create a button to show item.ringkasan
            const showSummaryButton = document.createElement('button');
            showSummaryButton.className = 'show-summary-button';
            showSummaryButton.textContent = 'V';

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
                card.appendChild(cardImage);
                card.appendChild(cardContent);
                cardContent.appendChild(cardEvent);
                cardContent.appendChild(cardTitle);
                cardContent.appendChild(divNarsum);
                cardContent.appendChild(showSummaryButton);
            });  
        });
    } else {
        if(pageSizes == 12){
            const noResults = document.createElement('p');
            noResults.textContent = 'No results found.';
            cardResultElement.appendChild(noResults);
        }
        // sd
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

window.addEventListener('scroll', () => {
    // Dapatkan posisi scroll dari window
    const scrolled = window.scrollY;

    // Hitung jumlah baris yang sudah dilewati
    const passedRows = Math.floor(scrolled / cardHeights);

    // Cek apakah jumlah baris yang sudah dilewati berubah
    if (passedRows > rowsPasseds) {
        pageSizes += 4;
        generateCard(paginate(relResult))
    }
});



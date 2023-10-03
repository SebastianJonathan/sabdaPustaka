var errorConn = false;

function errorConnHandling(){
    if (!errorConn){
        location.href = configPath + "PHP/errorConn.php";
    }
    errorConn = true;
}

function errorConnNoMore(){
    errorConn = false;
}

const keywordLinks = document.querySelectorAll('.keyword-link');
keywordLinks.forEach(link => {
    link.addEventListener('click', (e) => {
    e.preventDefault();
    const query = link.dataset.keyword;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'related_results.php';

    const keywordInput = document.createElement('input');
    keywordInput.type = 'hidden';
    keywordInput.name = 'keyword';
    keywordInput.value = query;

    form.appendChild(keywordInput);

    document.body.appendChild(form);
    form.submit();
    });
});

const narsumLinks = document.querySelectorAll('.narsum-link');
narsumLinks.forEach(link => {
    link.addEventListener('click', (e) => {
    e.preventDefault();
    const query = link.dataset.keyword;
    // window.alert(query);
    sessionStorage.setItem("SpecificType", "narsum");
    sessionStorage.setItem("SpecificFilter", query);
    window.location.href = configPath+'PHP/home.php/search/'+query;

    });
});

const eventLinks = document.querySelectorAll('.event-link');
eventLinks.forEach(link => {
    link.addEventListener('click', (e) => {
    e.preventDefault();
    const query = link.dataset.keyword;
    window.alert(query);

    sessionStorage.setItem("SpecificType", "event");
    sessionStorage.setItem("SpecificFilter", query);
    window.location.href = configPath+'PHP/home.php/search/'+query;
    });
}); 


function togglePdfViewer() {
    var pdfViewer = document.getElementById('pdfViewer');
    var image = document.getElementById('image');
    if (pdfViewer.style.display === 'none') {
    pdfViewer.style.display = 'block';
    image.style.display = 'none';
    } else {
    pdfViewer.style.display = 'none';
    image.style.display = 'block';
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

function getQueryParameterValue(url, parameterName) {
    const params = new URLSearchParams(new URL(url).search);
    return params.get(parameterName);
}

function fetchRelatedDocuments() {

    const documentId = getQueryParameterValue(location.href, "document_id");

    fetch(configPath + `API/getRelated.php?document_id=${encodeURIComponent(documentId)}`)
    .then(response => response.json())
    .then(data => {
        if (data === "E-CONN"){
            errorConnHandling();
        }else{
            errorConnNoMore();
            const relatedResultsContainer = document.getElementById('related-results-container');
            if(data.result.length > 0){
                const title = document.createElement('h3');
                title.textContent = "Materi Terkait"
                relatedResultsContainer.appendChild(title)
            }
            getCard(data, relatedResultsContainer);
        }
    })
    .catch(error => {
        console.error(error);
    });
}


function fetchRelatedJudul() {
    const documentId = getQueryParameterValue(location.href, "document_id");

    fetch(configPath + `API/getRelatedJudul.php?document_id=${encodeURIComponent(documentId)}`)
    .then(response => response.json())
    .then(data => {
        if (data === "E-CONN"){
            errorConnHandling();
        }else{
            errorConnNoMore();
            const relatedResultsContainer = document.getElementById('related-judul-container');
            if(data.result.length > 0){
                const title = document.createElement('h3');
                title.textContent = "Kata Kunci Terkait"
                relatedResultsContainer.appendChild(title)
            }
            getCard(data, relatedResultsContainer);
            // relatedResultsContainer.innerHTML = data;

            
        }
    })
    .catch(error => {
        console.error(error);
    });
}

function getCard(data, root_div){
    var card_container = document.createElement('div');
    card_container.className = "_cards-container";

    var card_main = document.createElement('div');
    card_main.className = "main";
    card_main.style.overflow = "hidden";

    var cardResultElement = document.createElement('ul');
    cardResultElement.className = "_cards";
    cardResultElement.id = "card_result"
    cardResultElement.style.flexWrap = "nowrap";
    cardResultElement.style.overflow = "scroll";

    if (data.result.length > 0){
        data.result.forEach(function (item) {

            const cardItem = document.createElement('li');
            cardItem.className = '_cards_item';
            cardItem.id = '_cards_item_';

            const card = document.createElement('div');
            card.className = '_card';
            card.setAttribute('onclick', `window.location.href='${configPath}PHP/selected_card.php?document_id=${item._id}'`);

            const cardImage = document.createElement('div');
            cardImage.className = '_card_image';

            if (item._source.url_youtube) {
                const youtubeUrl = item._source.url_youtube;
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
            cardEvent.textContent = item._source.event;
            cardEvent.onclick = function(event){
                sessionStorage.setItem("SpecificType", "event");
                sessionStorage.setItem("SpecificFilter", item._source.event);
                window.location.href = configPath+'PHP/home.php/search/'+item._source.event;
                event.stopPropagation();
            }
            cardEvent.style.textDecoration = 'none';

            const cardTitle = document.createElement('h2');
            cardTitle.className = '_card_title';
            cardTitle.textContent = item._source.judul;

            card.appendChild(cardImage);
            card.appendChild(cardContent);

            cardContent.appendChild(cardEvent);
            cardContent.appendChild(cardTitle);
            const divNarsum = document.createElement('div');
            var count = 0;

            fetchNarsum(item._source.narasumber).forEach(element => {
                const cardText = document.createElement('a');
                cardText.className = '_card_text';
                if(fetchNarsum(item._source.narasumber).length - 1 == count){
                    cardText.textContent = element;
                }else{
                    cardText.textContent = element + ", ";
                }
                count++;
                cardText.onclick = function(event){
                    sessionStorage.setItem("SpecificType", "narsum");
                    sessionStorage.setItem("SpecificFilter", element);
                    window.location.href = configPath+'PHP/home.php/search/'+element;
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
            cardRingkasan.textContent = item._source.deskripsi_pendek;
            cardRingkasan.style.color = 'white';

            cardRingkasan.style.maxHeight = '15em';
            cardRingkasan.style.overflow = 'hidden';        
            cardRingkasan.style.textOverflow = 'ellipsis';

            cardImage.addEventListener('mouseenter', function () {
                card.innerHTML = "";
                card.appendChild(cardContent);
                cardContent.removeChild(cardEvent);
                cardContent.removeChild(cardTitle);
                cardContent.removeChild(divNarsum);
                cardContent.appendChild(cardRingkasan);
            });
            
            card.addEventListener('mouseleave', function () {
                cardContent.innerHTML = "";
                card.appendChild(cardContent);
                card.appendChild(cardImage);
                card.appendChild(cardContent);
                cardContent.appendChild(cardEvent);
                cardContent.appendChild(cardTitle);
                cardContent.appendChild(divNarsum);
            }); 

        });

    }

    card_main.appendChild(cardResultElement);
    card_container.appendChild(card_main);
    root_div.appendChild(card_container);
}

// Call the fetchRelatedDocuments function to fetch and display the related document titles
fetchRelatedDocuments();
fetchRelatedJudul();

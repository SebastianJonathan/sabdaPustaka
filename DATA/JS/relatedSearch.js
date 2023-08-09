




if (keyword) {
    // Fetch the related results using the getKeyword.php API

    fetch(configPath + `API/getKeyword.php?query=${encodeURIComponent(keyword)}`)
        .then(response => response.json())
        .then(data => {
            const hasil = data.hasil;

            // Display the results
            showResults(hasil);
        })
        .catch(error => {
            console.error(error);
        });
} else {
    console.log("No keyword provided.");
}

if (narsum) {
    // Fetch the related results using the getKeyword.php API
    console.log(narsum)
    fetch(configPath + `API/getNarsum.php?query=${encodeURIComponent(narsum)}`)
        .then(response => response.json())
        .then(data => {
            const hasil = data.hasil;

            // Display the results
            console.log(data);
            showResults(hasil);
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

            // Display the results
            showResults(hasil);
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
            $narsumparam = narsumParam;

            showResults(hasil);
        })
        .catch(error => {
            console.error(error);
        });
} else {
    console.log("No event parameter provided.");
}


function showResults(results) {
    // Get the card_result container element
    const cardResultElement = document.querySelector('#p3_relatedResult #card_result');

    
    const colKontenHeadElement = document.querySelector('.col-konten-head.terkait');

    // Delete all card elements by setting the innerHTML to an empty string
    cardResultElement.innerHTML = '';

    const testParagraph = document.getElementById('related-search');

    if (eventParam) {
        testParagraph.innerHTML = '<h2 class="centered-text">Pencarian Terkait</h2><h4 class="centered-text large-text">' + eventParam + '</h4>';
    }
    if (narsumParam) {
        testParagraph.innerHTML = '<h2 class="centered-text">Pencarian Terkait</h2><h4 class="centered-text large-text">' + narsumParam + '</h4>';
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



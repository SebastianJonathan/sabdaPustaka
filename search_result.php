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
            }})
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

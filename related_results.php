<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'header.php';
    ?>

    <style>
        .col-konten-head>h2 {
            margin-top: 30px;
            font-weight: bold;
        }


        .centered-text {
            text-align: center;
        }

        .large_text {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    include 'navbar.php';
    ?>

    <div class="container-fluid">
        <div class="row row-search">
            <form action="" id="search" class="content">
                <!-- Filter + Konten -->
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="col-konten-head">
                            <?php
                            if (isset($_POST['keyword'])) {
                                $keyword = $_POST['keyword'];
                                echo '<h2 class="centered-text">Related Search</h2><h4 class="centered-text large-text">' . ucfirst($keyword) . '</h4>';                                
                            }

                            if (isset($_POST['narasumber'])){
                                $narsum = $_POST['narasumber'];
                                echo '<h2 class="centered-text">Related Search</h2><h4 class="centered-text large-text">' . ucfirst($narsum) . '</h4>';       
                            }
                            ?>
                        </div>

                        <?php include 'search_result.php'; ?>
                    </div>
                </div> <!-- row konten -->

                <!-- Spacer -->
                <div class="row" style="height: 20px;"></div>
            </form>
        </div>
        </ul>
    </div>
    </div>

    <script>
        // Extract the keyword from the POST data
        const keyword = "<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : ''; ?>";
        const narsum = "<?php echo isset($_POST['narasumber']) ? $_POST['narasumber'] : ''; ?>";

        if (keyword) {
            // Fetch the related results using the getKeyword.php API
            fetch(`http://localhost/UI/sabdaPustaka/getKeyword.php?query=${encodeURIComponent(keyword)}`)
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
            fetch(`http://localhost/UI/sabdaPustaka/getNarsum.php?query=${encodeURIComponent(narsum)}`)
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

        function showResults(results) {
            // Get the card_result container element
            const cardResultElement = document.getElementById('card_result');

            // Delete all card elements by setting the innerHTML to an empty string
            cardResultElement.innerHTML = '';

            if (results.length > 0) {
                results.forEach(function(item) {
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
    </script>

    </div>



    <?php include 'footer.php'; ?>
</body>

</html>

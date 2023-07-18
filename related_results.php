<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'header.php';
    ?>
</head>

<body>
    <?php
    include 'navbar.php';
    ?>

    <div class="container-fluid">
        <div class="row row-search">
            <form action="" id="search" class="content">
                <div class="rekomendasi-container">
                    <div class="col-md-6 InputContainer">
                        <input placeholder="Search.." id="query" class="query form-control form-input" name="query" type="text" autocomplete="off">
                        <button type="button" class="search-button" onclick="getSearchResult()">Search</button>
                    </div>
                    <div id="rekomendasi">
                        <ul id="rekomendasi-list"></ul>
                    </div>
                </div>
                <!-- Filter + Konten -->
                <div class="row">
                    <div class="col-md-2 col-filter" style="border-right: 1px black solid; padding-right: 5px; padding-left:10px;">
                        <div class="row">
                            <h5>Filter</h5>
                        </div>
                        <!-- Judul Narasumber Event -->
                        <div class="row fsc">
                            <div class="checkbox-container">
                                <label for="checkbox_judul" class="form-check-label checkbox-label bigger">
                                    <input type="checkbox" class="form-check-input bigger" id="checkbox_judul" name="checkbox_judul" value="judul" onchange="">
                                    Judul
                                </label>
                            </div>
                            <div class="checkbox-container">
                                <label for="checkbox_narasumber" class="form-check-label checkbox-label bigger">
                                    <input type="checkbox" class="form-check-input bigger" id="checkbox_narasumber" name="checkbox_narasumber" value="narasumber" onchange="">
                                    Narasumber
                                </label>
                            </div>
                            <div class="checkbox-container">
                                <label for="checkbox_event" class="form-check-label checkbox-label bigger">
                                    <input type="checkbox" class="bigger form-check-input" id="checkbox_event" name="checkbox_event" value="event" onchange="">
                                    Event
                                </label>
                            </div>
                            <div class="buttons">
                                <button type="button" class="button" onclick="selectAll()">Select all</button>
                                <button type="button" class="button" onclick="clearSelection()">Clear selection</button>
                            </div>
                        </div>

                        <!-- Filter -->
                        <div class="row ffc" style="padding-top:15px; margin-top:10px; border-top: 1px black solid;">
                            <div class="checkbox-container">
                                <label for="ffc-f1" class="form-check-label checkbox-label bigger">
                                    <input type="checkbox" class="form-check-input bigger" id="ffc-f1" name="ffc-f1" value="f1">
                                    Filter 1
                                </label>
                            </div>
                            <div class="checkbox-container">
                                <label for="ffc-f2" class="form-check-label checkbox-label bigger">
                                    <input type="checkbox" class="form-check-input bigger" id="ffc-f2" name="ffc-f2" value="f2">
                                    Filter 2
                                </label>
                            </div>
                            <div class="checkbox-container">
                                <label for="ffc-f3" class="form-check-label checkbox-label bigger">
                                    <input type="checkbox" class="form-check-input bigger" id="ffc-f3" name="ffc-f3" value="f3">
                                    Filter 3
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 col-sm-12">
                        <div class="col-konten-head">
                            <button class="btn filter-sm-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#filter-sm" aria-controls="filter-sm">Filter</button>
                            <div class="offcanvas offcanvas-start" data-bs-scroll="true" tabindex="-1" id="filter-sm" aria-labelledby="filter-sm-label">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="filter-sm-label">Backdrop with scrolling</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <!-- FSV Judul Narasumber Event -->
                                    <div class="row fsv">
                                        <div class="checkbox-container">
                                            <label for="fsv-checkbox_judul" class="form-check-label checkbox-label bigger">
                                                <input type="checkbox" class="form-check-input bigger" id="fsv-checkbox_judul" name="fsv-checkbox_judul" value="judul">
                                                Judul
                                            </label>
                                        </div>
                                        <div class="checkbox-container">
                                            <label for="fsv-checkbox_narasumber" class="form-check-label checkbox-label bigger">
                                                <input type="checkbox" class="form-check-input bigger" id="fsv-checkbox_narasumber" name="checkbox_narasumber" value="narasumber">
                                                Narasumber
                                            </label>
                                        </div>
                                        <div class="checkbox-container">
                                            <label for="fsv-checkbox_event" class="form-check-label checkbox-label bigger">
                                                <input type="checkbox" class="bigger form-check-input" id="fsv-checkbox_event" name="checkbox_event" value="event">
                                                Event
                                            </label>
                                        </div>
                                        <div class="buttons">
                                            <button type="button" class="button" onclick="selectAll()">Select all</button>
                                            <button type="button" class="button" onclick="clearSelection()">Clear selection</button>
                                        </div>
                                    </div>

                                    <!-- FSV Filter -->
                                    <div class="row ffv" style="padding-top:15px; margin-top:10px;  border-top: 1px black solid;">
                                        <!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, laborum repudiandae sunt possimus neque laudantium est quo asperiores inventore aut!</p> -->
                                        <div class="checkbox-container">
                                            <label for="ffv-f1" class="form-check-label checkbox-label bigger">
                                                <input type="checkbox" class="form-check-input bigger" id="ffv-f1" name="ffv-f1" value="f1">
                                                Filter 1
                                            </label>
                                        </div>

                                        <div class="checkbox-container">
                                            <label for="ffv-f2" class="form-check-label checkbox-label bigger">
                                                <input type="checkbox" class="form-check-input bigger" id="ffv-f2" name="ffv-f2" value="f2">
                                                Filter 2
                                            </label>
                                        </div>

                                        <div class="checkbox-container">
                                            <label for="ffv-f3" class="form-check-label checkbox-label bigger">
                                                <input type="checkbox" class="form-check-input bigger" id="ffv-f3" name="ffv-f3" value="f3">
                                                Filter 3
                                            </label>
                                        </div>

                                    </div>
                                    <!-- <p>Try scrolling the rest of the page to see this option in action.</p>
										<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Deserunt quas, aut sit ab vel repellendus laborum minima, cupiditate optio explicabo vitae officia et, suscipit aliquid eius amet? Pariatur ex nemo eveniet? Deleniti assumenda odio illo repellendus? Impedit facere ducimus sunt magnam corporis debitis veniam, rem commodi ipsum, assumenda tempore quod dolor necessitatibus atque architecto quam enim cupiditate sed neque asperiores numquam? Nulla at commodi, itaque culpa voluptatem nostrum quae unde consequatur quos blanditiis assumenda facere temporibus quidem eaque placeat ipsam vitae molestiae earum. Quis sequi in suscipit aliquid earum, aliquam saepe minus perspiciatis consequatur fuga nesciunt sed nobis quaerat voluptatum, blanditiis dolorum voluptate modi obcaecati sint quod, placeat neque! Officiis maiores tempore ipsam fugit sit cupiditate corporis, eligendi voluptatibus temporibus quos rerum omnis reprehenderit vitae, accusantium animi, atque debitis. Ea et perferendis ratione necessitatibus porro consequatur optio eaque, ipsum nam, quidem ipsa harum! Consequuntur obcaecati aperiam aliquam excepturi neque molestias eius laboriosam nesciunt eaque impedit maxime accusantium corrupti, eligendi architecto voluptatibus earum ipsam, temporibus cupiditate! Incidunt id placeat ratione nulla! Accusantium maxime voluptates qui omnis sint! Sequi obcaecati a, hic commodi quis tenetur aspernatur? Sunt asperiores itaque laudantium tempora distinctio pariatur quam consequatur veniam saepe ex adipisci, voluptatum natus eligendi explicabo voluptate, a culpa cupiditate iure? Ipsum quos autem culpa necessitatibus dicta ad neque dignissimos aut libero perspiciatis blanditiis cumque minus officiis obcaecati, odio porro labore laboriosam, repellat animi ut. Quia obcaecati odit, suscipit atque blanditiis tenetur rerum cum, non necessitatibus voluptates molestias quis quae exercitationem vitae at aliquid maxime facilis itaque voluptatum consectetur optio maiores. Eligendi aperiam ullam nam officia ex suscipit hic vitae doloremque eum fuga sunt explicabo, magni debitis. Quia facilis labore dolores impedit dolore, nulla distinctio vero minus quo nostrum? Officia culpa, nemo fuga nihil nostrum amet delectus? Illo, explicabo. Iste dolorum commodi minima maxime omnis, facere ducimus. Praesentium dolores repellat omnis quis quidem perferendis perspiciatis quo corrupti a, deserunt natus facilis fugit quam sequi, nostrum reprehenderit accusamus impedit illum enim laboriosam? Dolor, reprehenderit maxime! Eveniet voluptate qui ad quos tempore impedit a necessitatibus numquam iusto minima, saepe alias, omnis non itaque sit mollitia similique? Nam, harum voluptates ea nihil consequuntur voluptatem iure adipisci, aspernatur vel aliquid eius nisi. Veritatis, ab ducimus! Sapiente debitis natus modi? Expedita delectus non maiores esse, officia assumenda dolores pariatur eos quia quod a, natus repellendus sequi asperiores veniam architecto quasi autem, quidem repudiandae explicabo. Eos, eaque iusto veniam animi ullam blanditiis voluptatem, maiores corporis voluptatibus minima obcaecati officia optio fugit, soluta quibusdam tempore id omnis quod architecto ex veritatis explicabo. Aut ipsum magni quis amet maxime illo omnis aspernatur. Delectus, accusamus quia? Quasi laboriosam porro iste amet culpa doloremque itaque fugit vero quod natus incidunt maiores fugiat distinctio tenetur corporis minima deserunt, quisquam, illo ex molestias, mollitia in placeat? Quas, nostrum accusamus odit nemo voluptates ut velit est voluptatum debitis aperiam vero praesentium qui tenetur sit illo consequuntur sint, soluta facere fuga esse perspiciatis? Maiores, ex ullam. Exercitationem adipisci, dignissimos ipsum necessitatibus quibusdam dolor aliquid aspernatur ex tenetur, labore inventore. Nisi aliquam accusantium eum voluptatum alias ipsam quis! Iusto reprehenderit dolore natus sapiente corporis, possimus ex, doloribus maxime labore est magnam quaerat illo expedita ut nam eaque. Necessitatibus, molestiae sunt? Consequuntur distinctio ratione ut iusto, fugit rem ipsam accusantium laborum itaque earum cum nisi praesentium nobis obcaecati? Veniam blanditiis consequuntur ducimus repellat sapiente excepturi facere sed numquam nobis odio voluptatum animi, itaque vel quis voluptate facilis cum doloremque. Quisquam, numquam hic quis sequi similique aliquid odio quaerat quibusdam voluptatem! Sit accusamus cumque, magnam quisquam iure sint dolor placeat numquam possimus! Perferendis qui odit aspernatur iusto? Tenetur totam aliquam quae accusantium hic minus pariatur odit velit, laudantium harum illo animi temporibus cum quam. Consequatur veniam voluptate fugit, fugiat at accusantium corrupti soluta dolores itaque dolore ea. Aspernatur, est assumenda vel laborum nihil provident rerum architecto, hic explicabo tempora eum adipisci, sit voluptatem dolor veritatis. Libero adipisci culpa explicabo facere eveniet quo officiis sapiente sequi sit, laudantium sunt? Inventore, deleniti? Tempore iste ab culpa voluptate amet architecto, ipsam quia corrupti quod maxime dolorem nulla nobis dolores rem eos, exercitationem, voluptatibus sit sint possimus. Vel magnam maiores officiis soluta aliquam molestias dolore provident placeat reiciendis, adipisci maxime ipsa dolores consectetur eius blanditiis expedita voluptates atque culpa sint neque error et rerum. Consequatur, tenetur iste, harum, reiciendis qui perspiciatis dolorem ex eveniet nisi provident neque. Hic doloremque ipsum voluptates debitis quod temporibus perspiciatis repudiandae quibusdam optio nesciunt, nemo necessitatibus voluptas quo explicabo facilis esse, placeat aspernatur et beatae non! Exercitationem qui optio atque neque amet nobis incidunt labore odio. Sequi rerum eius temporibus cum nesciunt autem possimus saepe animi sunt porro molestiae nam modi mollitia obcaecati tempore consequatur fugit dolorem illo, consequuntur quam doloremque, iure dolore. Explicabo mollitia ullam eos ea incidunt neque, voluptatibus ad provident sunt hic, saepe repellat suscipit nobis molestiae eligendi? Reprehenderit velit maxime ea eaque. Delectus facere, repudiandae sapiente autem dolore aperiam quod officia veritatis vitae fuga, perferendis voluptate repellat quae assumenda non perspiciatis itaque temporibus in explicabo nostrum laborum cupiditate quas fugit facilis? Enim, ipsam illo, est nobis dolor optio nulla dignissimos quisquam repellat velit omnis consectetur debitis perferendis aperiam eos. Provident deserunt neque totam porro? Necessitatibus accusantium qui tempora minus et blanditiis in officiis. Dolore cupiditate omnis a non, similique error at in perferendis culpa repudiandae quidem optio enim iste recusandae quas ab dolorem fugit placeat architecto! Mollitia animi omnis quam est. Quae, non? Molestiae quas quibusdam optio voluptatum laborum consequuntur modi quos, est omnis placeat id, sequi in. Neque libero esse deserunt id quod iure aut eveniet nihil totam ipsam, quos ut magni excepturi necessitatibus, ex soluta mollitia delectus non! Accusantium adipisci similique repellendus, asperiores quibusdam error dicta pariatur. Quo odio, iste nihil enim consectetur asperiores quaerat! Distinctio, saepe corporis? Odio molestias, tempore ex quisquam facere repudiandae veritatis necessitatibus aperiam modi blanditiis! Voluptatem rerum sequi cum quas esse, labore at totam ipsa nemo, dolorum assumenda perspiciatis? Quisquam ad impedit quas aliquam dolor. Dicta aspernatur quis possimus illum consequatur numquam magnam doloremque quaerat at omnis distinctio, iusto aut.</p> -->
                                </div>
                            </div>

                            <script>
                                const filter_sm = document.getElementById('filter-sm');

                                function hideFilterSM() {
                                    let openedCanvas = bootstrap.Offcanvas.getInstance(filter_sm);
                                    try {
                                        openedCanvas.hide();
                                    } catch {}
                                }

                                window.addEventListener('resize', hideFilterSM);
                            </script>
                            <?php
                            if (isset($_POST['keyword'])) {
                                $keyword = $_POST['keyword'];
                                echo '<h5>Related Search</h5>' . $keyword;
                            } else {
                                echo "No keyword provided.";
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

        <!-- <div class="_cards-container">
            <h1>Related Results</h1>

            <?php
            if (isset($_POST['keyword'])) {
                $keyword = $_POST['keyword'];
                echo "Keyword: " . $keyword;
            } else {
                echo "No keyword provided.";
            }
            ?>
            <div class="main">
                <ul class="_cards" id="card_result">
                    <!-- Card results will be dynamically added here -->
        </ul>
    </div>
    </div> 

    <!-- Add your additional HTML content and scripts as needed -->

    <script>
        // Extract the keyword from the POST data
        const keyword = "<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : ''; ?>";

        if (keyword) {
            // Fetch the related results using the getKeyword.php API
            fetch(`getKeyword.php?query=${encodeURIComponent(keyword)}`)
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
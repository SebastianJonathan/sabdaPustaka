<?php
// $_POST = array();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Sabda Pustaka</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="sabdastyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
	<?php
		include 'navbar.php';
	?>

    <form action="" method="POST" id="search" class="content">
        <div class="rekomendasi-container">
            <div class="col-md-6 InputContainer">
                <input placeholder="Search.." id="query" class="query form-control form-input" name="query" type="text" autocomplete="off">
                <button type="submit" class="search-button">Search</button>
            </div>
            <div id="rekomendasi">
                <ul id="rekomendasi-list"></ul>
            </div>
        </div>
        <div class="form-check text-center formgroup" style="display: flex;">
            <div class="checkbox-container">
                <label for="checkbox_judul" class="form-check-label checkbox-label bigger">
                    <input type="checkbox" class="form-check-input bigger" id="checkbox_judul" name="checkbox_judul" value="judul">
                    Judul
                </label>
            </div>
            <div class="checkbox-container">
                <label for="checkbox_narasumber" class="form-check-label checkbox-label bigger">
                    <input type="checkbox" class="form-check-input bigger" id="checkbox_narasumber" name="checkbox_narasumber" value="narasumber">
                    Narasumber
                </label>
            </div>
            <div class="checkbox-container">
                <label for="checkbox_event" class="form-check-label checkbox-label bigger">
                    <input type="checkbox" class="bigger form-check-input" id="checkbox_event" name="checkbox_event" value="event">
                    Event
                </label>
            </div>
            <div class="buttons">
                <button type="button" class="button" onclick="selectAll()">Select all</button>
                <button type="button" class="button" onclick="clearSelection()">Clear selection</button>
            </div>
        </div>
    </form>

    <?php
        if (isset($_POST['query'])) {
            $query = $_POST['query'];
						// echo $query."<br>";
            // Check the selected checkboxes
            $checkbox_judul = isset($_POST['checkbox_judul']);
            $checkbox_narasumber = isset($_POST['checkbox_narasumber']);
            $checkbox_event = isset($_POST['checkbox_event']);

            // Build the fields array based on the selected checkboxes
            $fields = [];
            if ($checkbox_judul) {
                $fields[] = 'judul_completion.input';
            }
            if ($checkbox_narasumber) {
                $fields[] = 'narasumber_completion.input';
            }
            if ($checkbox_event) {
                $fields[] = 'event_completion.input';
            }

            // Prepare the fields for the autocomplete query
            $fields_query = implode(',', $fields);

            // Display the selected checkboxes
            // if ($checkbox_judul) {
            //     echo "Judul ";
            // }
            // if ($checkbox_narasumber) {
            //     echo "Narasumber ";
            // }
            // if ($checkbox_event) {
            //     echo "Event ";
            // }
            // echo "<br>";
            include 'search_result.php';
        }
    ?>

<script>
        if (sessionStorage.getItem('checkboxJudul') === 'true') {
            document.getElementById('checkbox_judul').checked = true;
        }
        if (sessionStorage.getItem('checkboxEvent') === 'true') {
            document.getElementById('checkbox_event').checked = true;
        }
        if (sessionStorage.getItem('checkboxNarasumber') === 'true') {
            document.getElementById('checkbox_narasumber').checked = true;
        }
        if(!sessionStorage.getItem('first')){
            selectAll();
        }
        updateFields();

        function selectAll() {
            document.getElementById('checkbox_judul').checked = true;
            document.getElementById('checkbox_narasumber').checked = true;
            document.getElementById('checkbox_event').checked = true;
            updateFields();
        }

        function clearSelection() {
            document.getElementById('checkbox_judul').checked = false;
            document.getElementById('checkbox_narasumber').checked = false;
            document.getElementById('checkbox_event').checked = false;
            updateFields();
        }

        function updateFields() {
            const checkbox_judul = document.getElementById('checkbox_judul');
            const checkbox_narasumber = document.getElementById('checkbox_narasumber');
            const checkbox_event = document.getElementById('checkbox_event');

            let fields = [];

            if (checkbox_judul.checked) {
                fields.push('judul_completion.input');
            }
            if (checkbox_narasumber.checked) {
                fields.push('narasumber_completion.input');
            }
            if (checkbox_event.checked) {
                fields.push('event_completion.input');
            }

            const queryInput = document.getElementById('query');
            queryInput.dataset.fields = fields.join(',');
            fetchRecommendations();
        }

        function fetchRecommendations() {
            const query = document.getElementById('query').value;
            const fields = document.getElementById('query').dataset.fields;

            fetch(`autocomplete.php?query=${query}&fields=${fields}`)
                .then(response => response.json())
                .then(data => {
                    // console.log(data.rekomendasi);
                    tampilkanRekomendasi(data.rekomendasi);
                    
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                });
        }
        function addSection(item, className,rekomendasiList){
            const li = document.createElement('li');
            li.className = className;
            li.textContent = item;
            li.addEventListener('click', function() {
                document.getElementById('query').value = item
                hideRekomendasi();
            });
            rekomendasiList.appendChild(li);
        }
        function tampilkanRekomendasi(rekomendasi) {
            const rekomendasiList = document.getElementById('rekomendasi-list');
            rekomendasiList.innerHTML = '';

            if(rekomendasi.judul.length > 0 ){
                addSection("JUDUL",'section',rekomendasiList)
            }
            rekomendasi.judul.forEach(function(item) {
                addSection(item,'list-hover',rekomendasiList)
            });
            if(rekomendasi.narasumber.length > 0){
                addSection("NARASUMBER",'section',rekomendasiList)
            }
            rekomendasi.narasumber.forEach(function(item) {
                addSection(item,'list-hover',rekomendasiList)
            });
            if(rekomendasi.event.length > 0){
                addSection("EVENT",'section',rekomendasiList)
            }
            rekomendasi.event.forEach(function(item) {
                addSection(item,'list-hover',rekomendasiList)
            });
            const rekomendasiDiv = document.getElementById('rekomendasi');
            rekomendasiDiv.style.display = 'block';
        }

        function hideRekomendasi() {
            const rekomendasiDiv = document.getElementById('rekomendasi');
            rekomendasiDiv.style.display = 'none';
        }

        document.getElementById('search').addEventListener('submit', function() {
            const checkboxJudul = document.getElementById("checkbox_judul");
            const checkboxEvent = document.getElementById("checkbox_event");
            const checkboxNarasumber = document.getElementById("checkbox_narasumber");

            sessionStorage.setItem("checkboxJudul", checkboxJudul.checked);
            sessionStorage.setItem("checkboxEvent", checkboxEvent.checked);
            sessionStorage.setItem("checkboxNarasumber", checkboxNarasumber.checked);
            sessionStorage.setItem("first",true)
        });
        function updateRekomendasiPosition() {
            const searchInput = document.getElementById('query');
            const rekomendasiDiv = document.getElementById('rekomendasi');
            // const rekomendasiContainer = document.getElementById('rekomendasi-container');
						// if (rekomendasiContainer === null) {
						// 	console.log("rekomendasi container is null");
						// }


            const inputRect = searchInput.getBoundingClientRect();
            const inputTop = inputRect.top + window.scrollY;
            const inputHeight = inputRect.height;
            const inputWidth = inputRect.width;

            rekomendasiDiv.style.width = inputWidth + 'px';
            rekomendasiDiv.style.left = inputRect.left + 'px';
            // rekomendasiContainer.style.top = (inputTop + inputHeight) + 'px';
        }
        document.addEventListener('click', function(event) {
            const target = event.target;
            const queryInput = document.getElementById('query');
            const rekomendasiDiv = document.getElementById('rekomendasi');
            // window.alert("WWW");

            if (target !== queryInput && !rekomendasiDiv.contains(target)) {
                hideRekomendasi();
            }
            if (target === queryInput){
                fetchRecommendations();
            }
        });

        window.addEventListener('resize', updateRekomendasiPosition);
        window.addEventListener('DOMContentLoaded', updateRekomendasiPosition);

        document.getElementById('query').addEventListener('input', fetchRecommendations);
    </script>




    <p>
      <!-- Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates magnam molestiae, temporibus repudiandae voluptatibus delectus atque recusandae obcaecati. Quaerat excepturi eum similique culpa, voluptatibus nulla voluptate ea accusamus rem at, quod quibusdam accusantium sed? Ut pariatur, tenetur, quasi consectetur aperiam perferendis id sed voluptatem nesciunt modi maxime officia atque vero consequatur quaerat fugit incidunt tempore repellat nostrum? Architecto ab saepe tempore. Tempora, facere fugiat. Non aliquid perspiciatis sint similique commodi tenetur quos earum, adipisci minima obcaecati officiis placeat ipsam esse quis minus cupiditate quam repudiandae aperiam accusamus numquam deleniti enim officia! Sunt aspernatur nam ipsa molestias earum et magnam sapiente inventore. Dignissimos blanditiis esse velit quod minus minima. Modi, sed officiis perspiciatis eaque corrupti repellendus architecto quasi velit doloribus cupiditate quia, nesciunt natus in ab repellat dolor autem cumque veritatis culpa! Incidunt, quod numquam repellat modi fugit tempora? Labore incidunt minus vero atque amet totam. Modi sapiente enim reiciendis assumenda fugit ea, magnam totam harum, eum iure reprehenderit odio saepe error. Doloremque officiis sapiente animi temporibus aspernatur pariatur tenetur quia natus commodi veniam nostrum explicabo voluptates velit saepe illum maiores fuga consectetur recusandae, quibusdam et. Similique, ipsum at est reprehenderit aliquid porro, suscipit necessitatibus incidunt beatae voluptatibus iure, quisquam quo hic quidem nam a officiis voluptatem facere expedita! Perspiciatis dolore sed excepturi totam corrupti iusto enim, voluptates voluptas quos porro quo deleniti. Doloribus, nobis veritatis. Eaque praesentium itaque assumenda ut veniam sit deserunt minima vero quibusdam excepturi dolore laudantium voluptatibus dicta neque dolores consequatur quidem quas rem doloribus maxime, repudiandae similique inventore accusamus. Reprehenderit officiis, ad incidunt sint vero labore ullam necessitatibus error atque, veritatis nam reiciendis possimus nisi hic quod itaque quae obcaecati at quisquam accusamus aliquid minus! In quam porro facere aut, illo enim beatae provident nesciunt reiciendis a, earum, tempore voluptas! Est, laborum tempore maxime natus ducimus consequuntur voluptates beatae, ipsam nihil et asperiores iste, possimus quisquam eum animi perferendis. Non, et asperiores omnis consequatur voluptatibus enim explicabo dolores ducimus in odio neque maiores reiciendis iste iure officia, ipsa nesciunt. Molestiae sapiente enim libero quos mollitia repellat tenetur! Itaque eligendi ratione molestiae, impedit, enim corrupti nobis eveniet iste quae explicabo quidem aut voluptatibus dolores quaerat, et dicta voluptatem assumenda excepturi a. Obcaecati eligendi ipsum quo eum corrupti, voluptate, facere blanditiis temporibus, ratione non sint odit reiciendis! Rerum unde soluta odit iusto debitis tenetur, non illum! Perferendis vitae maxime iusto nihil, obcaecati aperiam totam facere cumque, quod, porro error ex? Voluptates, sed! Placeat dolore voluptate rerum sapiente officiis tempore, repellat ratione praesentium atque asperiores molestiae molestias magnam nostrum voluptates laboriosam quo laborum. Consequuntur harum non quos nulla culpa assumenda! Autem aliquid dolorem nostrum! Nihil reprehenderit tenetur culpa? Odit eaque delectus, esse distinctio quisquam, labore modi nihil deserunt quod atque facilis eligendi provident molestias rem architecto magnam quam expedita aliquam quas sit? Ex, quos culpa. Iure, optio! Quod autem nulla a ipsum? Fugit iste quisquam, voluptates nobis sunt corporis possimus magni facilis officiis tempora ipsam, quae dolores rerum. Voluptas tempora nihil quod odio eius aut repellendus at consequatur fuga repudiandae sed modi in debitis ex incidunt mollitia, minima nobis, tenetur, sapiente nesciunt dignissimos illo iste alias iusto. Iure suscipit pariatur dignissimos laboriosam voluptate sapiente, eius odio molestiae quisquam quidem totam in accusamus eum hic officiis repellat odit nulla ducimus ad. Ipsum quos temporibus excepturi? Voluptatum eveniet ea culpa repudiandae ut ratione illo, officiis blanditiis eius hic ullam ad modi debitis quos quis eum consectetur possimus harum voluptate cupiditate dignissimos consequuntur. Vero nesciunt aliquid deserunt enim nemo reprehenderit consequatur quibusdam sapiente? Sapiente quos sunt animi qui, possimus ipsam laboriosam commodi odit nesciunt quibusdam tempora quis exercitationem provident incidunt consequatur earum accusamus minima quasi nemo sequi ipsum ad mollitia distinctio aperiam. Quisquam fugiat, illum est recusandae praesentium mollitia similique debitis minima quod blanditiis vel eius et ab deleniti eligendi impedit. Esse, labore alias. Consectetur ipsum earum molestias consequuntur totam voluptatibus nisi sit itaque perferendis repellendus illum et at possimus voluptate, quos placeat, cum nulla aliquam omnis? Natus eius officia laudantium, porro expedita temporibus magnam adipisci dicta tempora. Corporis, tempora doloremque repellendus in enim exercitationem rerum suscipit autem nisi provident vitae quasi distinctio neque reprehenderit alias beatae sapiente? Impedit, magnam quo. Tempora odio ratione repellat possimus modi laudantium quo? Quis dolores veritatis facere commodi ratione iusto minima, non odio vel beatae optio, iure voluptatum quo mollitia quibusdam fuga, neque voluptates. Fugiat pariatur in dolore a ipsum dolor illum soluta quibusdam, quos recusandae expedita debitis fugit sed, voluptatum unde, dolorum suscipit veniam minima laborum eum velit dicta tenetur! Illo incidunt cum esse nobis. Nam officia error ex temporibus quasi a repellat commodi, hic quidem animi consequuntur nisi quod incidunt nobis earum vel recusandae deserunt. Voluptatem, aperiam omnis ex officia nam hic deleniti aut rerum? Illum esse et obcaecati, suscipit vero voluptate nisi asperiores optio deserunt unde molestias dignissimos dolor iste error veritatis necessitatibus labore! Architecto consequuntur itaque illum ex accusamus nemo sapiente totam iusto! Blanditiis dolorum neque iusto? Obcaecati amet non porro similique ex quibusdam reiciendis illum totam ipsam, earum rerum suscipit perferendis iure. Aliquid voluptate amet beatae esse cumque quibusdam, aut nemo sed illum qui quo molestias magni veritatis sequi rem, omnis minima ad, id facere! Provident numquam et, itaque quos molestiae amet nam quod quasi ad commodi corrupti eos, molestias distinctio? Rem, delectus. Dolore, nesciunt. Consectetur saepe sit molestias accusamus autem qui numquam repudiandae et enim illo, quisquam expedita amet aperiam rem quis voluptatibus explicabo eaque voluptate eveniet reprehenderit? Praesentium dicta facilis quod laboriosam commodi facere quos aspernatur laborum non esse cum voluptate ipsum tempora ratione, est illo fugit sunt perferendis dolor impedit exercitationem pariatur repellendus! Voluptate, tempora ab quibusdam aut, eveniet eos ullam quisquam, placeat corrupti minus eius! Minus dolorem sunt eligendi consectetur rem doloribus velit repellat quis praesentium aperiam. Vero esse praesentium illum sapiente ea unde atque nihil nobis veritatis quisquam! Qui praesentium labore illo libero enim suscipit vero nulla numquam eaque fugiat ut, dolorum natus corrupti dolorem sunt molestiae! Quibusdam, voluptas et! Consequatur suscipit modi eveniet corporis assumenda fuga cum voluptate, perspiciatis delectus iste tempore omnis, praesentium officiis! -->
    </p>

</body>

<?php
include 'coba3.php';
?>

</html>
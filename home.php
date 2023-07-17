<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		include'header.php'
	?>
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

	<?php
		include 'footer.php';
	?>

</body>



</html>
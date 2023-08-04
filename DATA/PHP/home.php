<!DOCTYPE html>
<html lang="en">

<head>
	<?php include 'header.php' ?>
	<style>
	._cards_item2 {
		margin-bottom: 10px; /* Adjust the spacing between cards */
		display: block; /* Display each card as a block to make them vertical */
	}
	.container-list {
		display: flex;
		flex-direction: column;
		align-items: stretch;
	}	
	</style>
</head>

<body>
	<?php include 'navbar.php'; ?>

	<div class="container-fluid">
		<!-- Row Search Bar -->
		<div class="row">
			<form action="" id="search" class="content sect-search">
				<div class="rekomendasi-container">
					<div class="col-md-6 InputContainer" style="background-color: #1e0049; ">
						<input placeholder="Search.." id="query" class="query form-control form-input" name="query" type="text" autocomplete="off">
						<button type="button" class="search-button" onclick="goSearch()" style="background-color: #1e0049; color: white;">Search</button>
					</div>
					<div id="rekomendasi">
						<ul id="rekomendasi-list"></ul>
					</div>
			</form>
		</div>


		<!-- Konten Website -->
		<div class="row" id="kontenS">
			<!--COL Search & Filter  -->
			<div class="col-lg-2 col-md-3 col-filter" id="col-filter-md" style="padding-right: 5px; padding-left:10px; min-width:210px;">
				<div class="card sect-cont-sidebar">
					<!-- <img src="..." class="card-img-top" alt="..."> -->
					<div class="card-body card-sidebar">
						<!-- <h5 class="card-title">Search</h5> -->
						<!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->

						<div class="row">
							<h5 style="margin-bottom: 10px; font-weight:bold; color:gold;">Search By</h5>
						</div>
						<!-- Search By -->
						<div class="row fsc">
							<div class="checkbox-container">
								<label for="checkbox_judul" class="form-check-label checkbox-label bigger">
									<input type="checkbox" class="form-check-input bigger cbstyle" id="checkbox_judul" name="checkbox_judul" value="judul" onchange="updateSessionCheckboxFirst()">
									Judul
								</label>
							</div>
							<div class="checkbox-container">
								<label for="checkbox_narasumber" class="form-check-label checkbox-label bigger">
									<input type="checkbox" class="form-check-input bigger cbstyle" id="checkbox_narasumber" name="checkbox_narasumber" value="narasumber" onchange="updateSessionCheckboxFirst()">
									Narasumber
								</label>
							</div>
							<div class="checkbox-container">
								<label for="checkbox_event" class="form-check-label checkbox-label bigger">
									<input type="checkbox" class="bigger form-check-input" id="checkbox_event" name="checkbox_event" value="event" onchange="updateSessionCheckboxFirst()">
									Event
								</label>
							</div>
							<div class="checkbox-container">
								<label for="checkbox_related" class="form-check-label checkbox-label bigger">
									<input type="checkbox" class="bigger form-check-input" id="checkbox_related" name="checkbox_related" value="related" onchange="updateSessionCheckboxFirst()">
									Related
								</label>
							</div>
							<div class="buttons">
								<button type="button" class="button fs-btn" onclick="selectAll()">Select all</button>
								<button type="button" class="button fs-btn" onclick="clearSelection()">Clear selection</button>
							</div>
						</div>


						<div class="row _ffv" style="/*padding-top:15px; margin-top:10px;  border-top: 1px black solid;*/" id="ffc-filter">
						</div>
					</div>
				</div>
			</div><!-- COL Search & Filter  -->

			<!-- COL Card -->
			<div class="col">
				<div>
					<!-- Off-Canvas Sidebar Button -->
					<!-- <button class="btn filter-sm-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#filter-sm" aria-controls="filter-sm">Filter</button> -->
					<!-- Off-Canvas Sidebar-->
					<div class="offcanvas offcanvas-start sect-cont-sidebar" data-bs-scroll="true" tabindex="-1" id="filter-sm" aria-labelledby="filter-sm-label" style="max-width:300px">
						<div class="offcanvas-header" style="align-items: end; padding-bottom: 0px;">
							<div style="height: 40px;"></div>
							<!-- <h5 class="offcanvas-title" id="filter-sm-label">Search By</h5> -->
						</div>
						<div class="offcanvas-body offcvb">
							<!-- FSV Off-Canvas Search By -->
							<div class="row fsv">
								<div class="row">
									<div class="col">
										<h5 style="margin-bottom: 10px; font-weight:bold; color:gold;">Search By</h5>
									</div>
									<div class="col" style="display:flex; justify-content:right;">
										<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="color: gold;"></button>
									</div>


								</div>

								<div class="checkbox-container">
									<label for="fsv-checkbox_judul" class="form-check-label checkbox-label bigger">
										<input type="checkbox" class="form-check-input bigger" id="fsv-checkbox_judul" name="fsv-checkbox_judul" value="judul" onchange="onChangeResponsiveJudul()">
										Judul
									</label>
								</div>
								<div class="checkbox-container">
									<label for="fsv-checkbox_narasumber" class="form-check-label checkbox-label bigger">
										<input type="checkbox" class="form-check-input bigger" id="fsv-checkbox_narasumber" name="checkbox_narasumber" value="narasumber" onchange="onChangeResponsiveNarasumber()">
										Narasumber
									</label>
								</div>
								<div class="checkbox-container">
									<label for="fsv-checkbox_event" class="form-check-label checkbox-label bigger">
										<input type="checkbox" class="bigger form-check-input" id="fsv-checkbox_event" name="checkbox_event" value="event" onchange="onChangeResponsiveEvent()">
										Event
									</label>
								</div>
								<div class="checkbox-container">
									<label for="fsv-checkbox_related" class="form-check-label checkbox-label bigger">
										<input type="checkbox" class="bigger form-check-input" id="fsv-checkbox_related" name="checkbox_related" value="related" onchange="onChangeResponsiveRelated()">
										Related
									</label>
								</div>
								<div class="buttons">
									<button type="button" class="button fs-btn" onclick="selectAll()">Select all</button>
									<button type="button" class="button fs-btn" onclick="clearSelection()">Clear selection</button>
								</div>
							</div>

							<div class="row _ffv" style="/*padding-top:15px; margin-top:10px;  border-top: 1px black solid;*/" id="ffv-filter">
							</div>
						</div>
					</div>
					<script>
						const filter_sm = document.getElementById('filter-sm');

						function hideFilterSM() {
							let openedCanvas = bootstrap.Offcanvas.getInstance(filter_sm);
							try {
								openedCanvas.hide();
								// document.activeElement.blur();
							} catch {}
						}
						window.addEventListener('resize', hideFilterSM);
					</script>
				</div>
				<!-- Search Result Cards-->
				<div class="row">
					<?php include 'search_result.php'; ?>
	
				</div>
				<div id="show" class="row">

				</div>

				<div id="contEventNarsum" class="row">
					<div class="row container-event" id="contEvent">
						<div class="row event-name">
							<h2 class="text-center" style="margin-bottom:20px;">Semua Event</h2>
						</div>
						<div class="row">
							<ul id="eventList"></ul>
						</div>
						<div class="row">
							<button id="ex-event-btn" type="button" onclick="expandEvent()">show more</button>
						</div>
					</div>
					<div class="row container-event" id="contNarsum">
						<div class="row event-name">
							<h2 class="text-center" style="margin-bottom:20px;">Semua Narasumber</h2>
						</div>
						<div class="row">
							<ul id="narasumberList"></ul>
						</div>
						<div class="row">
							<button id="ex-naras-btn" onclick="expandNarasumber()">show more</button>
						</div>

					</div>
				</div>
			</div>

		</div><!-- COL Card -->
		<!-- Spacer -->
		<div class="row" style="height: 20px;"></div>
	</div><!-- row konten -->
	</div> <!-- Container -->
	<a class="floating-btn" id="down-button" onclick="scrollToBottom()">🢃</a>




	<?php
	function query($url, $method, $param)
	{
		$header = array(
			'Content-Type: application/json'
		);
		$options = array(
			'http' => array(
				'header' => $header,
				'method' => $method,
				'content' => $param
			)
		);
		$context = stream_context_create($options);
		$response = file_get_contents($url, false, $context);
		$result = json_decode($response, true);

		return $result;
	}

	function extractUniqueSpeakers($hits)
	{
		$uniqueNames = [];

		foreach ($hits as $hit) {
			$source = $hit['_source'];
			$names = "";
			$name = $source['narasumber'];
			$name = str_replace(",S.","|S.",$name);
			$name = str_replace(", S.","| S.",$name);
			$name = str_replace(",M.","|M.",$name);
			$name = str_replace(", M.","| M.",$name);
			$name = str_replace(",Ph.","|Ph.",$name);
			$name = str_replace(", Ph.","| Ph.",$name);
			$names = $name;
			$names = explode(", ", $names);

			foreach ($names as $participantName) {
				$cleanedName = trim($participantName);
				$cleanedName = str_replace("|",",",$cleanedName);
				if (!in_array($cleanedName, $uniqueNames)) {
					$uniqueNames[] = $cleanedName;
				}
			}
		}

		return $uniqueNames;
	}

	// Set the Elasticsearch index name and endpoint URL
	$index = $indexName;
	$url = $configElasticPath . $index . '/_search';

	// Query to retrieve all documents
	$params = [
		'size' => 1000, // Adjust the size to match the maximum number of documents to retrieve
		'query' => [
			'match_all' => new \stdClass() // Empty query to retrieve all documents
		],
		'_source' => ['narasumber', 'event'] // Include only 'narasumber' and 'event' fields in the response
	];

	$query = json_encode($params);
	$response = query($url, 'POST', $query);

	// Extract unique 'narasumber' and 'event' values
	$hits = $response['hits']['hits'];
	$narasumbers = extractUniqueSpeakers($hits);
	$events = [];

	foreach ($hits as $hit) {
		$source = $hit['_source'];

		if (isset($source['event']) && !in_array($source['event'], $events)) {
			$events[] = $source['event'];
		}
	}
	sort($events);
	sort($narasumbers);
	?>


	<?php include 'footer.php'; ?>

	<script>
		if (sessionStorage.getItem('checkboxJudul') === 'true') {
			document.getElementById('checkbox_judul').checked = true;
			document.getElementById('fsv-checkbox_judul').checked = true;
		}
		if (sessionStorage.getItem('checkboxEvent') === 'true') {
			document.getElementById('checkbox_event').checked = true;
			document.getElementById('fsv-checkbox_event').checked = true;
		}
		if (sessionStorage.getItem('checkboxNarasumber') === 'true') {
			document.getElementById('checkbox_narasumber').checked = true;
			document.getElementById('fsv-checkbox_narasumber').checked = true;
		}
		if (sessionStorage.getItem('checkboxRelated') === 'true') {
			document.getElementById('checkbox_related').checked = true;
			document.getElementById('fsv-checkbox_related').checked = true;
		}
		function syncCheckbox(id, isChecked) {
			var split_id = id.split("-");
			var clan = split_id[0];
			var true_id = split_id[1];

			if (clan === "ffv") {
				var ffc_id = "ffc-" + true_id;
				const ffc_cb = document.getElementById(ffc_id);
				ffc_cb.checked = isChecked;
			} else {
				// clan === ffc
				var ffv_id = "ffv-" + true_id;
				const ffv_cb = document.getElementById(ffv_id);
				ffv_cb.checked = isChecked;
			}
		}

		function selectAll() {
			document.getElementById('checkbox_judul').checked = true;
			document.getElementById('fsv-checkbox_judul').checked = true;
			document.getElementById('checkbox_narasumber').checked = true;
			document.getElementById('checkbox_related').checked = true;
			document.getElementById('fsv-checkbox_event').checked = true;
			document.getElementById('checkbox_event').checked = true;
			document.getElementById('fsv-checkbox_narasumber').checked = true;
			document.getElementById('fsv-checkbox_related').checked = true;
			updateSessionCheckboxFirst();
			updateFields();
		}
		function clearSelection() {
			document.getElementById('checkbox_judul').checked = false;
			document.getElementById('fsv-checkbox_judul').checked = false;
			document.getElementById('checkbox_narasumber').checked = false;
			document.getElementById('checkbox_related').checked = false;
			document.getElementById('fsv-checkbox_event').checked = false;
			document.getElementById('checkbox_event').checked = false;
			document.getElementById('fsv-checkbox_narasumber').checked = false;
			document.getElementById('fsv-checkbox_related').checked = false;
			updateSessionCheckboxFirst();
			updateFields();
		}
		function onChangeResponsiveJudul(){
			document.getElementById('checkbox_judul').checked = false;
			updateSessionCheckboxFirst();
		}
		function onChangeResponsiveEvent(){
			document.getElementById('checkbox_event').checked = false;
			updateSessionCheckboxFirst();
		}
		function onChangeResponsiveNarasumber(){
			document.getElementById('checkbox_narasumber').checked = false;
			updateSessionCheckboxFirst();
		}
		function onChangeResponsiveRelated(){
			document.getElementById('checkbox_related').checked = false;
			updateSessionCheckboxFirst();
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

		function buttonVisibility() {
			const buttonScrollDown = document.getElementById('down-button');
			const windowHeight = window.innerHeight;

			if (window.scrollY + windowHeight < document.body.scrollHeight) {
				buttonScrollDown.style.display = 'block';
			} else {
				buttonScrollDown.style.display = 'none';
			}
		}
		window.addEventListener('scroll', buttonVisibility);

		$('.fsv input[type=checkbox]').change(function() {
			var id = this.id;
			var is_checked = this.checked;
			var fsc_id = id.split("-")[1];
			// console.log(id + " -- " + fsc_id);
			// console.log(this.checked);
			$('#' + fsc_id).prop('checked', is_checked);
			updateFields();
		});

		$('.fsc input[type=checkbox]').change(function() {
			var id = this.id;
			var is_checked = this.checked;
			var fsv_id = "fsv-" + id;
			// console.log(id + " -- " + fsv_id);
			// console.log(this.checked);
			$('#' + fsv_id).prop('checked', is_checked);
			updateFields();
		});

		function updateFields() {
			let fields = [];

			if (sessionStorage.getItem("checkboxJudul") == "true") {
                fields.push('judul_completion.input');
            }
            if (sessionStorage.getItem("checkboxNarasumber") == "true") {
                fields.push('narasumber_completion.input');
            }
            if (sessionStorage.getItem("checkboxEvent") == "true") {
                fields.push('event_completion.input');
            }
            if (sessionStorage.getItem("checkboxRelated") == "true") {
                fields.push('deskripsi_pendek');
				fields.push('ringkasan');
				fields.push('kata_kunci');
            }
			

			const queryInput = document.getElementById('query');
			queryInput.dataset.fields = fields.join(',');
			fetchRecommendations2();
		}

		function updateOnChecked() {
			const checkbox_judul = document.getElementById('checkbox_judul');
			const checkbox_narasumber = document.getElementById('checkbox_narasumber');
			const checkbox_event = document.getElementById('checkbox_event');
			const checkbox_related = document.getElementById('checkbox_related');
			const checkbox_judul2 = document.getElementById('fsv-checkbox_judul');
			const checkbox_narasumber2 = document.getElementById('fsv-checkbox_narasumber');
			const checkbox_event2 = document.getElementById('fsv-checkbox_event');
			const checkbox_related2 = document.getElementById('fsv-checkbox_related');
			checkbox_judul.checked = checkbox_judul2.checked;
			checkbox_narasumber.checked = checkbox_narasumber2.checked;
			checkbox_event.checked = checkbox_event2.checked;
			checkbox_related.checked = checkbox_related2.checked;
			updateFields();
		}
		function getSearchByState(){
			let searchBy = "";
			if(sessionStorage.getItem("checkboxJudul") == "true"){
				searchBy += "t";
			}else{
				searchBy += "f";
			}
			if(sessionStorage.getItem("checkboxEvent") == "true"){
				searchBy += "t";
			}else{
				searchBy += "f";
			}
			if(sessionStorage.getItem("checkboxNarasumber") == "true"){
				searchBy += "t";
			}else{
				searchBy += "f";
			}
			if(sessionStorage.getItem("checkboxRelated") == "true"){
				searchBy += "t";
			}else{
				searchBy += "f";
			}
			return searchBy;
		}
		function goSearch() {
			let searchBy = getSearchByState();
			const fullURL = window.location.href;
			const segments = fullURL.split('/');
			if(segments[segments.length - 3] == "search" && document.getElementById('query').value == "" && sessionStorage.getItem("query") == null){
				window.location.href = configPath + "DATA/PHP/home.php/search/" + segments[segments.length - 2] + "/" + searchBy;
				sessionStorage.setItem("query",segments[segments.length - 2]);
			}else{
				window.location.href = configPath + "DATA/PHP/home.php/search/" + document.getElementById('query').value + "/" + searchBy;
				sessionStorage.setItem("query",document.getElementById('query').value);
			}
		}
		async function fetchRecommendations() {
			const query = document.getElementById('query').value;
			const fields = document.getElementById('query').dataset.fields;

			try {
				const response = await fetch(configPath + `DATA/API/autocomplete.php?query=${query}&fields=${fields}`);
				const data = await response.json();
				// console.log(data.rekomendasi);
				console.log(data);
				tampilkanRekomendasi(data.rekomendasi);
			} catch (error) {
				console.error('Terjadi kesalahan:', error);
			}
		}

		async function fetchRecommendations2() {
			const query = document.getElementById('query').value;
			const fields = document.getElementById('query').dataset.fields;
			try {
				const response = await fetch(configPath + `DATA/API/autocomplete.php?query=${query}&fields=${fields}`);
				const data = await response.json();
				// console.log(data.rekomendasi);
				tampilkanRekomendasi(data.rekomendasi);
			} catch (error) {
				console.error('Terjadi kesalahan:', error);
			}
			hideRekomendasi();
		}

		function addSection(item, className, rekomendasiList) {
			const li = document.createElement('li');
			li.className = className;
			li.textContent = item;
			li.addEventListener('click', function() {
				document.getElementById('query').value = item
				hideRekomendasi();
				updateSessionCheckbox();
				goSearch();
			});
			rekomendasiList.appendChild(li);
		}

		function tampilkanRekomendasi(rekomendasi) {
			const rekomendasiList = document.getElementById('rekomendasi-list');
			rekomendasiList.innerHTML = '';

			if (rekomendasi.judul.length > 0) {
				addSection("JUDUL", 'section', rekomendasiList)
			}
			rekomendasi.judul.forEach(function(item) {
				addSection(item, 'list-hover', rekomendasiList)
			});
			if (rekomendasi.narasumber.length > 0) {
				addSection("NARASUMBER", 'section', rekomendasiList)
			}
			rekomendasi.narasumber.forEach(function(item) {
				addSection(item, 'list-hover', rekomendasiList)
			});
			if (rekomendasi.event.length > 0) {
				addSection("EVENT", 'section', rekomendasiList)
			}
			rekomendasi.event.forEach(function(item) {
				addSection(item, 'list-hover', rekomendasiList)
			});
			if (rekomendasi.related.length > 0) {
				addSection("RELATED", 'section', rekomendasiList)
			}
			rekomendasi.related.forEach(function(item) {
				addSection(item, 'list-hover', rekomendasiList)
			});

			const rekomendasiDiv = document.getElementById('rekomendasi');
			rekomendasiDiv.style.display = 'block';
		}

		function hideRekomendasi() {
			const rekomendasiDiv = document.getElementById('rekomendasi');
			rekomendasiDiv.style.display = 'none';
		}

		function updateSessionCheckbox() {
			const checkboxJudul = document.getElementById("checkbox_judul");
			const checkboxEvent = document.getElementById("checkbox_event");
			const checkboxNarasumber = document.getElementById("checkbox_narasumber");
			const checkboxRelated = document.getElementById("checkbox_related");

			sessionStorage.setItem("checkboxJudul", checkboxJudul.checked);
			sessionStorage.setItem("checkboxEvent", checkboxEvent.checked);
			sessionStorage.setItem("checkboxNarasumber", checkboxNarasumber.checked);
			sessionStorage.setItem("checkboxRelated", checkboxRelated.checked);
			updateFields();
			const fullURL = window.location.href;
			const segments = fullURL.split('/');
			if(sessionStorage.getItem("changeSearchBy") == "1" && segments[segments.length - 3] == "search"){
				sessionStorage.setItem("changeSearchBy", "0");
				goSearch();
			}
		}

		document.getElementById("search").addEventListener("submit", function(event) {
			event.preventDefault();
			goSearch();
			hideRekomendasi();
		});

		function updateRekomendasiPosition() {
			const searchInput = document.getElementById('query');
			const rekomendasiDiv = document.getElementById('rekomendasi');


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
			if (target === queryInput) {
				fetchRecommendations();
			}
		});

		window.addEventListener('resize', updateRekomendasiPosition);
		window.addEventListener('DOMContentLoaded', updateRekomendasiPosition);

		document.getElementById('query').addEventListener('input', fetchRecommendations);



		/*
				FUNCTION GETALLLLIST.PHP
		*/

		// Events data from PHP
		const events = <?php echo json_encode($events); ?>;
		const narasumbers = <?php echo json_encode($narasumbers); ?>;

		// Function to generate HTML elements for events and narasumbers
		function generateEventLinks() {
			const eventListContainer = document.getElementById('eventList');
			events.forEach((event) => {
				const eventUrl = configPath + 'DATA/PHP/related_results.php?event=' + encodeURIComponent(event);
				const eventDiv = document.createElement('li');
				eventDiv.className = 'event-li';
				// eventDiv.style.width = "150px";
				eventDiv.innerHTML = `<a href="${eventUrl}">${event}</a>`;
				eventListContainer.appendChild(eventDiv);
			});
		}

		function generateNarasumberLinks() {
			const narasumberListContainer = document.getElementById('narasumberList');
			narasumbers.forEach((narasumber) => {
				const narasumberUrl = configPath + 'DATA/PHP/related_results.php?narasumber=' + encodeURIComponent(narasumber);
				const narasumberDiv = document.createElement('li');
				narasumberDiv.className = 'narsum-li';
				// narasumberDiv.style.width = '150px';
				narasumberDiv.innerHTML = `<a href="${narasumberUrl}">${narasumber}</a>`;
				narasumberListContainer.appendChild(narasumberDiv);
			});
		}

		function expandEvent(){
			var eventCont = document.getElementById('eventList');
			var exBtn = document.getElementById('ex-event-btn');
			var prevHeight = eventCont.clientHeight;
			var barHeight = 200;

			if (prevHeight === barHeight){
				exBtn.textContent = "Show Less"
				eventCont.style.height = "auto";
			}else if (prevHeight > barHeight){
				exBtn.textContent = "Show More"
				eventCont.style.height = barHeight+"px";
				eventCont.style.overflowY = "clip";
				eventCont.style.overflowX = "clip";
			}

		}
		function updateSessionCheckboxFirst(){
			sessionStorage.setItem("changeSearchBy","1");
			updateSessionCheckbox();
		}

		function expandNarasumber(){
			var narasCont = document.getElementById('narasumberList');
			var exBtn = document.getElementById('ex-naras-btn');
			var prevHeight = narasCont.clientHeight;
			var barHeight = 200;

			if (prevHeight === barHeight){
				narasCont.style.height = "auto";//setAttribute("style","height: auto;");
				exBtn.textContent = "Show Less"
			}else if (prevHeight > barHeight){
				exBtn.textContent = "Show More"
				narasCont.style.height = barHeight+"px";
				narasCont.style.overflowY = "clip";
				narasCont.style.overflowX = "clip";
			}
		}

		document.getElementById('search').addEventListener('submit', function(event) {
			event.preventDefault();
			goSearch();
			hideRekomendasi();
			// regenerateLinks(); // Regenerate the links after search
		});
		function removeAllElements() {
			const container = document.getElementById('contEventNarsum');
			// Function to remove all elements inside a container
			function removeAllChildElements(container) {
				while (container.firstChild) {
					container.removeChild(container.firstChild);
				}
			}
			removeAllChildElements(container);
		}
		function startupAndSearch() {
			const fullURL = window.location.href;
			sessionStorage.setItem("lastUrl", fullURL);
			const segments = fullURL.split('/');
			if (segments[segments.length - 3] == "search") {
				const checkboxJudul = document.getElementById("checkbox_judul");
				const checkboxEvent = document.getElementById("checkbox_event");
				const checkboxNarasumber = document.getElementById("checkbox_narasumber");
				const checkboxRelated = document.getElementById("checkbox_related");
				if(segments[segments.length - 1].substring(0,1) == "t"){
					checkboxJudul.checked = true;
				}else{
					checkboxJudul.checked = false;
				}
				if(segments[segments.length - 1].substring(1,2) == "t"){
					checkboxEvent.checked = true;
				}else{
					checkboxEvent.checked = false;
				}
				if(segments[segments.length - 1].substring(2,3) == "t"){
					checkboxNarasumber.checked = true;
				}else{
					checkboxNarasumber.checked = false;
				}
				if(segments[segments.length - 1].substring(3,4) == "t"){
					checkboxRelated.checked = true;
				}else{
					checkboxRelated.checked = false;
				}
				if(sessionStorage.getItem("mode") == null){
					sessionStorage.setItem("mode","card");
				}
				if(sessionStorage.getItem("changeSearchBy") == null){
					updateSessionCheckboxFirst();
				}
				removeAllElements();
				if(sessionStorage.getItem("mode") == "card"){
					fetchSearchResult();
				}else if(sessionStorage.getItem("mode") == "list"){
					fetchSearchResult2();
				}
			} else {
				sessionStorage.setItem("mode","card");
				selectAll();
				fetchNewest();
				generateEventLinks();
				generateNarasumberLinks();
				expandEvent();
				expandNarasumber();
			}
		}
		startupAndSearch()
		updateFields();
		
	</script>
</body>

</html>
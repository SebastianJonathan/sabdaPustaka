<!DOCTYPE html>
<html lang="en">
<head>
	<?php include'header.php'?>
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
		<div class="row">		
			<!--COL Search & Filter  -->
			<div class="col-lg-2 col-md-3 col-filter" style="padding-right: 5px; padding-left:10px; min-width:210px;">

				<div class="card sect-cont-sidebar">
					<!-- <img src="..." class="card-img-top" alt="..."> -->
					<div class="card-body">
						<!-- <h5 class="card-title">Search</h5> -->
						<!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
						
						<div class="row">
							<h5 style="margin-bottom: 10px; font-weight:bold; color:gold;">Search By</h5>
						</div>
						<!-- Search By -->
						<div class="row fsc">
							<div class="checkbox-container">
								<label for="checkbox_judul" class="form-check-label checkbox-label bigger">
									<input type="checkbox" class="form-check-input bigger cbstyle" id="checkbox_judul" name="checkbox_judul" value="judul" onchange="">
									Judul
								</label>
							</div>
							<div class="checkbox-container">
								<label for="checkbox_narasumber" class="form-check-label checkbox-label bigger">
									<input type="checkbox" class="form-check-input bigger cbstyle" id="checkbox_narasumber" name="checkbox_narasumber" value="narasumber" onchange="">
									Narasumber
								</label>
							</div>
							<div class="checkbox-container">
								<label for="checkbox_event" class="form-check-label checkbox-label bigger">
									<input type="checkbox" class="bigger form-check-input" id="checkbox_event" name="checkbox_event" value="event" onchange="">
									Event
								</label>
							</div>
							<div class="checkbox-container">
								<label for="checkbox_related" class="form-check-label checkbox-label bigger">
									<input type="checkbox" class="bigger form-check-input" id="checkbox_related" name="checkbox_related" value="related" onchange="">
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
						<!--  Filter Narasumber-->
						<!-- <div class="row ffc" style="padding-top:15px; margin-top:10px; border-top: 1px gold solid;" id="ffc-filter-naras">
						</div> -->
						<!-- Filter Event-->
						<!-- <div class="row ffc" style="padding-top:15px; margin-top:10px; border-top: 1px gold solid;" id="ffc-filter-event">
						</div> -->
						<!-- Filter Tanggal -->
						<!-- <div class="row ffc" style="padding-top:15px; margin-top:10px; border-top: 1px gold solid;" id="ffc-filter-tgl">
						</div> -->
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
							<div class="offcanvas-body" >
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
											<input type="checkbox" class="form-check-input bigger" id="fsv-checkbox_judul" name="fsv-checkbox_judul" value="judul">
											Judul
										</label>
									</div>
									<div class="checkbox-container">
										<label for="fsv-checkbox_narasumber" class="form-check-label checkbox-label bigger">
											<input type="checkbox" class="form-check-input bigger" id="fsv-checkbox_narasumber" name="checkbox_narasumber" value="narasumber" >
											Narasumber
										</label>
									</div>
									<div class="checkbox-container">
										<label for="fsv-checkbox_event" class="form-check-label checkbox-label bigger">
											<input type="checkbox" class="bigger form-check-input" id="fsv-checkbox_event" name="checkbox_event" value="event">
											Event
										</label>
									</div>
									<div class="checkbox-container">
										<label for="fsv-checkbox_related" class="form-check-label checkbox-label bigger">
											<input type="checkbox" class="bigger form-check-input" id="fsv-checkbox_related" name="checkbox_related" value="related">
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
								<!-- FFV Filter Narasumber-->
								<!-- <div class="row ffv" style="padding-top:15px; margin-top:10px;  border-top: 1px black solid;" id="ffv-filter-naras">
								</div> -->
								<!-- FFV Filter Event -->
								<!-- <div class="row ffv" style="padding-top:15px; margin-top:10px;  border-top: 1px black solid;" id="ffv-filter-event">
								</div> -->
								<!-- FFV Filter Tanggal -->
								<!-- <div class="row ffv" style="padding-top:15px; margin-top:10px;  border-top: 1px black solid;" id="ffv-filter-tgl">
								</div> -->
							</div>
						</div>
						<script>
							const filter_sm = document.getElementById('filter-sm');
							function hideFilterSM(){
								let openedCanvas = bootstrap.Offcanvas.getInstance(filter_sm);
								try{
									openedCanvas.hide();
									// document.activeElement.blur();
								}catch{}
							}
							window.addEventListener('resize', hideFilterSM);
						</script>
					</div>
					<!-- Search Result Cards-->
					<div>
						<?php include 'search_result.php'; ?>
					</div>
				</div> 
			</div><!-- COL Card -->
			
			<!-- Spacer -->
			<div class="row" style="height: 20px;"></div>
		</div><!-- row konten -->
	</div> <!-- Container -->

	<?php include 'footer.php';?>

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

		function startupAndSearch(){
			const fullURL = window.location.href;
			const segments = fullURL.split('/');
			if(segments[segments.length - 2] == "search"){
				fetchSearchResult();
			}else{
				selectAll();
				fetchNewest();
				updateFields();
			}
		}
		startupAndSearch()

		function syncCheckbox(id, isChecked){
			var split_id = id.split("-");
			var clan = split_id[0];
			var true_id = split_id[1];

			if (clan === "ffv"){
				var ffc_id = "ffc-"+true_id;
				const ffc_cb = document.getElementById(ffc_id);
				ffc_cb.checked = isChecked;
			}else { 
				// clan === ffc
				var ffv_id = "ffv-"+true_id;
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
			updateFields();
		}
		// updateFields()

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
			var fsv_id = "fsv-"+id;
			// console.log(id + " -- " + fsv_id);
			// console.log(this.checked);
			$('#' + fsv_id).prop('checked', is_checked);
			updateFields();
		});

		function updateFields() {
			const checkbox_judul = document.getElementById('checkbox_judul');
			const checkbox_narasumber = document.getElementById('checkbox_narasumber');
			const checkbox_event = document.getElementById('checkbox_event');
			const checkbox_related = document.getElementById('checkbox_related');

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
			if (checkbox_related.checked) {
				fields.push('deskripsi_pendek');
				fields.push('ringkasan');
				fields.push('kata_kunci');
			}

			const queryInput = document.getElementById('query');
			queryInput.dataset.fields = fields.join(',');
			fetchRecommendations2();
		}

		function updateOnChecked(){
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

		function goSearch(){
			updateSessionCheckbox();
			window.location.href = "http://localhost/UI/sabdaPustaka/home.php/search/" + document.getElementById("query").value;
		}
		async function fetchRecommendations() {
			updateSessionCheckbox();
			const query = document.getElementById('query').value;
			const fields = document.getElementById('query').dataset.fields;

			try {
				const response = await fetch(`http://localhost/UI/sabdaPustaka/autocomplete.php?query=${query}&fields=${fields}`);
				const data = await response.json();
				// console.log(data.rekomendasi);
				console.log(data);
				tampilkanRekomendasi(data.rekomendasi);
			} catch (error) {
				console.error('Terjadi kesalahan:', error);
			}
		}

		async function fetchRecommendations2() {
			updateSessionCheckbox();
			const query = document.getElementById('query').value;
			const fields = document.getElementById('query').dataset.fields;

			try {
				const response = await fetch(`http://localhost/UI/sabdaPustaka/autocomplete.php?query=${query}&fields=${fields}`);
				const data = await response.json();
				// console.log(data.rekomendasi);
				tampilkanRekomendasi(data.rekomendasi);
			} catch (error) {
				console.error('Terjadi kesalahan:', error);
			}
			hideRekomendasi();
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
			if(rekomendasi.related.length > 0){
				addSection("RELATED",'section',rekomendasiList)
			}
			rekomendasi.related.forEach(function(item) {
				addSection(item,'list-hover',rekomendasiList)
			});

			const rekomendasiDiv = document.getElementById('rekomendasi');
			rekomendasiDiv.style.display = 'block';
		}

		function hideRekomendasi() {
			const rekomendasiDiv = document.getElementById('rekomendasi');
			rekomendasiDiv.style.display = 'none';
		}
		function updateSessionCheckbox(){
			const checkboxJudul = document.getElementById("checkbox_judul");
			const checkboxEvent = document.getElementById("checkbox_event");
			const checkboxNarasumber = document.getElementById("checkbox_narasumber");
			const checkboxRelated = document.getElementById("checkbox_related");

			sessionStorage.setItem("checkboxJudul", checkboxJudul.checked);
			sessionStorage.setItem("checkboxEvent", checkboxEvent.checked);
			sessionStorage.setItem("checkboxNarasumber", checkboxNarasumber.checked);
			sessionStorage.setItem("checkboxRelated", checkboxRelated.checked);
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
			if (target === queryInput){
					fetchRecommendations();
			}
		});

		function onChangeCheckbox2(){
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
			if (checkbox_related.checked) {
				fields.push('deskripsi_pendek');
				fields.push('ringkasan');
				fields.push('kata_kunci');
			}

			const queryInput = document.getElementById('query');
			queryInput.dataset.fields = fields.join(',');
			fetchRecommendations2();
		}

		function onChangeCheckbox(){
			const checkbox_judul = document.getElementById('checkbox_judul');
			const checkbox_narasumber = document.getElementById('checkbox_narasumber');
			const checkbox_event = document.getElementById('checkbox_event');
			const checkbox_related = document.getElementById('checkbox_related');
			const checkbox_judul2 = document.getElementById('fsv-checkbox_judul');
			const checkbox_narasumber2 = document.getElementById('fsv-checkbox_narasumber');
			const checkbox_event2 = document.getElementById('fsv-checkbox_event');
			const checkbox_related2 = document.getElementById('fsv-checkbox_related');

			checkbox_judul2.checked = checkbox_judul.checked;
			checkbox_narasumber2.checked = checkbox_narasumber.checked;
			checkbox_event2.checked = checkbox_event.checked;
			checkbox_related2.checked = checkbox_related.checked;

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
			if (checkbox_related.checked) {
				fields.push('deskripsi_pendek');
				fields.push('ringkasan');
				fields.push('kata_kunci');
			}

			const queryInput = document.getElementById('query');
			queryInput.dataset.fields = fields.join(',');
			fetchRecommendations2();
		}

		window.addEventListener('resize', updateRekomendasiPosition);
		window.addEventListener('DOMContentLoaded', updateRekomendasiPosition);

		document.getElementById('query').addEventListener('input', fetchRecommendations);
	</script>
</body>
</html>

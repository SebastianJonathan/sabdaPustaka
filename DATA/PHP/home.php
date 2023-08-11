<?php include 'header.php' ?>
<div id="p1_home">

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
							<h5 style="margin-bottom: 10px; font-weight:bold; color:gold;">Dasar Pencarian</h5>
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
										<h5 style="margin-bottom: 10px; font-weight:bold; color:gold;">Dasar Pencarian</h5>
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
				</div>
				<!-- Search Result Cards-->
				<div class="row">

					<div class="_cards-container">
						<div class="main" id="main">
							<button class="btn filter-sm-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#filter-sm" aria-controls="filter-sm" style="margin-left: 16px;">Filter</button>
							<div class="row" id="hs-header" style="padding-left: 16px;">
							</div> 
							<ul class="_cards" id="card_result">
							<!-- Card results will be dynamically added here -->
							</ul>
							<div id="show"></div>
						</div>

                    </div>


					<?php //include 'search_result.php'; ?>
	
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
	<a class="floating-btn" id="down-button" onclick="scrollToBottom()">&#8595</a>
	<a class="floating-btn" id="up-button" onclick="scrollToTop()">&#8593</a>
	<a href="https://api.whatsapp.com/send?phone=628812979100&text=Halo%20saya%20ingin%20bertanya%20terkait%20website%20SABDA%20Pustaka" target="_blank" class="floating-btn-wa">
		<img src="<?php echo $configPath?>img/wa.png" alt="WhatsApp">
	</a>




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
</div>

<?php include 'footer.php'; ?>
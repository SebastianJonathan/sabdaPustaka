<?php include 'header.php' ?>
<div id="p1_home">

	<div class="container-fluid">
		<!-- Penjelasan Website: Silahkan mencari dan menjelajahi materi yang telah disediakan oleh SABDA! -->
		<div class="row text-center penjelasan-web">
			<h4><strong>Silahkan Mencari dan Menjelajahi Materi yang telah Disediakan oleh SABDA!</strong></h4>
		</div>

		<!-- Row Search Bar -->
		<!-- <div class="row">
			<form action="" id="search" class="content sect-search">
				<div class="rekomendasi-container">
					<div class="col-md-6 InputContainer" style="background-color: #1e0049; ">
						<input placeholder="Cari di SABDA Pustaka" id="query" class="query form-control form-input" name="query" type="text" autocomplete="off">
						<button type="button" class="search-button" onclick="goSearch()" style="background-color: #1e0049; color: white;">Cari</button>
					</div>
					<div id="rekomendasi">
						<ul id="rekomendasi-list"></ul>
					</div>
				</div>
			</form>
		</div> -->


		<!-- Konten Website -->
		<div class="row" id="kontenS">
			<!--COL Search & Filter  -->
			<div class="col-lg-2 col-md-3 col-filter" id="col-filter-md" style="padding-right: 5px; padding-left:10px; min-width:210px;">
			
			<div id="sp-top-filter"></div>
			
			<div class="card sect-cont-sidebar" id="card-filter">
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
								<button type="button" class="button fs-btn" onclick="selectAll()">Pilih Semua</button>
								<button type="button" class="button fs-btn" onclick="clearSelection()">Hapus Semua</button>
							</div>
						</div>


						<div class="row _ffv" style="/*padding-top:15px; margin-top:10px;  border-top: 1px black solid;*/" id="ffc-filter">
						</div>
					</div>
				</div>
			</div><!-- COL Search & Filter  -->

			<!-- <div class="col-lg-2 col-md-3 sp-filter" style="margin-right: 29px;">
			</div> -->

			<!-- COL Card -->
			<div class="col">
				<div>
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
									<button type="button" class="button fs-btn" onclick="selectAll()">Pilih Semua</button>
									<button type="button" class="button fs-btn" onclick="clearSelection()">Hapus Semua</button>
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
		<div class="row end-row" id="end-row" style="height: 20px;"></div>
	</div><!-- row konten -->
	</div> <!-- Container -->
	<a class="floating-btn" id="down-button" onclick="scrollToBottom()">&#8595</a>
	<a class="floating-btn" id="up-button" onclick="scrollToTop()">&#8593</a>
	<a href="https://api.whatsapp.com/send?phone=628812979100&text=Halo%20saya%20ingin%20bertanya%20terkait%20website%20SABDA%20Pustaka" target="_blank" class="floating-btn-wa">
		<img src="<?php echo $configPath?>img/wa.png" alt="WhatsApp">
	</a>
</div>

<?php include 'footer.php'; ?>
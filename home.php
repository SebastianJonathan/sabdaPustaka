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

	<div class="container-fluid">
		<!-- Row Search Bar -->
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
						<div class="row ffc" style="padding-top:15px; margin-top:10px; border-top: 1px black solid;" id="ffc-filter">

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
									<div class="offcanvas-body" >
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
											<div class="buttons">
													<button type="button" class="button" onclick="selectAll()">Select all</button>
													<button type="button" class="button" onclick="clearSelection()">Clear selection</button>
											</div>
										</div>

										<!-- FSV Filter -->
										<div class="row ffv" style="padding-top:15px; margin-top:10px;  border-top: 1px black solid;" id="ffv-filter">
											<!-- <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id, laborum repudiandae sunt possimus neque laudantium est quo asperiores inventore aut!</p> -->
										</div>
										<!-- <p>Try scrolling the rest of the page to see this option in action.</p>
										<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Deserunt quas, aut sit ab vel repellendus laborum minima, cupiditate optio explicabo vitae officia et, suscipit aliquid eius amet? Pariatur ex nemo eveniet? Deleniti assumenda odio illo repellendus? Impedit facere ducimus sunt magnam corporis debitis veniam, rem commodi ipsum, assumenda tempore quod dolor necessitatibus atque architecto quam enim cupiditate sed neque asperiores numquam? Nulla at commodi, itaque culpa voluptatem nostrum quae unde consequatur quos blanditiis assumenda facere temporibus quidem eaque placeat ipsam vitae molestiae earum. Quis sequi in suscipit aliquid earum, aliquam saepe minus perspiciatis consequatur fuga nesciunt sed nobis quaerat voluptatum, blanditiis dolorum voluptate modi obcaecati sint quod, placeat neque! Officiis maiores tempore ipsam fugit sit cupiditate corporis, eligendi voluptatibus temporibus quos rerum omnis reprehenderit vitae, accusantium animi, atque debitis. Ea et perferendis ratione necessitatibus porro consequatur optio eaque, ipsum nam, quidem ipsa harum! Consequuntur obcaecati aperiam aliquam excepturi neque molestias eius laboriosam nesciunt eaque impedit maxime accusantium corrupti, eligendi architecto voluptatibus earum ipsam, temporibus cupiditate! Incidunt id placeat ratione nulla! Accusantium maxime voluptates qui omnis sint! Sequi obcaecati a, hic commodi quis tenetur aspernatur? Sunt asperiores itaque laudantium tempora distinctio pariatur quam consequatur veniam saepe ex adipisci, voluptatum natus eligendi explicabo voluptate, a culpa cupiditate iure? Ipsum quos autem culpa necessitatibus dicta ad neque dignissimos aut libero perspiciatis blanditiis cumque minus officiis obcaecati, odio porro labore laboriosam, repellat animi ut. Quia obcaecati odit, suscipit atque blanditiis tenetur rerum cum, non necessitatibus voluptates molestias quis quae exercitationem vitae at aliquid maxime facilis itaque voluptatum consectetur optio maiores. Eligendi aperiam ullam nam officia ex suscipit hic vitae doloremque eum fuga sunt explicabo, magni debitis. Quia facilis labore dolores impedit dolore, nulla distinctio vero minus quo nostrum? Officia culpa, nemo fuga nihil nostrum amet delectus? Illo, explicabo. Iste dolorum commodi minima maxime omnis, facere ducimus. Praesentium dolores repellat omnis quis quidem perferendis perspiciatis quo corrupti a, deserunt natus facilis fugit quam sequi, nostrum reprehenderit accusamus impedit illum enim laboriosam? Dolor, reprehenderit maxime! Eveniet voluptate qui ad quos tempore impedit a necessitatibus numquam iusto minima, saepe alias, omnis non itaque sit mollitia similique? Nam, harum voluptates ea nihil consequuntur voluptatem iure adipisci, aspernatur vel aliquid eius nisi. Veritatis, ab ducimus! Sapiente debitis natus modi? Expedita delectus non maiores esse, officia assumenda dolores pariatur eos quia quod a, natus repellendus sequi asperiores veniam architecto quasi autem, quidem repudiandae explicabo. Eos, eaque iusto veniam animi ullam blanditiis voluptatem, maiores corporis voluptatibus minima obcaecati officia optio fugit, soluta quibusdam tempore id omnis quod architecto ex veritatis explicabo. Aut ipsum magni quis amet maxime illo omnis aspernatur. Delectus, accusamus quia? Quasi laboriosam porro iste amet culpa doloremque itaque fugit vero quod natus incidunt maiores fugiat distinctio tenetur corporis minima deserunt, quisquam, illo ex molestias, mollitia in placeat? Quas, nostrum accusamus odit nemo voluptates ut velit est voluptatum debitis aperiam vero praesentium qui tenetur sit illo consequuntur sint, soluta facere fuga esse perspiciatis? Maiores, ex ullam. Exercitationem adipisci, dignissimos ipsum necessitatibus quibusdam dolor aliquid aspernatur ex tenetur, labore inventore. Nisi aliquam accusantium eum voluptatum alias ipsam quis! Iusto reprehenderit dolore natus sapiente corporis, possimus ex, doloribus maxime labore est magnam quaerat illo expedita ut nam eaque. Necessitatibus, molestiae sunt? Consequuntur distinctio ratione ut iusto, fugit rem ipsam accusantium laborum itaque earum cum nisi praesentium nobis obcaecati? Veniam blanditiis consequuntur ducimus repellat sapiente excepturi facere sed numquam nobis odio voluptatum animi, itaque vel quis voluptate facilis cum doloremque. Quisquam, numquam hic quis sequi similique aliquid odio quaerat quibusdam voluptatem! Sit accusamus cumque, magnam quisquam iure sint dolor placeat numquam possimus! Perferendis qui odit aspernatur iusto? Tenetur totam aliquam quae accusantium hic minus pariatur odit velit, laudantium harum illo animi temporibus cum quam. Consequatur veniam voluptate fugit, fugiat at accusantium corrupti soluta dolores itaque dolore ea. Aspernatur, est assumenda vel laborum nihil provident rerum architecto, hic explicabo tempora eum adipisci, sit voluptatem dolor veritatis. Libero adipisci culpa explicabo facere eveniet quo officiis sapiente sequi sit, laudantium sunt? Inventore, deleniti? Tempore iste ab culpa voluptate amet architecto, ipsam quia corrupti quod maxime dolorem nulla nobis dolores rem eos, exercitationem, voluptatibus sit sint possimus. Vel magnam maiores officiis soluta aliquam molestias dolore provident placeat reiciendis, adipisci maxime ipsa dolores consectetur eius blanditiis expedita voluptates atque culpa sint neque error et rerum. Consequatur, tenetur iste, harum, reiciendis qui perspiciatis dolorem ex eveniet nisi provident neque. Hic doloremque ipsum voluptates debitis quod temporibus perspiciatis repudiandae quibusdam optio nesciunt, nemo necessitatibus voluptas quo explicabo facilis esse, placeat aspernatur et beatae non! Exercitationem qui optio atque neque amet nobis incidunt labore odio. Sequi rerum eius temporibus cum nesciunt autem possimus saepe animi sunt porro molestiae nam modi mollitia obcaecati tempore consequatur fugit dolorem illo, consequuntur quam doloremque, iure dolore. Explicabo mollitia ullam eos ea incidunt neque, voluptatibus ad provident sunt hic, saepe repellat suscipit nobis molestiae eligendi? Reprehenderit velit maxime ea eaque. Delectus facere, repudiandae sapiente autem dolore aperiam quod officia veritatis vitae fuga, perferendis voluptate repellat quae assumenda non perspiciatis itaque temporibus in explicabo nostrum laborum cupiditate quas fugit facilis? Enim, ipsam illo, est nobis dolor optio nulla dignissimos quisquam repellat velit omnis consectetur debitis perferendis aperiam eos. Provident deserunt neque totam porro? Necessitatibus accusantium qui tempora minus et blanditiis in officiis. Dolore cupiditate omnis a non, similique error at in perferendis culpa repudiandae quidem optio enim iste recusandae quas ab dolorem fugit placeat architecto! Mollitia animi omnis quam est. Quae, non? Molestiae quas quibusdam optio voluptatum laborum consequuntur modi quos, est omnis placeat id, sequi in. Neque libero esse deserunt id quod iure aut eveniet nihil totam ipsam, quos ut magni excepturi necessitatibus, ex soluta mollitia delectus non! Accusantium adipisci similique repellendus, asperiores quibusdam error dicta pariatur. Quo odio, iste nihil enim consectetur asperiores quaerat! Distinctio, saepe corporis? Odio molestias, tempore ex quisquam facere repudiandae veritatis necessitatibus aperiam modi blanditiis! Voluptatem rerum sequi cum quas esse, labore at totam ipsa nemo, dolorum assumenda perspiciatis? Quisquam ad impedit quas aliquam dolor. Dicta aspernatur quis possimus illum consequatur numquam magnam doloremque quaerat at omnis distinctio, iusto aut.</p> -->
									</div>
								</div>

								<script>
									const filter_sm = document.getElementById('filter-sm');
									function hideFilterSM(){
										let openedCanvas = bootstrap.Offcanvas.getInstance(filter_sm);
										try{
											openedCanvas.hide();
										}catch{}
									}

									window.addEventListener('resize', hideFilterSM);
								</script>
						
							<h5>Hasil Search</h5>
						</div>
						
						<?php include 'search_result.php'; ?>
					</div>
				</div> <!-- row konten -->
				
				<!-- Spacer -->
				<div class="row" style="height: 20px;"></div>
			</form>

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
				if(!sessionStorage.getItem('first')){
					selectAll();
				}
				updateFields();
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
					document.getElementById('fsv-checkbox_event').checked = true;
					document.getElementById('checkbox_event').checked = true;
					document.getElementById('fsv-checkbox_narasumber').checked = true;
					updateFields();
				}

				function clearSelection() {
					document.getElementById('checkbox_judul').checked = false;
					document.getElementById('fsv-checkbox_judul').checked = false;
					document.getElementById('checkbox_narasumber').checked = false;
					document.getElementById('fsv-checkbox_event').checked = false;
					document.getElementById('checkbox_event').checked = false;
					document.getElementById('fsv-checkbox_narasumber').checked = false;
					updateFields();
				}
				updateFields()

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

				$('.ffv input[type=checkbox]').change(function() {
					var id = this.id;
					var is_checked = this.checked;
					var true_id = id.split("-")[1];
					var ffc_id = "ffc-"+true_id;
					console.log(id + " -- " + ffc_id);
					// console.log(this.checked);
					$('#' + ffc_id).prop('checked', is_checked);
					updateFields();
				});

				$('.ffc input[type=checkbox]').change(function() {
					var id = this.id;
					var is_checked = this.checked;
					var true_id = id.split("-")[1];
					var ffv_id = "ffv-"+true_id;
					console.log(id + " -- " + ffv_id);
					// console.log(this.checked);
					$('#' + ffv_id).prop('checked', is_checked);
					updateFields();
				});

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

				function updateOnChecked(){
					const checkbox_judul = document.getElementById('checkbox_judul');
					const checkbox_narasumber = document.getElementById('checkbox_narasumber');
					const checkbox_event = document.getElementById('checkbox_event');
					const checkbox_judul2 = document.getElementById('fsv-checkbox_judul');
					const checkbox_narasumber2 = document.getElementById('fsv-checkbox_narasumber');
					const checkbox_event2 = document.getElementById('fsv-checkbox_event');
					checkbox_judul.checked = checkbox_judul2.checked;
					checkbox_narasumber.checked = checkbox_narasumber2.checked;
					checkbox_event.checked = checkbox_event2.checked;
					updateFields();
				}

				async function fetchRecommendations() {
					const query = document.getElementById('query').value;
					const fields = document.getElementById('query').dataset.fields;

					try {
						const response = await fetch(`autocomplete.php?query=${query}&fields=${fields}`);
						const data = await response.json();
						// console.log(data.rekomendasi);
						tampilkanRekomendasi(data.rekomendasi);
					} catch (error) {
						console.error('Terjadi kesalahan:', error);
					}
				}

				async function fetchRecommendations2() {
					const query = document.getElementById('query').value;
					const fields = document.getElementById('query').dataset.fields;

					try {
						const response = await fetch(`autocomplete.php?query=${query}&fields=${fields}`);
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

					const rekomendasiDiv = document.getElementById('rekomendasi');
					rekomendasiDiv.style.display = 'block';
				}

				function hideRekomendasi() {
					const rekomendasiDiv = document.getElementById('rekomendasi');
					rekomendasiDiv.style.display = 'none';
				}
				let query = "";
				function getSearchResult() {
					const checkboxJudul = document.getElementById("checkbox_judul");
					const checkboxEvent = document.getElementById("checkbox_event");
					const checkboxNarasumber = document.getElementById("checkbox_narasumber");

					sessionStorage.setItem("checkboxJudul", checkboxJudul.checked);
					sessionStorage.setItem("checkboxEvent", checkboxEvent.checked);
					sessionStorage.setItem("checkboxNarasumber", checkboxNarasumber.checked);
					sessionStorage.setItem("first",true)
					fetchSearchResult();
					
				};
				document.getElementById("search").addEventListener("submit", function(event) {
					event.preventDefault();
					getSearchResult();
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
					const checkbox_judul2 = document.getElementById('fsv-checkbox_judul');
					const checkbox_narasumber2 = document.getElementById('fsv-checkbox_narasumber');
					const checkbox_event2 = document.getElementById('fsv-checkbox_event');

					checkbox_judul.checked = checkbox_judul2.checked;
					checkbox_narasumber.checked = checkbox_narasumber2.checked;
					checkbox_event.checked = checkbox_event2.checked;

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
					fetchRecommendations2();
				}

				function onChangeCheckbox(){
					const checkbox_judul = document.getElementById('checkbox_judul');
					const checkbox_narasumber = document.getElementById('checkbox_narasumber');
					const checkbox_event = document.getElementById('checkbox_event');
					const checkbox_judul2 = document.getElementById('fsv-checkbox_judul');
					const checkbox_narasumber2 = document.getElementById('fsv-checkbox_narasumber');
					const checkbox_event2 = document.getElementById('fsv-checkbox_event');

					checkbox_judul2.checked = checkbox_judul.checked;
					checkbox_narasumber2.checked = checkbox_narasumber.checked;
					checkbox_event2.checked = checkbox_event.checked;

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
					fetchRecommendations2();
				}

				window.addEventListener('resize', updateRekomendasiPosition);
				window.addEventListener('DOMContentLoaded', updateRekomendasiPosition);

				document.getElementById('query').addEventListener('input', fetchRecommendations);
				document.addEventListener('DOMContentLoaded', getSearchResult);
			</script>
		</div>
		
	</div>
	
	<?php include 'footer.php';?>
</body>



</html>

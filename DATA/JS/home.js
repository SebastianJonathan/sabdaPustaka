$('.fsv input[type=checkbox]').change(function() {
    var id = this.id;
    var is_checked = this.checked;
    var fsc_id = id.split("-")[1];
    $('#' + fsc_id).prop('checked', is_checked);
    updateFields();
});

$('.fsc input[type=checkbox]').change(function() {
    var id = this.id;
    var is_checked = this.checked;
    var fsv_id = "fsv-" + id;
    $('#' + fsv_id).prop('checked', is_checked);
    updateFields();
});

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
    if(document.getElementById('checkbox_judul').checked == false){
        document.getElementById('checkbox_judul').checked = true;
    }else{
    document.getElementById('checkbox_judul').checked = false;
    }
    updateSessionCheckboxFirst();
}
function onChangeResponsiveEvent(){
    if(document.getElementById('checkbox_event').checked == false){
        document.getElementById('checkbox_event').checked = true;
    }else{
    document.getElementById('checkbox_event').checked = false;
    }
    updateSessionCheckboxFirst();
}
function onChangeResponsiveNarasumber(){
    if(document.getElementById('checkbox_narasumber').checked == false){
        document.getElementById('checkbox_narasumber').checked = true;
    }else{
    document.getElementById('checkbox_narasumber').checked = false;
    }
    updateSessionCheckboxFirst();
}
function onChangeResponsiveRelated(){
    if(document.getElementById('checkbox_related').checked == false){
        document.getElementById('checkbox_related').checked = true;
    }else{
    document.getElementById('checkbox_related').checked = false;
    }
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

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

function buttonVisibility() {
    const buttonScrollDown = document.getElementById('down-button');
    const buttonScrollUp = document.getElementById('up-button');
    const windowHeight = window.innerHeight;
    const scrollPosition = window.scrollY;
    const bodyHeight = document.body.scrollHeight;

    const scrollDownThreshold = bodyHeight - windowHeight - 100;
    const scrollUpThreshold = 100; 

    if (scrollPosition > scrollDownThreshold) {
        buttonScrollDown.style.display = 'none';
    } else {
        buttonScrollDown.style.display = 'block';
    }

    if (scrollPosition > scrollUpThreshold) {
        buttonScrollUp.style.display = 'block';
    } else {
        buttonScrollUp.style.display = 'none';
    }
}

window.addEventListener('scroll', buttonVisibility);

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

function goSearch() {
    const fullURL = window.location.href;
    const segments = fullURL.split('/');
    if(segments[segments.length - 2] == "search" && document.getElementById('query').value == ""){
        window.location.href = configPath + "PHP/home.php/search/ ";
    }else{
        window.location.href = configPath + "PHP/home.php/search/" + document.getElementById('query').value;
    }
}
async function fetchRecommendations() {
    const query = document.getElementById('query').value;
    const fields = document.getElementById('query').dataset.fields;

    try {
        const response = await fetch(configPath + `API/autocomplete.php?query=${query}&fields=${fields}`);
        const data = await response.json();
        tampilkanRekomendasi(data.rekomendasi);
    } catch (error) {
        console.error('Terjadi kesalahan:', error);
    }
}

async function fetchRecommendations2() {
    const query = document.getElementById('query').value;
    const fields = document.getElementById('query').dataset.fields;
    try {
        const response = await fetch(configPath + `API/autocomplete.php?query=${query}&fields=${fields}`);
        const data = await response.json();
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
    if(sessionStorage.getItem("changeSearchBy") == "1" && segments[segments.length - 2] == "search"){
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
}

document.addEventListener('click', function(event) {
    const target = event.target;
    const queryInput = document.getElementById('query');
    const rekomendasiDiv = document.getElementById('rekomendasi');

    if (target !== queryInput && !rekomendasiDiv.contains(target)) {
        hideRekomendasi();
    }
    if (target === queryInput) {
        fetchRecommendations();
    }
});

function generateEventLinks() {
    const eventListContainer = document.getElementById('eventList');
    fetch(configPath + 'API/filterAPI.php', {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            "API": "getAllEvent",
        })
    })
    .then(response => 
        response.json()
    )
    .then(data => {
        if (data.result === "E-CONN"){
            // location.href = configPath+"PHP/errorConn.php";
            alert("Terjadi Kesalahan dalam Koneksi Data");
            location.reload();
        }else{
            data.result.forEach(function (event) {
                const eventUrl = configPath + 'PHP/related_results.php?event=' + encodeURIComponent(event);
                const eventDiv = document.createElement('li');
                eventDiv.className = 'event-li';
                eventDiv.innerHTML = `<a href="${eventUrl}">${event}</a>`;
                eventListContainer.appendChild(eventDiv);
            });
        }
    })
    .catch(error => {
        console.error(error);
    });
}

function generateNarasumberLinks() {
    const narasumberListContainer = document.getElementById('narasumberList');
    fetch(configPath + 'API/filterAPI.php', {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            "API": "getAllNarsum",
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.result === "E-CONN"){
            // location.href = configPath+"PHP/errorConn.php";
            alert("Terjadi Kesalahan dalam Koneksi Data");
            location.reload();
        }else{
            data.result.forEach(function (narasumber) {
                const narasumberUrl = configPath + 'PHP/related_results.php?narasumber=' + encodeURIComponent(narasumber);
                const narasumberDiv = document.createElement('li');
                narasumberDiv.className = 'narsum-li';
                narasumberDiv.innerHTML = `<a href="${narasumberUrl}">${narasumber}</a>`;
                narasumberListContainer.appendChild(narasumberDiv);
            });
        }
    })
    .catch(error => {
        console.error(error);
    });
}

function expandEvent(forceHide = false){
    var eventCont = document.getElementById('eventList');
    var exBtn = document.getElementById('ex-event-btn');
    var prevHeight = eventCont.clientHeight;
    var barHeight = 200;

    if (prevHeight === barHeight){
        exBtn.textContent = "Show Less"
        eventCont.style.height = "auto";
    }else if (prevHeight > barHeight || forceHide){
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

function expandNarasumber(forceHide = false){
    var narasCont = document.getElementById('narasumberList');
    var exBtn = document.getElementById('ex-naras-btn');
    var prevHeight = narasCont.clientHeight;
    var barHeight = 200;

    if (prevHeight === barHeight){
        narasCont.style.height = "auto";
        exBtn.textContent = "Show Less"
    }else if (prevHeight > barHeight || forceHide){
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
});
function removeAllElements() {
    const container = document.getElementById('contEventNarsum');
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
    const buttonScrollUp = document.getElementById('up-button');
    buttonScrollUp.style.display = 'none';
    try{
        if (segments[segments.length - 2] == "search"){
            document.getElementById('query').value = segments[segments.length - 1];
            updateSessionCheckbox();
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
            expandEvent(true);
            expandNarasumber(true);
        }
    } catch (error){
        location.reload();
    }
}
startupAndSearch()
updateFields();


const filter_sm = document.getElementById('filter-sm');

function hideFilterSM() {
		let openedCanvas = bootstrap.Offcanvas.getInstance(filter_sm);
		try {
			openedCanvas.hide();
		} catch {}
}

updateRekomendasiPosition();
window.addEventListener('resize', hideFilterSM);
window.addEventListener('resize', updateRekomendasiPosition);
document.getElementById('query').addEventListener('input', fetchRecommendations);
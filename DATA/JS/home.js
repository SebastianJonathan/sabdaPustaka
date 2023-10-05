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

var pageMode = "first";

var colFilter = document.getElementById('col-filter-md');
var spFilter = document.getElementById('sp-sidebar');
var footer = document.getElementById('footer');

var errorConn = false;

function errorConnHandling(){
    if (!errorConn){
        location.href = configPath + "PHP/errorConn.php";
    }
    errorConn = true;
}

function errorConnNoMore(){
    errorConn = false;
}


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

function genEventNarsumCont(){
    var cont = document.getElementById('contEventNarsum');
    cont.innerHTML = `<div class="row container-event" id="contEvent">
    <div class="row event-name" style="margin-bottom:20px;">
        <h2 class="text-center" >Semua Event</h2>
        <div class="dropdown">
            <button class="btn-group" style="background-color: transparent; color: gold; border:none;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Sort:
            </button>
            <button class="btn-group dropdown-toggle" style="align-items: center;" id="sortEv" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Alphabet
            </button>
            <ul class="dropdown-menu dropdown-menu-start" >
                <li><a class="dropdown-item" style="color: black;" onClick="generateEventLinks('alphabet')">Alphabet</a></li>
                <li><a class="dropdown-item" style="color: black;" onClick="generateEventLinks('numEv')">Jumlah</a></li>
            </ul>
        </div>

    </div>
    <div class="">
        <ul id="eventList" style="padding-left: 0px;"></ul>
    </div>
    <div style="display: flex; justify-content: center;">
        <button id="ex-event-btn" type="button" onclick="expandEvent()">show more</button>
    </div>
</div>
<div class="row container-event" id="contNarsum">
    <div class="row event-name">
        <h2 class="text-center" style="margin-bottom:20px;">Semua Narasumber</h2>
        <div class="dropdown">
            <button class="btn-group" style="background-color: transparent; color: gold; border:none;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Sort:
            </button>
            <button class="btn-group dropdown-toggle" style="align-items: center;" id="sortNarsum" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Alphabet
            </button>
            <ul class="dropdown-menu dropdown-menu-start" >
                <li><a class="dropdown-item" style="color: black;" onClick="generateNarasumberLinks('alphabet')">Alphabet</a></li>
                <li><a class="dropdown-item" style="color: black;" onClick="generateNarasumberLinks('numNarsum')">Jumlah</a></li>
            </ul>
        </div>
            

    </div>
    <div class="row">
        <ul id="narasumberList"></ul>
    </div>
    <div class="row" style="display: flex; justify-content: center;">
        <button id="ex-naras-btn" onclick="expandNarasumber()">show more</button>
    </div>
</div>`
}

function generateEventLinks(sort = "alphabet") {
    const eventListContainer = document.getElementById('eventList');
    eventListContainer.innerHTML = '';
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
            errorConnHandling();
        }else{
            errorConnNoMore();
            var sortEvbtn = document.getElementById('sortEv');
            if (sort=="alphabet"){
                let sortedEvents = Object.keys(data.result).sort();
                sortedEvents.forEach(function (event) {
                    var count = data.result[event];
                    var eventUrl = configPath + 'PHP/related_results.php?event=' + encodeURIComponent(event);
                    var eventDiv = document.createElement('li');
                    eventDiv.className = 'event-li';
                    eventDiv.innerHTML = `<a href="${eventUrl}">${event}(${count})</a>`;
                    eventListContainer.appendChild(eventDiv);
                });
                sortEvbtn.textContent = "Alphabet";
            }else if (sort=="numEv"){
                let sortedCount = Object.entries(data.result).sort((a, b) => b[1] - a[1]);
                for (let [key, value] of sortedCount) {
                    var eventUrl = configPath + 'PHP/related_results.php?event=' + encodeURIComponent(key);
                    var eventDiv = document.createElement('li');
                    eventDiv.className = 'event-li';
                    eventDiv.innerHTML = `<a href="${eventUrl}">${key}(${value})</a>`;
                    eventListContainer.appendChild(eventDiv);
                }
                sortEvbtn.textContent = "Jumlah";
            }
            isExpandableEv();
        }
    })
    .catch(error => {
        console.error(error);
    });
}

function generateNarasumberLinks(sort="alphabet") {
    const narasumberListContainer = document.getElementById('narasumberList');
    narasumberListContainer.innerHTML = '';
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
            errorConnHandling();
        }else{
            errorConnNoMore();
            var sortNrbtn = document.getElementById('sortNarsum');
            if (sort=="alphabet"){
                let sortedNarsum = Object.keys(data.result).sort();
                sortedNarsum.forEach(function (narasumber) {
                    var count = data.result[narasumber];
                    var narasumberUrl = configPath + 'PHP/related_results.php?narasumber=' + encodeURIComponent(narasumber);
                    var narasumberDiv = document.createElement('li');
                    narasumberDiv.className = 'narsum-li';
                    narasumberDiv.innerHTML = `<a href="${narasumberUrl}">${narasumber}(${count})</a>`;
                    narasumberListContainer.appendChild(narasumberDiv);
                });
                sortNrbtn.textContent = "Alphabet";
            }else if (sort=="numNarsum"){
                let sortedCount = Object.entries(data.result).sort((a, b) => b[1] - a[1]);
                for (let [key, value] of sortedCount) {
                    var narasumberUrl = configPath + 'PHP/related_results.php?narasumber=' + encodeURIComponent(key);
                    var narasumberDiv = document.createElement('li');
                    narasumberDiv.className = 'narsum-li';
                    narasumberDiv.innerHTML = `<a href="${narasumberUrl}">${key}(${value})</a>`;
                    narasumberListContainer.appendChild(narasumberDiv);
                }
                sortNrbtn.textContent = "Jumlah";
            }
            isExpandableNarsum();
        }
    })
    .catch(error => {
        console.error(error);
    });
}

var EvNrHeightLimit = 240;

function isExpandableEv(){
    var eventCont = document.getElementById('eventList');
    var exBtn = document.getElementById('ex-event-btn');
    var prevHeight = eventCont.clientHeight;

    if (prevHeight < EvNrHeightLimit){
        expandEvent(false, true);
        exBtn.style.display = "none";
    }else{
        expandEvent(true);
    }
}

function isExpandableNarsum(){
    var narasCont = document.getElementById('narasumberList');
    var exBtn = document.getElementById('ex-naras-btn');
    var prevHeight = narasCont.clientHeight;

    if (prevHeight < EvNrHeightLimit){
        expandNarasumber(false, true);
        exBtn.style.display = "none";
    }else{
        expandNarasumber(true);
    }
}

function expandEvent(forceHide = false, forceShow = false){
    var eventCont = document.getElementById('eventList');
    var exBtn = document.getElementById('ex-event-btn');
    var prevHeight = eventCont.clientHeight;
    var barHeight = 200;

    if (prevHeight === barHeight || forceShow){
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

function expandNarasumber(forceHide = false, forceShow = false){
    var narasCont = document.getElementById('narasumberList');
    var exBtn = document.getElementById('ex-naras-btn');
    var prevHeight = narasCont.clientHeight;
    var barHeight = 240;

    if (prevHeight === barHeight || forceShow){
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

function getRemValue() {
    return parseFloat(getComputedStyle(document.documentElement).fontSize);
}

function startupAndSearch() {
    console.log("STARTUP");
    const fullURL = window.location.href;
    sessionStorage.setItem("lastUrl", fullURL);
    const segments = fullURL.split('/');
    const buttonScrollUp = document.getElementById('up-button');
    buttonScrollUp.style.display = 'none';
    var sType = sessionStorage.getItem("SpecificType");
    var sFilter = sessionStorage.getItem("SpecificFilter");
    try{
        if (segments[segments.length - 2] == "search"){
            pageMode = "search";
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
                if (sType == "none"){
                    fetchSearchResult();
                }else{
                    fetchSearchFilterResult(sType, sFilter);
                }
                
            }else if(sessionStorage.getItem("mode") == "list"){
                
                if (sType == "none"){
                    fetchSearchResult2();
                }else{
                    fetchSearchFilterResult2(sType, sFilter);
                }
                
            }
        } else {
            pageMode = "first";
            sessionStorage.setItem("mode","card");
            document.getElementById('card-filter').style.height = "fit-content";
            selectAll();
            fetchNewest();
            genEventNarsumCont();
            generateEventLinks();
            generateNarasumberLinks();
        }
    } catch (error){
        // window.alert(error);
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

window.addEventListener('resize', hideFilterSM);
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

function goSearch() {
    const fullURL = window.location.href;
    const segments = fullURL.split('/');
    if(segments[segments.length - 2] == "search" && document.getElementById('query').value == ""){
        window.location.href = configPath + "PHP/home.php/search/ ";
    }else{
        window.location.href = configPath + "PHP/home.php/search/" + document.getElementById('query').value;
    }
}

function hideRekomendasi() {
    const rekomendasiDiv = document.getElementById('rekomendasi');
    rekomendasiDiv.style.display = 'none';
}

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
        goSearch();
    });
    rekomendasiList.appendChild(li);
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

var navbarMode = "normal";

function navbarResize(){
    let width = window.innerWidth;
    console.log("Width: "+ width);

    var searchBtn = document.getElementById('search-icon');
    var searchBar = document.getElementById('search');
    // var backBtn = document.getElementById('back-search-icon');
    var tognavCol = document.getElementById('togNav');
    var navbarLogo = document.getElementById('logo');
    var navbarToggle = document.getElementById('toggle');

    if (width > 680){
        navbarMode = "normal";
        searchBtn.style.display = "none";
        searchBar.style.display = "block";
        tognavCol.style.display = "";
        navbarLogo.style.display = "contents";
        navbarToggle.style.display = "unset";
        // backBtn.style.display = "none";
    }else{
        if (navbarMode == "tempSearchBar"){
            searchBar.style.display = "block";
            // backBtn.style.display = "block";
            searchBtn.style.display = "none";
            tognavCol.style.display = "none";
            navbarLogo.style.display = "none";
            navbarToggle.style.display = "none";
        }else{
            searchBar.style.display = "none";
            // backBtn.style.display = "none";
            searchBtn.style.display = "unset";
            
            navbarLogo.style.display = "contents";
            navbarToggle.style.display = "unset";
            tognavCol.style.display = "";

        }

    }
    // searchBtn.style.display = "none";
}

function toogleNavbar(){
    if (navbarMode == "normal"){
        navbarMode = "tempSearchBar";
    }else{
        navbarMode == "normal";
    }
    navbarResize();
    // document.getElementById("search-icon").style.display = 'none';
    // document.getElementById("toggle").style.display = 'none';
    // document.getElementById("logo").style.display = 'none';
    // document.getElementById("search").style.display = 'block';
    // document.getElementById("search").style.position = 'absolute';
}

document.getElementById("search").addEventListener("submit", function(event) {
    event.preventDefault();
    if(document.getElementById("logo") == 'none'){
        document.getElementById("search-icon").style.display = 'block';
        document.getElementById("toggle").style.display = 'block';
        document.getElementById("logo").style.display = 'block';
        document.getElementById("search").style.display = 'none';
        document.getElementById("search").style.position = 'fixed';
    }
    goSearch();
    hideRekomendasi();
});
updateRekomendasiPosition();
navbarResize();
window.addEventListener('resize', navbarResize);
window.addEventListener('resize', updateRekomendasiPosition);
document.getElementById('query').addEventListener('input', fetchRecommendations);
updateFields();
window.scrollTo(0, 0);
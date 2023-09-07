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

function toogleNavbar(){
    document.getElementById("search-icon").style.display = 'none';
    document.getElementById("toggle").style.display = 'none';
    document.getElementById("logo").style.display = 'none';
    document.getElementById("search").style.display = 'block';
    document.getElementById("search").style.position = 'absolute';
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
window.addEventListener('resize', updateRekomendasiPosition);
document.getElementById('query').addEventListener('input', fetchRecommendations);
updateFields();
window.scrollTo(0, 0);
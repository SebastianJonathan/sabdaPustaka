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
updateRekomendasiPosition();
window.addEventListener('resize', updateRekomendasiPosition);
document.getElementById('query').addEventListener('input', fetchRecommendations);
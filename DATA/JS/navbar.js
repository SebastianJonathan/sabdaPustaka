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
updateRekomendasiPosition();
window.addEventListener('resize', updateRekomendasiPosition);
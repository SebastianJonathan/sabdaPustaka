var errorConn = false;

function errorConnHandling(){
    if (!errorConn){
        // alert("Terjadi Kesalahan dalam Koneksi Data");
        // location.reload();
        location.href = configPath + "PHP/errorConn.php";
    }
    errorConn = true;
}

function errorConnNoMore(){
    errorConn = false;
}

const keywordLinks = document.querySelectorAll('.keyword-link');
keywordLinks.forEach(link => {
    link.addEventListener('click', (e) => {
    e.preventDefault();
    const query = link.dataset.keyword;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'related_results.php';

    const keywordInput = document.createElement('input');
    keywordInput.type = 'hidden';
    keywordInput.name = 'keyword';
    keywordInput.value = query;

    form.appendChild(keywordInput);

    document.body.appendChild(form);
    form.submit();
    });
});

const narsumLinks = document.querySelectorAll('.narsum-link');
narsumLinks.forEach(link => {
    link.addEventListener('click', (e) => {
    e.preventDefault();
    const query = link.dataset.keyword;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'related_results.php';

    const narsumInput = document.createElement('input');
    narsumInput.type = 'hidden';
    narsumInput.name = 'narasumber';
    narsumInput.value = query;

    form.appendChild(narsumInput);

    document.body.appendChild(form);
    form.submit(); // <-- Add parentheses to call the form submission function
    });
});

const eventLinks = document.querySelectorAll('.event-link');
eventLinks.forEach(link => {
    link.addEventListener('click', (e) => {
    e.preventDefault();
    const query = link.dataset.keyword;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'related_results.php';

    const eventInput = document.createElement('input');
    eventInput.type = 'hidden';
    eventInput.name = 'event';
    eventInput.value = query;

    form.appendChild(eventInput);

    document.body.appendChild(form);
    form.submit(); // <-- Add parentheses to call the form submission function
    });
}); 


function togglePdfViewer() {
    var pdfViewer = document.getElementById('pdfViewer');
    var image = document.getElementById('image');
    if (pdfViewer.style.display === 'none') {
    pdfViewer.style.display = 'block';
    image.style.display = 'none';
    } else {
    pdfViewer.style.display = 'none';
    image.style.display = 'block';
    }
}

function getQueryParameterValue(url, parameterName) {
    const params = new URLSearchParams(new URL(url).search);
    return params.get(parameterName);
}

function fetchRelatedDocuments() {

    const documentId = getQueryParameterValue(location.href, "document_id");

    fetch(configPath + `API/getRelated.php?document_id=${encodeURIComponent(documentId)}`)
    .then(response => response.text())
    .then(data => {
        if (data === "E-CONN"){
            errorConnHandling();
        }else{
            errorConnNoMore();
            const relatedResultsContainer = document.getElementById('related-results-container');
            relatedResultsContainer.innerHTML = data;
        }
    })
    .catch(error => {
        console.error(error);
    });
}


function fetchRelatedJudul() {
    const documentId = getQueryParameterValue(location.href, "document_id");

    fetch(configPath + `API/getRelatedJudul.php?document_id=${encodeURIComponent(documentId)}`)
    .then(response => response.text())
    .then(data => {
        if (data === "E-CONN"){
            errorConnHandling();
        }else{
            errorConnNoMore();
            const relatedResultsContainer = document.getElementById('related-judul-container');
            relatedResultsContainer.innerHTML = data;
        }
    })
    .catch(error => {
        console.error(error);
    });
}

// Call the fetchRelatedDocuments function to fetch and display the related document titles
fetchRelatedDocuments();
fetchRelatedJudul();

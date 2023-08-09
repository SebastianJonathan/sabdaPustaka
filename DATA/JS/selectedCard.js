    /* 
    FETCH KEYWORD DI BUTTON > PINDAH KE RELATED_RESULTS.PHP
*/
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

    /* 
        FETCH NARSUM DI BUTTON > PINDAH KE RELATED_RESULTS.PHP
    */

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

    function fetchRelatedDocuments() {
        const documentId = "<?php echo $_GET['document_id']; ?>";

        fetch(configPath + `API/getRelated.php?document_id=${encodeURIComponent(documentId)}`)
        .then(response => response.text())
        .then(data => {
            const relatedResultsContainer = document.getElementById('related-results-container');
            relatedResultsContainer.innerHTML = data;
        })
        .catch(error => {
            console.error(error);
        });
    }


    function fetchRelatedJudul() {
        const documentId = "<?php echo $_GET['document_id']; ?>";

        fetch(configPath + `API/getRelatedJudul.php?document_id=${encodeURIComponent(documentId)}`)
        .then(response => response.text())
        .then(data => {
            const relatedResultsContainer = document.getElementById('related-judul-container');
            relatedResultsContainer.innerHTML = data;
        })
        .catch(error => {
            console.error(error);
        });
    }

    // Call the fetchRelatedDocuments function to fetch and display the related document titles
    fetchRelatedDocuments();
    fetchRelatedJudul();
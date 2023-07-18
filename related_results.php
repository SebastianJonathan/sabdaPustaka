<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Related Results</title>
    <!-- Add your CSS stylesheets and other head elements as needed -->
</head>

<body>
    <h1>Related Results</h1>

    <div id="judul-container"></div>
    <div id="narasumber-container"></div>

    <!-- Add your additional HTML content and scripts as needed -->

    <?php
    if (isset($_POST['keyword'])) {
        $keyword = $_POST['keyword'];
        echo "Keyword: " . $keyword;
    } else {
        echo "No keyword provided.";
    }
    ?>

    <script>
        // Extract the keyword from the POST data
        const keyword = "<?php echo isset($_POST['keyword']) ? $_POST['keyword'] : ''; ?>";

        if (keyword) {
            // Fetch the judul and narasumber using the getKeyword.php API
            fetch(`getKeyword.php?query=${encodeURIComponent(keyword)}`)
                .then(response => response.json())
                .then(data => {
                    const hasil = data.hasil;
                    const juduls = hasil.map(item => item.judul);
                    const narasumbers = hasil.map(item => item.event); // Update this line to use the correct property for narasumber

                    // Display the results
                    showResults(juduls, narasumbers);
                })
                .catch(error => {
                    console.error(error);
                });
        } else {
            console.log("No keyword provided.");
        }

        function showResults(juduls, narasumbers) {
            // Display the results in the page
            const judulContainer = document.getElementById('judul-container');
            const narasumberContainer = document.getElementById('narasumber-container');

            judulContainer.innerHTML = "<h2>Judul:</h2>" + juduls.map(title => "<p>" + title + "</p>").join("");
            narasumberContainer.innerHTML = "<h2>Narasumber:</h2>" + narasumbers.map(speaker => "<p>" + speaker + "</p>").join("");
        }
    </script>
</body>

</html>

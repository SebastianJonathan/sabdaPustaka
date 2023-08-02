<?php include '../API/config.php' ?>
<title>Sabda Pustaka</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    loadCustomStyles();

    function loadCustomStyles() {
        addStyleSheet(configPath + "DATA/CSS/styles3.css");
        addStyleSheet(configPath + "DATA/CSS/style.css");
        addStyleSheet(configPath + "DATA/CSS/sabdastyle.css");
        addStyleSheet(configPath + "DATA/CSS/getalllist.css");
    }

    function addStyleSheet(href) {
        var link = document.createElement("link");
        link.rel = "stylesheet";
        link.href = href;
        document.head.appendChild(link);
    }

</script>
<?php include 'header.php'; ?>
<div id="p3_relatedResult">
    <div class="container-fluid">
        <div class="row row-search">
            <form action="" id="search" class="content">
                <!-- Filter + Konten -->
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="col-konten-head terkait" id="related-search">
                            <?php
                            if (isset($_POST['keyword'])) {
                                $keyword = $_POST['keyword'];
                                echo '<h2 class="centered-text">Pencarian Terkait</h2><h4 class="centered-text large-text">' . ucfirst($keyword) . '</h4>';
                            }

                            if (isset($_POST['narasumber'])) {
                                $narsum = $_POST['narasumber'];
                                echo '<h2 class="centered-text">Pencarian Terkait</h2><h4 class="centered-text large-text">' . ucfirst($narsum) . '</h4>';
                            }

                            
                            if (isset($_POST['event'])) {
                                $event_ = $_POST['event'];
                                echo '<h2 class="centered-text">Pencarian Terkait</h2><h4 class="centered-text large-text">' . ucfirst($event_) . '</h4>';
                            }
                            ?>
                        </div>

                        <div class="_cards-container">
                            <div class="main" id="main">
                                <div class="row" id="hs-header" style="padding-left: 16px;">
                                    <!-- <div id="show">

                                    </div> -->
                                </div> 
                                <ul class="_cards" id="card_result">
                                <!-- Card results will be dynamically added here -->
                                </ul>
                                <div id="show"></div>
                            </div>
                        </div>
                    </div>
                </div> <!-- row konten -->

                <!-- Spacer -->
                <div class="row" style="height: 20px;"></div>
            </form>
        </div>
        <!-- </ul> -->
    </div>
    <!-- </div> -->
</div>
    

    </div>



    <?php include 'footer.php'; ?>
<!-- </body>

</html> -->

<section class="banner">
    <div class="container">
        <div class="row banner__row">
            <?
                $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `banners` ORDER BY regdate ASC");
                $i = 0;
                while($row = mysqli_fetch_array($query)) {
                    ?>
                        <div class="col-lg-4">
                            <div class="banner__card">
                                <div class="banner__icon">
                                    <?php echo gallery('banners', $row['id'], 0, 1, 'small', $row_article['title']); ?>
                                </div>
                                <div class="banner__content">
                                    <h6 class="banner__title"><?php echo $row['title']; ?></h6>
                                    <div class="banner__desc">
                                        <?php echo $row['description']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?
                }
            ?>
        </div>
    </div>
</section>

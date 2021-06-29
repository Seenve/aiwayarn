<?php 
	if (!isset($_SERVER['HTTP_X_PJAX'])) { 
		/*$og_url = $_SERVER['REQUEST_URI'];
		if(gallery_arr('portfolio', $row_page['id'], '1')['0']['image']) {
			$og_image = settings()['0']['url'].$uploads_middle.gallery_arr('portfolio', $row_page['id'], '1')['0']['image'];
		}*/
		include 'header.php'; 
	}
?>

<?php include $path.'/../modules/breadcrumbs.php'; ?>

<section class="reviews">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1>Отзывы</h1>
			</div>
		</div>
		<div class="row reviews__row">
            <?php
                $num_image = 0;
                foreach (gallery_arr('pages', 34, '1') as $key => $value) {
                    ?>

                        <div class="col-lg-3 col-md-4 col-sm-6 col-6 reviews__docs p-3">
                        	<a href="/ap/image.php?image=<? echo $value['image']; ?>&type=full" data-fancybox="gallery">
	                        	<picture>
	                            	<img src="/ap/image.php?image=<? echo $value['image']; ?>&type=small" alt="<? echo $arrProduct['title']; ?>">
	                            </picture>
                        	</a>
                        </div>
                    <?
                    $num_image++;
                }
            ?>
		</div>
		<div class="row">
			<?
				$query_reviews = mysqli_query($GLOBALS['db'], "SELECT * FROM `reviews` ORDER BY regdate ASC");
				$i = 0;
				while($row_reviews = mysqli_fetch_array($query_reviews)) {
					$i++;
					//if($row_reviews['site'] == '') {
						?>
							<div class="col-lg-12 reviews__single">
								<div class="reviews__single__content">
									<?php echo htmlspecialchars_decode($row_reviews['content']); ?>
					                <span class="news__date">
					                    <svg class="news__icon" width="16" height="17" xmlns="http://www.w3.org/2000/svg"><path d="M10.47 10.279L8.24 8.606V5.197a.62.62 0 10-1.24 0v3.718c0 .196.092.38.248.496l2.479 1.86a.616.616 0 00.867-.125.619.619 0 00-.124-.867z" fill="#818181"/><path d="M8 .578c-4.411 0-8 3.588-8 8 0 4.411 3.589 8 8 8 4.412 0 8-3.589 8-8 0-4.412-3.588-8-8-8zm0 14.76a6.769 6.769 0 01-6.76-6.76A6.769 6.769 0 018 1.817a6.769 6.769 0 016.76 6.76A6.769 6.769 0 018 15.339z"/></svg>
					                    <time datetime="<? $date = strtotime($row_reviews['regdate']); echo date("Y-m-d H:i", $date); ?>"><? $date = strtotime($row_reviews['regdate']); echo date("d M Y", $date); ?></time>
					                </span>
				                </div>
							</div>
						<?
					/*} else {
						?>
							<div class="col-lg-12 reviews__single-video">
								<iframe src="https://www.youtube-nocookie.com/embed/<? echo youtubeId($row_reviews['site']); ?>?controls=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						<?
					}*/
				}
			?>
		</div>
	</div>
</section>
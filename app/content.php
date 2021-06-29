<?php 
	if (!isset($_SERVER['HTTP_X_PJAX'])) { 
		$og_url = $_SERVER['REQUEST_URI'];
		if(gallery_arr('portfolio', $row_page['id'], '1')['0']['image']) {
			$og_image = settings()['0']['url'].$uploads_middle.gallery_arr('portfolio', $row_page['id'], '1')['0']['image'];
		}
		include 'header.php'; 
	}
?>

<?php include $path.'/../modules/breadcrumbs.php'; ?>

<section class="content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php echo htmlspecialchars_decode($row_pages['content']); ?>
			</div>
		</div>
	</div>
</section>

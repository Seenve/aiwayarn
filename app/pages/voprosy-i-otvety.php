<?/*
	if(isset($_GET['portfolio'])) {
		$name = mysql_escape_string(htmlspecialchars($_GET['portfolio']));
		$query_news = mysqli_query($GLOBALS['db'], "SELECT * FROM `portfolio` WHERE `name` = '$name'"); 
		if(mysqli_num_rows($query_news) > 0) {
			$row_page = mysqli_fetch_assoc($query_news);
			$title = $row_page['title'];
			$description = $row_page['description'];
			$keywords = $row_page['keywords'];
			$name_url = $row_page['name'];
?>
<?php 
	if (!isset($_SERVER['HTTP_X_PJAX'])) { 
		$og_url = $_SERVER['REQUEST_URI'];
		if(gallery_arr('portfolio', $row_page['id'], '1')['0']['image']) {
			$og_image = settings()['0']['url'].$uploads_middle.gallery_arr('portfolio', $row_page['id'], '1')['0']['image'];
		}
		include 'header.php'; 
	}
?>


<hr>
<section class="section section-contact section-onescreen news1">
	<div class="img-blur" style="background-image: url(/uploads/<?php echo gallery_arr('portfolio', $row_page['id'], '1')['0']['image']; ?>);"></div>
    <div class="container"> 
        <div class="row">
            <div class="col-md-12">
                <h1 class="title__section title__h1 title_horizontal-line"><span class="reveal reveal_gray"><?php echo $row_page['title']; ?></span></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
				<div class="tags">
					<?php
						$arr_tags = explode(", ", $row_page['keywords']);

						foreach($arr_tags as $key_tag => $value_tag) {
							if($value_tag) {
								echo '<h5 class="tag" id="tag'.$key_tag.'">'.$value_tag.'</h5>';
							}
						}
					?>
				</div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
    </div>
</section>
<section class="section section-contact section-onescreen news">
    <div class="container"> 
		<div class="row images-news">
			<?php
				foreach(gallery_arr('portfolio', $row_page['id']) as $key_tag => $value_tag) {
					if($value_tag['main'] == '0') {
						echo '<div class="col-md-2 col-xs-12 img"><img href="/uploads/'.$value_tag['image'].'" data-fancybox="portfolio" src="/uploads/small/'.$value_tag['image'].'" alt="'.$row_page['title'].'" title="'.$row_page['title'].'"></div>';
					}
				}
			?>
		</div>
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<a class="btn btn__contact" href="<?php echo $row_page['site']; ?>" target="_blank">Открыть сайт</a>
				<div class="text">
					<?php echo htmlspecialchars_decode($row_page['content']); ?>
				</div>
				<p>Добавлена <? $date = strtotime($row_page['regdate']); echo date("d.m.y в H:i", $date); ?></p>
			</div>
		</div>
	</div>
</section>
<?
		} else {
			header("HTTP/1.0 404 Not Found");
			include 'header.php';
			include '404.php';
			include 'footer.php';
			exit();
		}
	} else {
?>
<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>
<section class="section section-works section_top-space-230 section_first">
	<div class="container">
        <div class="row">
		    <div class="col-md-12 section__header-wrap">
			    <h1 class="title__section title__h1 title_horizontal-line"><span class="reveal reveal_gray">Наши работы</span></h1>
			    <p class="section__subtitle">Мы знаем, кто мы есть, но не знаем, кем мы можем быть.</p>
			</div>
		</div>
	</div>

    <div class="container">
		<div class="portfolio" id="data-container">
			<?
				$resultp = mysqli_query($GLOBALS['db'], "SELECT * FROM `portfolio` ORDER BY id DESC");
				$i = 1;
				while($rowp = mysqli_fetch_array($resultp)) {
					$idp = $rowp['id'];
					$image = gallery_arr('portfolio', $idp)['0']['image'];
                    if($image){
                        $image = $uploads.$image;
                    } else {
                        $image = '/assets/images/main/gor.jpg';
                    }
					$name = $rowp['name'];
					$titlea = $rowp['title'];
					$type = $rowp['type'];
					$site_url = $rowp['site'];
					$likes = $rowp['likes'];
					if($i <= 9) {
						echo '
							<div class="col-md-4 col-sm-6 col-xs-12">
								<div class="item-portfolio">
					                <a class="link-case" href="/portfolio/'.$name.'" data-pjax="content" target="_blank">
										<img class="image-portfolio" src="'.$image.'" alt="'.$titlea.'" title="'.$titlea.'">
									</a>
									<ul class="item-details">
										<li class="tooltip" data-tooltip="'.$titlea.'"><i class="fa fa-info-circle" aria-hidden="true"></i></a><span>'.$typeportfolio_arr[$type].'</span></li>
										<li class="item-details_right"><a href="#like" class="set-like" onclick="like('.$idp.', '.$likes.'); return false;"><i class="fa fa-heart" aria-hidden="true"></i></a><span id="like'.$idp.'">'.$likes.'</span></li>
									</ul>
								</div>
							</div>
						';
					} else {
						echo '<a href="/portfolio/'.$name.'" class="link-dis" style="display: flex;position:absolute;height: 0px; width: 0px; overflow: hidden;">'.$titlea.'</a>';
					}
					$i++;
				}

			?>
        </div>
	</div>
	
    
	<div class="btn-load__col btn-load__col_space">
		<div class="loading-div" id="loading-div">
			<div class="spinner-icon spinner-icon-white"></div>
		</div>
        <button type="submit" class="btn-load__button btn-loading" id="button-more"><span class="ripple"></span></button>
		<span class="btn-load__text load-cases">Показать ещё</span>
	</div>
	
</section>



<!--<section class="section section-newsletter">
    <div class="container">
	    <div class="row">
		    <div class="col-md-8 col-md-offset-2 section__header-wrap">
		      <h5 class="title title__h5 title_center title_normal"><span class="reveal reveal_gray">Подпишитесь на нашу рассылку, чтобы получать специальные предложения.</span></h5>
			</div>
		</div>
		
		<div class="form-group">
			<form class="subscribe-form" data-toggle="validator">
			    <div class="subscribe-form__inner">
				    <input type="email" class="form-control _big email_valid" placeholder="Введите ваш E-mail" required data-error="Пожалуйста, введите ваш E-mail.">
				    <button type="submit" class="btn-subscribe">OK</button>
				</div>
				<div id="validator-subscribe" class="hidden"></div>
			</form>
		</div>

	</div>	
</section>-->
<?php }*/ ?>

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

<section class="vacancy">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="vacancy__heading">Вопросы и ответы</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="vacancy__list">
					<?
						$query_vacancy = mysqli_query($GLOBALS['db'], "SELECT * FROM `portfolio` ORDER BY regdate DESC");
						$i = 0;
						while($row_vacancy = mysqli_fetch_array($query_vacancy)) {
							$i++;
							?>
								<div class="vacancy__block row <?php if($i == 1) { echo 'active'; } ?>">
									<div class="vacancy__info col-lg-6">
										<div class="vacancy__toggle">
											<div class="vacancy__icon"></div>
											<h3><?php echo $row_vacancy['title']; ?></h3>
										</div>
										<div class="vacancy__content">
											<?php echo htmlspecialchars_decode($row_vacancy['content']); ?>
										</div>
									</div>
									<div class="vacancy__img col-lg-5 offset-lg-1">
										<?php echo gallery('portfolio', $row_vacancy['id'], 0, 1, 'middle', $row_vacancy['title'], true); ?>
									</div>
								</div>
							<?
						}
					?>
				</div>
			</div>
		</div>
	</div>
</section>

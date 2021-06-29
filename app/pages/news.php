<?php
	$tag = isset($_GET['tag']) ? $_GET['tag'] : '';
	if(isset($_GET['news'])) {
		$name = mysqli_escape_string($GLOBALS['db'], htmlspecialchars($_GET['news']));
		$query_news = mysqli_query($GLOBALS['db'], "SELECT * FROM `news` WHERE `name` = '$name'"); 
		if(mysqli_num_rows($query_news) > 0) {
			$row_page = mysqli_fetch_assoc($query_news);
			$pageId = $row_page['id'];
			$title = $row_page['title'];
			$description = $row_page['description'];
			$keywords = $row_page['keywords'];
			$name_url = $row_page['name'];
?>
<?php 
	if (!isset($_SERVER['HTTP_X_PJAX'])) { 
		$og_url = $_SERVER['REQUEST_URI'];
		if(gallery_arr('news', $row_page['id'], '1')['0']['image']) {
			$og_image = settings()['0']['url'].$uploads_middle.gallery_arr('news', $row_page['id'], '1')['0']['image'];
		}
		include 'header.php'; 
	}
?>

<?php include $path.'/../modules/breadcrumbs.php'; ?>

<section class="article">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1><?php echo $row_page['title']; ?></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-8 article__content">
				<?php echo gallery('news', $row_page['id'], 0, 1, 'middle', $postrow[$in]['title']); ?>
				<?php echo htmlspecialchars_decode($row_page['content']); ?>
                <!--<div class="article__tags">
                    <span>Теги</span>

					<?php
						$arr_tags = explode(", ", $row_page['tags']);

						foreach($arr_tags as $key_tag => $value_tag) {
							if($value_tag) {
								echo '<a href="#" rel="tag" id="tag'.$key_tag.'">'.$value_tag.'</a>';
							}
						}
					?>
                </div>
            	-->

                <span class="news__date">
                    <svg class="news__icon" width="16" height="17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.47 10.279L8.24 8.606V5.197a.62.62 0 10-1.24 0v3.718c0 .196.092.38.248.496l2.479 1.86a.616.616 0 00.867-.125.619.619 0 00-.124-.867z" fill="#818181"/><path d="M8 .578c-4.411 0-8 3.588-8 8 0 4.411 3.589 8 8 8 4.412 0 8-3.589 8-8 0-4.412-3.588-8-8-8zm0 14.76a6.769 6.769 0 01-6.76-6.76A6.769 6.769 0 018 1.817a6.769 6.769 0 016.76 6.76A6.769 6.769 0 018 15.339z" fill="#818181"/></svg>
                    <time datetime="<? $date = strtotime($row_page['regdate']); echo date("Y-m-d H:i", $date); ?>"><? $date = strtotime($row_page['regdate']); $month = date('n', $date)-1; echo date("d ".$arrMonth[$month]." Y", $date); ?></time>
                </span>

				<ul class="article__share">
                    <li>
                        <a onclick="window.open('https://www.facebook.com/sharer.php?s=100&amp;p[url]=https://ribka.ru','sharer', 'toolbar=0,status=0,width=620,height=280');" data-toggle="tooltip" title="Share on Facebook" href="javascript:">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a onclick="popUp=window.open('http://twitter.com/home?status=How we scaled up social media https://ribka.ru','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" data-toggle="tooltip" title="Share on Twitter" href="javascript:;">
                            <i class="fa fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a onclick="popUp=window.open('http://vk.com/share.php?url=https://ribka.ru','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" data-toggle="tooltip" title="Share on VK" href="javascript:;">
                            <i class="fa fa-vk"></i>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tooltip" title="Share on Pinterest" onclick="popUp=window.open('http://pinterest.com/pin/create/button/?url=https://ribka.ru&amp;description=How we scaled up social media&amp;media=img/1/blog/post1.jpg','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;">
                            <i class="fa fa-pinterest"></i>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tooltip" title="Share on Google +1" href="javascript:;" onclick="popUp=window.open('https://plus.google.com/share?url=https://ribka.ru','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tooltip" title="Share on Linkedin" onclick="popUp=window.open('http://linkedin.com/shareArticle?mini=true&amp;url=https://ribka.ru&amp;title=How we scaled up social media','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;">
                            <i class="fa fa-linkedin"></i>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tooltip" title="Share on Tumblr" onclick="popUp=window.open('http://www.tumblr.com/share/link?url=https://ribka.ru&amp;name=How we scaled up social media&amp;description=Etiam+mollis+mi+id+nisl+varius+consequat.+In+lacinia+vestibulum+mi%2C+pulvinar+venenatis+justo+sollicitudin+vel.+Pellentesque+et+felis+eget...','sharer','scrollbars=yes,width=800,height=400');popUp.focus();return false;" href="javascript:;">
                            <i class="fa fa-tumblr"></i>
                        </a>
                    </li>
                </ul>

			</div>
            <div class="offset-lg-1 col-lg-3">
            	<div class="row">

					<?php
						$query_article = mysqli_query($GLOBALS['db'], "SELECT * FROM `news` WHERE `id` != '$pageId' ORDER BY `regdate` DESC LIMIT 0, 3");    
						while ($row_article = mysqli_fetch_array($query_article)) {
							//if($row_article['id'] > $pageId) {
								?>
						            <div class="col-lg-12 news__item">
						                <a href="/news/<?php echo $row_article['name']; ?>" class="news__link" data-pjax="content">
						                    <div class="news__block-img">
						                        <?php echo gallery('news', $row_article['id'], 0, 1, 'small', $row_article['title']); ?>
						                    </div>
						                    <div class="news__content">
						                        <span class="news__date">
						                            <svg class="news__icon" width="16" height="17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.47 10.279L8.24 8.606V5.197a.62.62 0 10-1.24 0v3.718c0 .196.092.38.248.496l2.479 1.86a.616.616 0 00.867-.125.619.619 0 00-.124-.867z" fill="#818181"/><path d="M8 .578c-4.411 0-8 3.588-8 8 0 4.411 3.589 8 8 8 4.412 0 8-3.589 8-8 0-4.412-3.588-8-8-8zm0 14.76a6.769 6.769 0 01-6.76-6.76A6.769 6.769 0 018 1.817a6.769 6.769 0 016.76 6.76A6.769 6.769 0 018 15.339z" fill="#818181"/></svg>
						                            <time datetime="<? $date = strtotime($row_article['regdate']); echo date("Y-m-d H:i", $date); ?>"><? $date = strtotime($row_article['regdate']); echo date("d M Y", $date); ?></time>
						                        </span>
						                        <h6 class="news__title"><?php echo $row_article['title']; ?></h6>
						                        <?php /*echo  mb_substr(strip_tags(htmlspecialchars_decode($postrow[$in]['content'])), 0, 340, 'UTF-8').'...';*/ ?>
						                    </div>
						                </a>
						            </div>
								<?php
							//}
						}
					?>
            	</div>	
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

<?php include $path.'/../modules/breadcrumbs.php'; ?>

<section class="articles">

	<div class="articles__head">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1>Наши новости</h1>
				</div>
			</div>
		</div>
	</div>

    <div class="special__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="special__header">
                        <button class="special__btn link--black">
                            Теги
                            <svg width="8" height="12" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z"></path></svg>
                        </button>
                        <ul class="special__list tab-header">
                                
                            <li class="special__item">
                                <a href="/news" class="special__link tab-header__item <? if($tag == '') { echo 'active-link'; } ?>" data-tab="1" data-pjax="content">Все <sup><?php echo nums('news'); ?></sup></a>
                            </li>

							<?php
								$subcats= str_replace(',',' ',implode(", ", news_tags_arr()));
								$a_tags = rec($subcats);

								foreach($a_tags as $key_tag => $value_tag) {
									if($key_tag) {
										if($key_tag == $_GET['tag']) {
											echo '
												<li class="special__item">
												    <a href="/news?tag='.$key_tag.'" class="special__link tab-header__item active-link" data-tab="2" data-pjax="content">'.$key_tag.' <sup>'.$a_tags[$key_tag]['count'].'</sup> </a>
												</li>
											';
										} else {
											echo '
												<li class="special__item">
												    <a href="/news?tag='.$key_tag.'" class="special__link tab-header__item" data-tab="2" data-pjax="content">'.$key_tag.' <sup>'.$a_tags[$key_tag]['count'].'</sup> </a>
												</li>
											';
										}
									}
								}
							?>
              
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="articles__list">
		<div class="container">
			<div class="row">
				<?php
					if($_GET['num']) {
						$url_page = $_SERVER['REQUEST_URI'].'&num=';
					} else {
						$url_page = '/?page=news&num=';
					}
					$tag_news = mysqli_escape_string($GLOBALS['db'], htmlspecialchars($_GET['tag']));
					$num = 12;  
					if($tag_news) {
					    $pagenum = htmlspecialchars($_GET['num']);
					    $page = htmlspecialchars($_GET['page']);
					    // Переменная хранит число сообщений выводимых на станице  
					    $result01s = mysqli_query($GLOBALS['db'], "SELECT * FROM `news` WHERE `show` = '1' AND `tags` LIKE '%$tag_news%'");  
					    $posts = mysqli_num_rows($result01s);  
					    // Находим общее число страниц  
					    $total = intval(($posts - 1) / $num) + 1;  
					    // Определяем начало сообщений для текущей страницы  
					    $pagenum = intval($pagenum);  
					    // Если значение $pagenum меньше единицы или отрицательно  
					    // переходим на первую страницу  
					    // А если слишком большое, то переходим на последнюю  
					    if(empty($pagenum) or $pagenum < 0) $pagenum = 1;  
					      if($pagenum > $total) $pagenum = $total;  
					    // Вычисляем начиная к какого номера  
					    // следует выводить сообщения  
					    $start = $pagenum * $num - $num;  
					    // Выбираем $num сообщений начиная с номера $start  
					    $result0 = mysqli_query($GLOBALS['db'], "SELECT * FROM `news` WHERE `show` = '1' AND `tags` LIKE '%$tag_news%' ORDER BY `regdate` DESC LIMIT $start, $num");    
					    // В цикле переносим результаты запроса в массив $postrow  
					    while ($postrow[] = mysqli_fetch_array($result0)); 
					} else {
					    $pagenum = htmlspecialchars($_GET['num']);
					    $page = htmlspecialchars($_GET['page']);
					    // Переменная хранит число сообщений выводимых на станице  
					    $result01s = mysqli_query($GLOBALS['db'], "SELECT * FROM `news` WHERE `show` = '1'");  
					    $posts = mysqli_num_rows($result01s);  
					    // Находим общее число страниц  
					    $total = intval(($posts - 1) / $num) + 1;  
					    // Определяем начало сообщений для текущей страницы  
					    $pagenum = intval($pagenum);  
					    // Если значение $pagenum меньше единицы или отрицательно  
					    // переходим на первую страницу  
					    // А если слишком большое, то переходим на последнюю  
					    if(empty($pagenum) or $pagenum < 0) $pagenum = 1;  
					      if($pagenum > $total) $pagenum = $total;  
					    // Вычисляем начиная к какого номера  
					    // следует выводить сообщения  
					    $start = $pagenum * $num - $num;  
					    // Выбираем $num сообщений начиная с номера $start  
					    $result0 = mysqli_query($GLOBALS['db'], "SELECT * FROM `news` WHERE `show` = '1' ORDER BY `regdate` DESC LIMIT $start, $num");    
					    // В цикле переносим результаты запроса в массив $postrow  
					    while ($postrow[] = mysqli_fetch_array($result0));  
					}


					if($posts > 0){  
						//while($row1 = mysql_fetch_array($res1)) {
				        for($in = 0; $in < $num; $in++) {  
				            $idstr = $postrow[$in]['id'];
				            if($idstr > 0) {
								?>
					                <div class="col-lg-3 news__item">
					                    <a href="/news/<?php echo $postrow[$in]['name']; ?>" class="news__link" data-pjax="content">
						                    <div class="news__block-img">
						                        <?php echo gallery('news', $idstr, 0, 1, 'small', $postrow[$in]['title']); ?>
						                    </div>
						                    <div class="news__content">
						                        <span class="news__date">
						                            <svg class="news__icon" width="16" height="17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.47 10.279L8.24 8.606V5.197a.62.62 0 10-1.24 0v3.718c0 .196.092.38.248.496l2.479 1.86a.616.616 0 00.867-.125.619.619 0 00-.124-.867z" fill="#818181"/><path d="M8 .578c-4.411 0-8 3.588-8 8 0 4.411 3.589 8 8 8 4.412 0 8-3.589 8-8 0-4.412-3.588-8-8-8zm0 14.76a6.769 6.769 0 01-6.76-6.76A6.769 6.769 0 018 1.817a6.769 6.769 0 016.76 6.76A6.769 6.769 0 018 15.339z" fill="#818181"/></svg>
						                            <time datetime="<? $date = strtotime($postrow[$in]['regdate']); echo date("Y-m-d H:i", $date); ?>"><? $date = strtotime($postrow[$in]['regdate']); $month = date('n', $date)-1; echo date("d ".$arrMonth[$month]." Y", $date); ?></time>
						                        </span>
						                        <h6 class="news__title"><?php echo $postrow[$in]['title']; ?></h6>
						                        <?php /*echo  mb_substr(strip_tags(htmlspecialchars_decode($postrow[$in]['content'])), 0, 340, 'UTF-8').'...';*/ ?>
						                    </div>
					                    </a>
					                </div>
								<?php
							}
						}
					} else {
						echo '<div class="col-lg-12">Новостей нет</div>';
					}
				?>
                                                
			</div>
		</div>
    </div>

<!--
    <div class="articles__pagination">
    	<div class="container">
    		<div class="row">
	    		<div class="col-lg-6">
	    			<?php include $path.'/../modules/pagination.php'; ?>
	    		</div>
	    		<div class="col-lg-6">
	    			<div class="stats">
	    				<span>Опубликованных <?php echo nums('news'); ?> <? echo ending(nums('news'), 'статья', 'статьи', 'статей'); ?></span>
	    			</div>
	    		</div>
	    	</div>
    	</div>
    </div>-->

</section>

<section class="catalog-pages articles__pagination">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <?php include $path.'/../modules/pagination.php'; ?>
            </div>
            <div class="col-lg-6">
                <div class="catalog-pages__info">
                    <p>Опубликованных <?php echo nums('news'); ?> <? echo ending(nums('news'), 'статья', 'статьи', 'статей'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php } ?>
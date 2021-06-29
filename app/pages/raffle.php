<style>
	.top {
		box-shadow: none !important;
	}
</style>

<?php
	include 'raffle_bd.php';

	$raffle_user = mysql_escape_string(htmlspecialchars($_GET['raffle']));
	$raffle_un = mysql_query("SELECT * FROM `users` WHERE `id` = '$raffle_user'", $raffle_db);
	if($raffle_user && $raffle_user > 0 && mysql_num_rows($raffle_un) > 0) {
		$row_u = mysql_fetch_array($raffle_un);
?>
   <header class="hero" style="background-image: url(/assets/img/bgraffle.jpg);">
	    <div class="container">
            <div class="hero__caption">
			    <div class="hero__row">
			        <h2 class="title__h1 hero__title hero__title_line">Розыгрыш денежных сертификатов<br> на создание сайта или чат-бота</h2>
			       	<h3>Общая сумма выигрыша <span style="color: #42ed72;">84 000 <i class="fa fa-rub"></i></span></h3>	
			       	<h4>Розыгрыш состоится 1 октября, победители будут объявлены в нашей прямой <a href="#">трансляции Вконтакте</a></h4>		       	
                    <a class="btn hero__btn" href="/raffle" data-pjax="content">Участвовать</a>
				</div>
			</div>
		</div>
		<div class="hero__social animated slideInUp">
		    <!--<a class="link_decoration" href="#raffle-users"><b>Кол-во участников <?php echo $count_users; ?></b> <i class="fa fa-users"></i></a>-->
		</div>
    </header>	

    <section class="section section__hello section_no-space-bottom" id="hello">
        <div class="container">
			<div class="row">
			    <div class="col-md-8 col-md-offset-2 col__quote text-center" data-bottom="transform[swing]:translateY(0px)" data--400-top="transform[swing]:translateY(-100px)">
				    <h2 class="title__section title__h1 title_decoration title_vertical-line-top">Анкета участника</h2>
					<div class="block-quotes block-quote__about">
					    <div class="raffle-block">
					    	<div class="img" style="background-image: url(<?php echo $row_u['avatar']; ?>);"></div>
					    	<h3><?php echo $row_u['firstname']; ?></h3>
					    	<p>Ожидай трансляции 1 октября 16:00 (МСК) в нашей <a href="https://vk.com/vucs_ru" target="_blank">группе Вконтакте</a></p>
					    	<div class="bilet animated">
					    		<div class="txt">Твой билет</div>
					    		<div class="number">№ <?php echo $row_u['id']; ?></div>
					    	</div>

					    	<p>Обязательно запомни этот билет, сделай скриншот или сохрани к себе на стену Вконтакте</p>
					    	<a class="button-save" href="https://vk.com/share.php?url=https://vucs.pro/raffle/<?php echo $row_u['id']; ?>" target="_blank">Сохранить <i class="fa fa-vk"></i></a>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<meta property="og:title" content="Николай стал участником розыгрыша" />
	<meta property="og:image" content="<?php echo $row_u['avatar_big']; ?>" />
<?	

	} else {

?>

   <header class="hero" style="background-image: url(/assets/img/bgraffle.jpg);">
	    <div class="container">
            <div class="hero__caption">
			    <div class="hero__row">
			        <h2 class="title__h1 hero__title hero__title_line">Розыгрыш денежных сертификатов<br> на создание сайта или чат-бота</h2>
			       	<h3>Общая сумма выигрыша <span style="color: #42ed72;">84 000 <i class="fa fa-rub"></i></span></h3>	
			       	<h4>Розыгрыш состоится 1 октября, победители будут объявлены в прямой <a href="https://vk.com/vucs_ru" target="_blank">трансляции Вконтакте</a></h4>		       	
                    <a class="btn hero__btn" href="!#hello">Участвовать</a>
				</div>
			</div>
		</div>
		<div class="hero__social animated slideInUp">
		    <!--<a class="link_decoration" href="#raffle-users"><b>Кол-во участников <?php echo $count_users; ?></b> <i class="fa fa-users"></i></a>-->
		</div>
    </header>	
    
	<section class="section section-counters text-center">
        <div class="container">
		    <div class="row os">
			    <div class="col-sm-4 col-md-4">
				    <div class="counter">
				        <div class="counter__date title_decoration">1</div>
					    <div class="counter__name">Место</div>
					</div>
					<br>
					Победитель получает сертификат <br>на сумму 60 000 <i class="fa fa-rub"></i>
				</div>
			    <div class="col-sm-4 col-md-4">
				    <div class="counter">
				        <div class="counter__date title_decoration">2</div>
					    <div class="counter__name">Место</div>
					</div>
					<br>
					Победитель получает сертификат <br>на сумму 20 000 <i class="fa fa-rub"></i>
				</div>
			    <div class="col-sm-4 col-md-4">
				    <div class="counter counter_last-child">
				        <div class="counter__date title_decoration">3</div>
					    <div class="counter__name">Место</div>
					</div>
					<br>
					Победитель получает сертификат <br>на сумму 4 000 <i class="fa fa-rub"></i>
				</div>
		    </div>
		</div>
	</section>
	
    <section class="section section__hello section_no-space-bottom" id="hello">
        <div class="container">
			<div class="row">
			    <div class="col-md-8 col-md-offset-2 col__quote text-center" data-bottom="transform[swing]:translateY(0px)" data--400-top="transform[swing]:translateY(-100px)">
				    <h2 class="title__section title__h1 title_decoration title_vertical-line-top">Условия участия</h2>
					<div class="block-quotes block-quote__about">
						<h4>1. Подписаться на наш <a href="https://vk.com/vucs_ru" target="_blank">паблик ВКонтакте</a></h4>
						<h4>2. Сделать репост <a href="https://vk.com/vucs_ru?w=wall-30095205_54" target="_blank">данной записи</a></h4>
						<br><br>

<?php
	$raffle_u = mysql_escape_string(htmlspecialchars($_GET['raffle']));
	if($raffle_u && $raffle_u >= 1) {

	}
?>

					    <form id="raffle_form" method="POST" action="/api/raffle.php">
					    	<h4>Если ты все сделал(а) правильно, заполни форму участника</h4>
							<input name="from" type="hidden" value="<?php echo htmlspecialchars($_GET['from']); ?>">
                           
                        	Скопируйте и вставьте ссылку на вашу страницу Вконтакте
					        <label for="firstname" class="label"></label>
                            <input type="text" class="form-control" style="text-align: center;font-weight: 600;color: yellow;border: 1px solid #fff;padding-left: 10px;padding-right: 10px;" name="address" required autocomplete="off">
						   	<div id="result"></div>
						    <button type="submit" class="btn hero__btn">Отправить</button>
						</form>
					</div>
				</div>
            </div>
		</div>
	</section>
	

	
	<!--<section class="section section-works">
    	<div class="container">
            <div class="row">
			    <div class="col-md-12 section__header-wrap">
				    <h2 class="title__section title__h1 title_horizontal-line"><span class="reveal reveal_gray">Наши работы.</span></h2>
				    <p class="section__subtitle">Если вы не слушаете самых ценных пользователей, вы упускаете возможность создать по-настоящему ценный контент.</p>
				</div>
			</div>
		</div>

        <div class="container-fluid">
			<div class="grid-gallery grid-gallery__base grid-gallery_fully">
				<figure class="item-portfolio item-portfolio__column-four">
                    <a class="link-case" href="http://domasib.com" target="_blank">
						<img class="image-portfolio" src="/uploads/1.jpg" alt="Photo">
					</a>
					<ul class="item-details">
						<li class="item-details_right"><a href="#like"><i class="fa fa-heart" aria-hidden="true"></i></a><span>27</span></li>
					</ul>
				</figure>

				<figure class="item-portfolio item-portfolio__column-four">
                    <a class="link-case" href="http://domasib.com" target="_blank">
						<img class="image-portfolio" src="/uploads/1.jpg" alt="Photo">
					</a>
					<ul class="item-details">
						<li class="item-details_right"><a href="#like"><i class="fa fa-heart" aria-hidden="true"></i></a><span>27</span></li>
					</ul>
				</figure>

				<figure class="item-portfolio item-portfolio__column-four">
                    <a class="link-case" href="http://domasib.com" target="_blank">
						<img class="image-portfolio" src="/uploads/1.jpg" alt="Photo">
					</a>
					<ul class="item-details">
						<li class="item-details_right"><a href="#like"><i class="fa fa-heart" aria-hidden="true"></i></a><span>27</span></li>
					</ul>
				</figure>

				<figure class="item-portfolio item-portfolio__column-four">
                    <a class="link-case" href="http://domasib.com" target="_blank">
						<img class="image-portfolio" src="/uploads/1.jpg" alt="Photo">
					</a>
					<ul class="item-details">
						<li class="item-details_right"><a href="#like"><i class="fa fa-heart" aria-hidden="true"></i></a><span>27</span></li>
					</ul>
				</figure>

				<figure class="item-portfolio item-portfolio__column-four">
                    <a class="link-case" href="http://domasib.com" target="_blank">
						<img class="image-portfolio" src="/uploads/1.jpg" alt="Photo">
					</a>
					<ul class="item-details">
						<li class="item-details_right"><a href="#like"><i class="fa fa-heart" aria-hidden="true"></i></a><span>27</span></li>
					</ul>
				</figure>

				<figure class="item-portfolio item-portfolio__column-four">
                    <a class="link-case" href="http://domasib.com" target="_blank">
						<img class="image-portfolio" src="/uploads/1.jpg" alt="Photo">
					</a>
					<ul class="item-details">
						<li class="item-details_right"><a href="#like"><i class="fa fa-heart" aria-hidden="true"></i></a><span>27</span></li>
					</ul>
				</figure>

				<figure class="item-portfolio item-portfolio__column-four">
                    <a class="link-case" href="http://domasib.com" target="_blank">
						<img class="image-portfolio" src="/uploads/1.jpg" alt="Photo">
					</a>
					<ul class="item-details">
						<li class="item-details_right"><a href="#like"><i class="fa fa-heart" aria-hidden="true"></i></a><span>27</span></li>
					</ul>
				</figure>

				<figure class="item-portfolio item-portfolio__column-four">
                    <a class="link-case" href="http://domasib.com" target="_blank">
						<img class="image-portfolio" src="/uploads/1.jpg" alt="Photo">
					</a>
					<ul class="item-details">
						<li class="item-details_right"><a href="#like"><i class="fa fa-heart" aria-hidden="true"></i></a><span>27</span></li>
					</ul>
				</figure>
            </div>
			
			<a href="gallery.html" class="btn-link btn-link_right">Все работы</a>
		</div>		
	</section>-->
    
	
	
	

	
	<!--<section class="section section_top-space-230">
    	<div class="container">
            <div class="row">
			    <div class="col-md-12 section__header-wrap">
				    <h2 class="title__section title__h1 title_center"><span class="reveal reveal_gray">Победители</span></h2>
				</div>
			</div>
		</div>
		
        <div class="client-carousel swiper-container">
		    <div class="swiper-wrapper">
		        
                <div class="swiper-slide client-carousel-item reveal">
			        <div class="item__block-number">
				        <span>1.</span>
				    </div>
			        <div class="item__block-author">
				        <div class="item__block-image">
					        <img src="/assets/img/noav.png">
					    </div>
					    <div class="item__block-name">
					        <h3 class="client__name">Имя <strong>Фамилия</strong></h3>
					        <h4 class="cleint__organization">Билет: 0</h4>
					    </div>
				    </div>
				    <div class="item__block-description">
				        <p></p>
                    </div>        
			    </div>
			    
                <div class="swiper-slide client-carousel-item">
			        <div class="item__block-author">
			            <div class="item__block-number">
				            <span>2.</span>
				        </div>
				        <div class="item__block-image">
					        <img src="/assets/img/noav.png">
					    </div>
					    <div class="item__block-name">
					        <h3 class="client__name">Имя <strong>Фамилия</strong></h3>
					        <h4 class="cleint__organization">Билет: 0</h4>
					    </div>
				    </div>
				    <div class="item__block-description">
				        <p></p>
                    </div>     
			    </div>
			    
                <div class="swiper-slide client-carousel-item">
			        <div class="item__block-author">
			            <div class="item__block-number">
				            <span>2.</span>
				        </div>
				        <div class="item__block-image">
					        <img src="/assets/img/noav.png">
					    </div>
					    <div class="item__block-name">
					        <h3 class="client__name">Имя <strong>Фамилия</strong></h3>
					        <h4 class="cleint__organization">Билет: 0</h4>
					    </div>
				    </div>
				    <div class="item__block-description">
				        <p></p>
                    </div>     
			    </div>
			    
            </div>
			
		    
			<div class="swiper-control">
			    <div class="swiper-pagination"></div>
                <div class="swiper-button-next">ДАЛЕЕ</div>
                <div class="swiper-button-prev">НАЗАД</div>
			</div>
		</div>
	</section>-->

	<section class="section section_top-space-230">
	    <div class="container">
		    <div class="row os">
			    <div class="col-xs-12 col-sm-12 col-md-6">
			    	<h3 style="margin-top: 0;">Розыгрыш, который ждет тебя</h3>
			    	<p>Это второй раз когда мы разыгрываем сертификаты, и по этому решили увеличить сумму наших сертификатов и добавить еще 2 победителей.</p>
			    	<p>Данные сертификаты можно обменять на одну из услуг нашей студии, а именно на создание сайта или разработку чат-бот для вашего бизнеса.</p>
			    	<h3>Как проходит розыгрыш</h3>
			    	<p>Розыгрыш проходит через несколько дней, после чего в нашей <a href="https://vk.com/vucs_ru" target="_blank">группе Вконтакте</a> будет прямая трансляции, где мы и разыграем 3 сертификата по вашим билетам.</p>
			    	<a class="btn hero__btn" href="!#hello">Стать участником розыгрыша</a>
			    </div>
			    <div class="col-xs-12 col-sm-12 col-md-6">
			    	<iframe src="//vk.com/video_ext.php?oid=-30095205&id=456239018&hash=98532f080bd6efe1&hd=2" style="width: 100%;height: 50vh;" frameborder="0" allowfullscreen></iframe>
			    </div>
			</div>
		</div>
	</section>

	
	
	
	<section class="section section_top-space-230">
	    <div class="container">
		    <div class="row os">
			    <div class="col-xs-12 col-sm-12 col-md-9">
				    <div id="vk_comments"></div>
					<script type="text/javascript">
						VK.Widgets.Comments("vk_comments", {limit: 10, attach: false});
					</script>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-3">
					<div id="vk_groups"></div>
					<script type="text/javascript">
						VK.Widgets.Group("vk_groups", {mode: 1}, 30095205);
					</script>
				</div>
			</div>
		</div>
	</section>

	<title>Розыгрыш денежных сертификатов от Vucs Web Studio</title>
	
<?php } ?>
<?php
	$pageId = isset($_GET['id']) ? $_GET['id'] : '';
	$productId = isset($_GET['product_id']) ? $_GET['product_id'] : '';
	$id = val_string($pageId);
	$query = mysqli_query($GLOBALS['db'], "SELECT * FROM `$page` WHERE `id` = '$id'");
	if(mysqli_num_rows($query) > 0){
		$row = mysqli_fetch_assoc($query);
		$idpage = $row['id'];
	} else {
	}
	$titler = 'Модификации товаров';
?>
<?php
	if($pageId == 'add') {
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/ap/" data-pjax="content">Главная</a></li>
    <li class="breadcrumb-item"><a href="/ap/?page=<?php echo $page; ?>" data-pjax="content"><?php echo $titler; ?></a></li>
    <li class="breadcrumb-item active">Новое</li>
</ol>
<h1 class="h2">Добавление модификации</h1>
<div class="card">
	<div class="card-body">
		<div class="card">
			<div class="cart-body">
				<div class="card-body">
		            <h4 class="card-title"><a href="/ap/?page=products&id=<? echo productUid($productId)['id']; ?>" data-pjax="content"><? echo productUid($productId)['title']; ?></a></h4>
					<div class="row-info">
						<div class="str">
							<div>Арктикул</div>
							<div class="text">373</div>
						</div>
						<div class="str">
							<div>Цена</div>
							<div class="text">80</div>
						</div>
						<div class="str">
							<div>Категория</div>
							<div class="text">Бирки</div>
						</div>
						<p class="card-text"></p>
					</div>
				</div>
			</div>
		</div>
	    <div class="row">
	        <div class="col-lg-12 d-flex">
				<form class="flex ajax-edit" method="POST">
					<input type="hidden" name="add<?php echo $page; ?>" value="1">
					<input type="hidden" name="uid" value="<?php echo $productId; ?>">

	                <!--<div class="form-group">
	                    <label class="form-label">Показ на сайте</label>
		                <select class="form-control custom-select" name="show">
							<?
								foreach($show_arr as $key => $value) { 
									echo'<option value="'.$key.'">'.$value.'</option>';
								}
							?>
						</select>
	                </div>-->

	                <div class="form-group">
	                    <label class="form-label">Название</label>
	                    <input type="text" class="form-control" name="title" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">В наличии (шт.)</label>
	                    <input type="text" class="form-control" name="weight" required>
	                </div>

	                <!--<div class="form-group">
	                    <label class="form-label">Сайт [URL]</label>
	                    <input type="text" class="form-control" name="url" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Тип</label>
		                <select class="form-control custom-select" name="type">
							<?
								foreach($typeportfolio_arr as $key => $value) { 
									echo'<option value="'.$key.'">'.$value.'</option>';
								}
							?>
						</select>
	                </div>

					<label class="form-label">Теги</label>
					<div class="clean"></div>
					<div class="add-input">
						<div id="inputs">
						</div>
						<button class="btn btn-white btn-sm">Добавить тег&nbsp;&nbsp;<i class="fa fa-plus"></i></button>
						<br><br>
					</div>
	                <div class="form-group">
	                    <label class="form-label">Краткое описание</label>
	                    <textarea class="form-control" name="description"></textarea>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Описание</label>
	                    <textarea id="editor" class="form-control" name="content"></textarea>
	                </div>-->

					<label class="form-label">Изображения</label>
					<div class="clean"></div>
					<div class="upfiles">
						<button id="upload" type="button"><i class="fa fa-plus"></i></button>
						<div id="files" class="gallery-img">
						</div>
					</div>
					<div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="watermark" value="" id="watermark1" checked="">
                            <label class="custom-control-label" for="watermark1">
                                Водяные знаки
                            </label>
                        </div>
                    </div>
					<!--<p>Просмотров: <? /*echo $row['visits'];*/ ?></p>-->
                    <div class="result alert alert-dismissible bg-light border-0 fade show" role="alert"></div>
                    <div class="result_error alert bg-danger text-white border-0" role="alert"></div>
                    <!--<div class="result_success alert bg-success text-white border-0" role="alert"></div>-->
					<button class="btn btn-success" type="submit">Добавить</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?
	} else if($pageId) {
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/ap/" data-pjax="content">Главная</a></li>
    <li class="breadcrumb-item"><a href="/ap/?page=<?php echo $page; ?>" data-pjax="content"><?php echo $titler; ?></a></li>
    <li class="breadcrumb-item active"><?php echo $row['title']; ?></li>
</ol>
<h1 class="h2"><?php echo $row['title']; ?> &mdash; #<?php echo $pageId; ?></h1>

<div class="card">
	<div class="card-body">
		<div class="card">
			<div class="cart-body">
				<div class="card-body">
		            <h4 class="card-title"><a href="/ap/?page=products&id=<? echo productUid($productId)['id']; ?>" data-pjax="content"><? echo productUid($productId)['title']; ?></a></h4>
					<div class="row-info">
						<div class="str">
							<div>Арктикул</div>
							<div class="text"><? echo productUid($productId)['id']; ?>-<? echo $pageId['id']; ?></div>
						</div>
						<div class="str">
							<div>Цена</div>
							<div class="text"><? echo price(productUid($productId)['price']); ?></div>
						</div>
						<div class="str">
							<div>Категория</div>
							<div class="text"><? echo productsCategory(productUid($productId)['category'])['title']; ?></div>
						</div>
						<p class="card-text"></p>
					</div>
				</div>
			</div>
		</div>
	    <div class="row">
	        <div class="col-lg-12 d-flex">
				<form class="flex ajax" method="POST">
					<input name="edit<?php echo $page; ?>" type="hidden" value="1">
					<input name="id" type="hidden" value="<? echo $row['id']; ?>">

	                <!--<div class="form-group">
	                    <label class="form-label">Показ на сайте</label>
		                <select class="form-control custom-select" name="show">
							<?
								foreach($show_arr as $key => $value) { 
									if($key == $row['show']) {
										echo'<option value="'.$key.'" selected>'.$value.'</option>';
									} else {
										echo'<option value="'.$key.'">'.$value.'</option>';
									}
								}
							?>
						</select>
	                </div>-->

	                <div class="form-group">
	                    <label class="form-label">Название</label>
	                    <input type="text" class="form-control" name="title" value="<? echo $row['title']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">В наличии (шт.)</label>
	                    <input type="text" class="form-control" name="weight" value="<? echo $row['stock']; ?>" required>
	                </div>

	                <!--<div class="form-group">
	                    <label class="form-label">Краткое описание</label>
	                    <textarea class="form-control" name="description"><? echo $row['description']; ?></textarea>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Описание</label>
	                    <textarea id="editor" class="form-control" name="content"><? echo $row['content']; ?></textarea>
	                </div>-->

					<label class="form-label">Изображения</label>
					<div class="clean"></div>
					<div class="upfiles">
						<button id="upload" type="button"><i class="fa fa-plus"></i></button>
						<div id="files" class="gallery-img">
							<?php
								$queryim = mysqli_query($GLOBALS['db'], "SELECT * FROM `gallery` WHERE `type` = '$page' AND `uid` = '$id' ORDER BY id ASC");
								if(mysqli_num_rows($queryim) > 0) {
									while($rowim = mysqli_fetch_array($queryim)) {
										?>
											<div class="add-image <?php if($rowim['main']) {echo 'active';} ?>">
												<div class="img" style="background-image: url(/uploads/images/jpeg/<?php echo $rowim['image']; ?>-300x200.jpeg);"></div>
												<div class="panel">
													<div class="up"><i class="fa fa-angle-left"></i></div>
													<div class="down"><i class="fa fa-angle-right"></i></div>
													<div class="add-main"><i class="fa fa-photo"></i>Сделать главной</div>
													<input name="<?php echo $rowim['image']; ?>" class="input-main" type="hidden" value="<?php echo $rowim['main']; ?>">
													<a target="_blank" href="/uploads/images/jpeg/<?php echo $rowim['image']; ?>-1920x1080.jpeg"><i class="fa fa-link"></i>Посмотреть</a>
													<div class="del-image"><i class="fa fa-close"></i>Удалить</div>
												</div>
												<input name="image[]" type="hidden" value="<?php echo $rowim['image']; ?>"/>
											</div>
										<?
									}
								}
							?>
						</div>
					</div>
					<div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="watermark" value="" id="watermark1" checked="">
                            <label class="custom-control-label" for="watermark1">
                                Водяные знаки
                            </label>
                        </div>
                    </div>
					<p>Добавлено <? $date = strtotime($row['regdate']); echo date("d.m.y в H:i", $date); ?></p>
					<!--<p>Просмотров: <? /*echo $row['visits'];*/ ?></p>-->
                    <div class="result alert alert-dismissible bg-light border-0 fade show" role="alert"></div>
                    <div class="result_error alert bg-danger text-white border-0" role="alert"></div>
                    <!--<div class="result_success alert bg-success text-white border-0" role="alert"></div>-->
					<button class="btn btn-success" type="submit">Сохранить</button>
				</form>
	    	</div>
	    </div>
	</div>
	<div class="card-footer d-flex align-items-center">
		<div class="text-muted flex">Обновлено <?php echo showDate(strtotime($row['updatedate'])); ?></div>
		<div class="dropup">
			<a href="#" class="dropdown-toggle" data-caret="false" data-toggle="dropdown">
				<i class="material-icons">more_horiz</i>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<form class="ajax-confirm" data-title="Вы уверены?" data-text="Вы не сможете восстановить данный контент!" data-type="warning" data-text-confirm="Да, удалить" data-text-cancel="Нет, отменить">
					<input name="delete" type="hidden" value="delete">
					<input name="id" type="hidden" value="<? echo $row['id']; ?>">
					<input name="table" type="hidden" value="<? echo $page; ?>">
					<button class="dropdown-item ajax-confirm" type="submit">Удалить</button>
				</form>
			</div>
		</div>
	</div>
</div>
<?
	} else {
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/ap/" data-pjax="content">Главная</a></li>
    <li class="breadcrumb-item active"><?php echo $titler; ?></li>
</ol>
<div class="card">
	<div class="card-header d-flex align-items-center">
		<div class="flex">
			<h4 class="card-title"><?php echo $titler; ?></h4>
		</div>
	</div>
	<div class="card-body row pb-0">
		<div class="col-lg-12">
            <form class="search-form-ajax">
                <div class="d-flex flex-wrap2 align-items-center">
                    <div class="flex search-form search-form--light">
                    	<input type="hidden" name="search" value="<?php echo $page; ?>">
                        <input type="text" class="form-control search-input" name="text" placeholder="Поиск..." required="">
                        <button class="btn" type="button" role="button"><i class="material-icons"></i></button>
                    </div>
                </div>
            </form>
        </div>
	</div>
	<div class="card-body row search-results">
	</div>
	<div class="card-body row content-blocks">
		<?php
				    $arrP = array();
				    $pagenum = isset($_GET[$page]) ? $_GET[$page] : '';
				    $pagenum = val_string($pagenum);
				    $url_page = '/ap/?page='.$page.'&'.$page.'='.$currentPage;
				    $pagenum = preg_replace("/[^0-9]/", '', $pagenum);
				    $num = 9;  
				    $query1 = mysqli_query($GLOBALS['db'], "SELECT (`id`) FROM `$page`");
				    $posts = mysqli_num_rows($query1);  
				    $total = intval(($posts - 1) / $num) + 1;  
				    $pagenum = intval($pagenum);  
				    if(empty($pagenum) or $pagenum < 0) $pagenum = 1;  
				    if($pagenum > $total) $pagenum = $total;  
				    $start = $pagenum * $num - $num;  
				    $query2 = mysqli_query($GLOBALS['db'], "SELECT * FROM `$page` ORDER BY id DESC LIMIT $start, $num");
				    //$arr = mysqli_fetch_array($query2);
				    while ($arr[] = mysqli_fetch_array($query2)); 

				    if($posts > 0){  
				        for($in = 0; $in < $num; $in++)  
				        {  
				            $idstr = isset($arr[$in]['id']) ? $arr[$in]['id'] : 0;
				            if($idstr > 0) {  
		?>
		    <div class="cards col-sm-12 col-md-6 col-lg-4">
		        <div class="card">
		        	<div class="cart-body">
						<a data-pjax="content" href="/ap/?page=<?php echo $page; ?>&id=<?php echo $arr[$in]['id']; ?>&product_id=<?php echo $arr[$in]['uid']; ?>" class="img">
							<?php echo gallery($page, $idstr, 0, 1, 'small', '', false, true); ?>
						</a>
						<div class="card-body">
				            <h4 class="card-title"><a href="/ap/?page=products&id=<? echo productUid($arr[$in]['uid'])['id']; ?>" data-pjax="content"><? echo productUid($arr[$in]['uid'])['title']; ?></a></h4>
							<div class="row-info">
								<div class="str">
									<div>Цвет</div>
									<div class="text"><?php echo $arr[$in]['title']; ?></div>
								</div>
								<div class="str">
									<div>ID</div>
									<div class="text"><?php echo $arr[$in]['id']; ?></div>
								</div>
							</div>
						</div>
		        	</div>
					<div class="card-footer d-flex align-items-center">
						<div class="text-muted flex">Добавлено <?php echo showDate(strtotime($arr[$in]['regdate'])); ?></div>
						<div class="dropup">
							<a href="#" class="dropdown-toggle" data-caret="false" data-toggle="dropdown">
								<i class="material-icons">more_horiz</i>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a class="dropdown-item" data-pjax="content" href="/ap/?page=<?php echo $page; ?>&id=<?php echo $arr[$in]['id']; ?>&product_id=<?php echo $arr[$in]['uid']; ?>">Редактировать</a>
							</div>
						</div>
					</div>
		        </div>
		    </div>
		<?php
		            }
		        }
		    #echo '</div>';
		    } else {
				?>
				    <div class="col-lg-12">
				        Нет данных
				    </div>
				<?
		    }
		?>
	</div>
</div>
<?php  
	//start nav
    $pervpage = '';
    $nextpage = '';
    $pagenum1left = '';
    $pagenum2left = '';
    $pagenum1right = '';
    $pagenum2right = '';
    // Проверяем нужны ли стрелки назад  
    if ($pagenum != 1) $pervpage = '
		<li class="page-item">
			<a class="page-link" href="'.$url_page.'1" aria-label="Назад" data-pjax="content">
				<span aria-hidden="true" class="material-icons">first_page</span>
				<span class="sr-only">First</span>
			</a>
		</li>

		<li class="page-item">
			<a class="page-link" href="'.$url_page.''. ($pagenum - 1) .'" aria-label="Назад" data-pjax="content">
				<span aria-hidden="true" class="material-icons">chevron_left</span>
				<span class="sr-only">Prev</span>
			</a>
		</li>
    ';  
    // Проверяем нужны ли стрелки вперед  
    if ($pagenum != $total) $nextpage = '
		<li class="page-item">
			<a class="page-link" href="'.$url_page.''. ($pagenum + 1) .'" aria-label="Вперед" data-pjax="content">
				<span class="sr-only">Next</span>
				<span aria-hidden="true" class="material-icons">chevron_right</span>
			</a>
		</li>

		<li class="page-item">
			<a class="page-link" href="'.$url_page.''.$total. '" aria-label="Вперед" data-pjax="content">
				<span class="sr-only">Last</span>
				<span aria-hidden="true" class="material-icons">last_page</span>
			</a>
		</li>
    ';  

    // Находим две ближайшие станицы с обоих краев, если они есть  
    if($pagenum - 2 > 0) $pagenum2left = '
        <li class="page-item">
	      <a class="page-link" href="'.$url_page.''. ($pagenum - 2) .'" aria-label="2" data-pjax="content">
	        <span>'. ($pagenum - 2) .'</span>
	      </a>
		</li>
	';  
    if($pagenum - 1 > 0) $pagenum1left = '
		<li class="page-item">
			<a class="page-link" href="'.$url_page.''. ($pagenum - 1) .'" aria-label="2" data-pjax="content">
				<span>'. ($pagenum - 1) .'</span>
			</a>
		</li>
    ';  
    if($pagenum + 2 <= $total) $pagenum2right = '
		<li class="page-item">
			<a class="page-link" href="'.$url_page.''. ($pagenum + 2) .'" aria-label="2" data-pjax="content">
				<span>'. ($pagenum + 2) .'</span>
			</a>
		</li>
    ';  
    if($pagenum + 1 <= $total) $pagenum1right = '
		<li class="page-item">
			<a class="page-link" href="'.$url_page.''. ($pagenum + 1) .'" aria-label="2" data-pjax="content">
				<span>'. ($pagenum + 1) .'</span>
			</a>
		</li>
    '; 

    // Вывод меню  
    if($num < $posts) {
        ?>
			<nav aria-label="Page navigation example" class="flex justify-content-center">
				<ul class="pagination pagination-sm">
                    <?
                    echo $pervpage.$pagenum2left.$pagenum1left.'
                    <li class="page-item active">
						<a class="page-link" href="#" aria-label="1" onclick="return false;">
							<span>'.$pagenum.'</span>
						</a>
					</li>
					'.$pagenum1right.$pagenum2right.$nextpage;  
                    ?>
            	</ul>
        	</nav>
        <?
    }
    //end nav
?>


<?
	}
?>
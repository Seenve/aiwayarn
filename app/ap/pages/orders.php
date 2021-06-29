<?php
	$pageId = isset($_GET['id']) ? $_GET['id'] : '';
	$id = val_string($pageId);
	$query = mysqli_query($GLOBALS['db'], "SELECT * FROM `$page` WHERE `id` = '$id'");
	if(mysqli_num_rows($query) > 0){
		$row = mysqli_fetch_assoc($query);
		$idpage = $row['id'];
		//$titler = 'Новости &mdash; '.$row['title'];
	} else {
		//$titler = 'Новости';
	}
	$titler = 'Заказы';

	$sort = htmlspecialchars($_GET['sort']);
	$sort = preg_replace("/[^0-9]/", '', $sort);

	function user_people(){
		return false;
	}
	function category_products_arr () {
		return false;
	}

?>
<div class="card">
	<div class="card-body">
		<form class="filter-realty" data-pjax="content" method="GET" action="/ap/">
			<input type="hidden" name="page" value="orders">
			<input type="hidden" name="num" value="1">
				<select id="custom-select1" class="form-control custom-select" name="sort">
					<option value="0" <? if($_GET['sort'] == 0) {echo "selected";} ?>>По дате</option>
					<option value="1" <? if($_GET['sort'] == 1) {echo "selected";} ?>>По рейтингу</option>
					<option value="2" <? if($_GET['sort'] == 2) {echo "selected";} ?>>От дешевых к дорогим</option>
					<option value="3" <? if($_GET['sort'] == 3) {echo "selected";} ?>>От дорогих к дешевым</option>
					<option value="4" <? if($_GET['sort'] == 4) {echo "selected";} ?>>По статусу</option>
					<option value="5" <? if($_GET['sort'] == 5) {echo "selected";} ?>>По передан сайту</option>
					<option value="6" <? if($_GET['sort'] == 6) {echo "selected";} ?>>По не передан сайту</option>
				</select>
				<br><br>
				<button class="btn btn-primary" type="submit">Сортировать</button>
		</form>
	</div>
</div>
				<form class="flex ajax" method="POST">
					<input name="edit<?php echo $page; ?>" type="hidden" value="1">
					<input name="id" type="hidden" value="<? echo $row['id']; ?>">
					<input name="chat_id" type="hidden" value="<? echo user_people($row['user_id'])['0']['uid']; ?>">

<?php
	if ($sort == 1) {
		$sort_txt = 'ORDER BY `rating` DESC';
	} else if ($sort == 2) {
		$sort_txt = 'ORDER BY `money` ASC';
	} else if ($sort == 3) {
		$sort_txt = 'ORDER BY `money` DESC';
	} else if ($sort == 4) {
		$sort_txt = 'ORDER BY `status` DESC';
	} else if ($sort == 5) {
		$sort_txt = 'ORDER BY `sended` DESC';
	} else if ($sort == 6) {
		$sort_txt = 'ORDER BY `sended` ASC';
	} else {
		$sort_txt = 'ORDER BY `regdate` DESC';
	}
?>
<?php
	if($pageId == 'add') {
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/ap/" data-pjax="content">Главная</a></li>
    <li class="breadcrumb-item"><a href="/ap/?page=<?php echo $page; ?>" data-pjax="content"><?php echo $titler; ?></a></li>
    <li class="breadcrumb-item active">Новое</li>
</ol>
<div class="card">
	<div class="card-body">
	    <div class="row">
	        <div class="col-lg-12 d-flex">
				<form class="flex ajax" method="POST">
					<input type="hidden" name="add<?php echo $page; ?>" value="1">
					<input name="id" type="hidden" value="<? echo $row['id']; ?>">

	                <div class="form-group">
	                    <label class="form-label">Название</label>
	                    <input type="text" class="form-control" name="title" value="<? echo $row['title']; ?>" required>
	                </div>

					<div class="form-group">
					    <label class="form-label" for="custom-select1">Категория</label>
					    <select id="custom-select1" class="form-control custom-select" name="category">
							<?
								foreach(category_products_arr() as $key => $value) { 
									echo'<option value="'.$value['id'].'">'.$value['title'].'</option>';
								}
							?>
					    </select>
					</div>

					<div class="form-group">
					    <label class="form-label" for="custom-select1">Бренд</label>
					    <select id="custom-select1" class="form-control custom-select" name="type">
							<?
								foreach(productsBrands() as $key => $value) { 
									echo'<option value="'.$key.'">'.$value.'</option>';
								}
							?>
					    </select>
					</div>

	                <div class="form-group">
	                    <label class="form-label">Стоимость в руб.</label>
	                    <input type="number" class="form-control" name="price" required>
	                </div>

					<!--<label class="form-label">Теги</label>
					<div class="clean"></div>
					<div class="add-input">
						<div id="inputs">
						</div>
						<button class="btn btn-white btn-sm">Добавить тег&nbsp;&nbsp;<i class="fa fa-plus"></i></button>
						<br><br>
					</div>-->
	                <div class="form-group">
	                    <label class="form-label">Краткое описание</label>
	                    <textarea class="form-control" name="description"><? echo $row['description']; ?></textarea>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Описание</label>
	                    <textarea id="editor" class="form-control" name="content"><? echo $row['content']; ?></textarea>
	                </div>

					<label class="form-label">Изображения</label>
					<div class="clean"></div>
					<div class="upfiles">
						<button id="upload" type="button"><i class="fa fa-plus"></i></button>
						<div id="files" class="gallery-img">
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
    <li class="breadcrumb-item active">Заказ #<?php echo $row['id']; ?></li>
</ol>
<h1 class="h2">Заказ &mdash; #<?php echo $pageId; ?></h1>
<div class="card">
	<div class="card-body">
	    <div class="row">
	        <div class="col-lg-12 d-flex">
				<form class="flex ajax" method="POST">
					<input name="edit<?php echo $page; ?>" type="hidden" value="1">
					<input name="id" type="hidden" value="<? echo $row['id']; ?>">
					<input name="chat_id" type="hidden" value="<? echo user_people($row['user_id'])['0']['uid']; ?>">

					<div class="form-group">
					    <label class="form-label" for="custom-select1">Статус заказа</label>
					    <select id="custom-select1" class="form-control custom-select" name="status">
							<?
								foreach($arr_status as $key => $value) { 
									if($key == $row['status']) {
										echo'<option value="'.$key.'" selected>'.$value.'</option>';
									} else {
										echo'<option value="'.$key.'">'.$value.'</option>';
									}
								}
							?>
					    </select>
					</div>

					<div class="form-group">
					    <label class="form-label" for="custom-select1">Дроп</label>
					    <select id="custom-select1" class="form-control custom-select" name="status2">
							<?
								foreach($arr_status2 as $key => $value) { 
									if($key == $row['sended']) {
										echo'<option value="'.$key.'" selected>'.$value.'</option>';
									} else {
										echo'<option value="'.$key.'">'.$value.'</option>';
									}
								}
							?>
					    </select>
					</div>

	                <div class="form-group">
	                    <label class="form-label">Цена</label>
	                    <input type="number" class="form-control" name="price" value="<? echo $row['money']; ?>" required disabled>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Цена доставки</label>
	                    <input type="number" class="form-control" name="price" value="<? echo $row['money_transfer']; ?>" required disabled>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Наценка (руб.)</label>
	                    <input type="number" class="form-control" name="money_sale" value="<? echo $row['money_sale']; ?>" required>
	                </div>

					<!--<label class="form-label">Теги</label>
					<div class="clean"></div>
					<div class="add-input">
						<div id="inputs">
							<?php
								$tags_arr = explode(", ", $row['tags']);
								foreach($tags_arr as $key_tag => $value_tag) {
									echo '<div class="ainput"><input class="form-control" type="text" name="input[]" value="'.$value_tag.'"><div class="del-input"><i class="fal fa-times"></i></div></div>';
								}
							?>
						</div>
						<button class="btn btn-white btn-sm">Добавить тег&nbsp;&nbsp;<i class="fa fa-plus"></i></button>
						<br><br>
					</div>-->
	                <div class="form-group">
	                    <label class="form-label">Ф.И.О</label>
	                    <textarea class="form-control" disabled><? echo $row['fio']; ?></textarea>
	                </div>
	                <div class="form-group">
	                    <label class="form-label">E-mail</label>
	                    <textarea class="form-control" disabled><? echo $row['email']; ?></textarea>
	                </div>
	                <div class="form-group">
	                    <label class="form-label">Телефон</label>
	                    <textarea class="form-control" disabled><? echo $row['phone']; ?></textarea>
	                </div>
	                <div class="form-group">
	                    <label class="form-label">Город</label>
	                    <textarea class="form-control" disabled><? echo $row['city']; ?></textarea>
	                </div>
	                <div class="form-group">
	                    <label class="form-label">Индекс</label>
	                    <textarea class="form-control" disabled><? echo $row['index']; ?></textarea>
	                </div>
	                <div class="form-group">
	                    <label class="form-label">Адрес</label>
	                    <textarea class="form-control" disabled><? echo $row['address']; ?></textarea>
	                </div>
	                <div class="form-group">
	                    <label class="form-label">Комментарий к заказу</label>
	                    <textarea class="form-control" name="description" disabled><? echo $row['comment']; ?></textarea>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Товары</label>
	                    <div class="row">

	                    		<?php
	$query3 = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `order` = '$pageId'");
	while($row_order = mysqli_fetch_assoc($query3)) {
?>
<div class="cards col-lg-4">
    <div class="card">
    	<div class="cart-body">
			<a data-pjax="content" href="/ap/?page=products&id=<?php echo $row_order['product_id']; ?>" class="img">
				<?php
					if(gallery_arr('products', $row_order['product_id'])['0']['image']) {
						?>
							<img src="<?php echo '/uploads/'.gallery_arr('products', $row_order['product_id'])['0']['image']; ?>" alt="<?php echo products_id($row_order['product_id'])['title']; ?>">
						<?
					} else {
						?>
							<img src="/ap/assets/images/no-image.svg" alt="Нет изображения">
						<?
					}
				?>
			</a>
			<div class="card-body">
	            <h4 class="card-title"><a data-pjax="content" href="/ap/?page=products&id=<?php echo $row_order['product_id']; ?>"><?php echo products_id($row_order['product_id'])['title']; ?></a></h4>
				<div class="row-info">
					<div class="str">
						<div>ID</div>
						<div class="text"><?php echo $row_order['product_id']; ?></div>
					</div>
					<p class="card-text"><?php echo products_id($row_order['product_id'])['description']; ?></p>
				</div>
			</div>
    	</div>
		<!--<div class="card-footer d-flex align-items-center">
			<div class="text-muted flex">Добавлено <?php echo showDate(strtotime($arr[$in]['regdate'])); ?></div>
			<div class="dropup">
				<a href="#" class="dropdown-toggle" data-caret="false" data-toggle="dropdown">
					<i class="material-icons">more_horiz</i>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<a class="dropdown-item" data-pjax="content" href="/ap/?page=products&id=<?php echo $row_order['product_id']; ?>">Редактировать</a>
				</div>
			</div>
		</div>-->
    </div>
</div>
<?
	}
	                    		?>

	                    </div>
	                </div>

					<!--<label class="form-label">Изображения</label>
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
												<div class="img" style="background-image: url(/uploads/small/jpg/<?php echo $rowim['image']; ?>);"></div>
												<div class="panel">
													<div class="up"><i class="fa fa-angle-left"></i></div>
													<div class="down"><i class="fa fa-angle-right"></i></div>
													<div class="add-main"><i class="fa fa-photo"></i>Сделать главной</div>
													<input name="<?php echo $rowim['image']; ?>" class="input-main" type="hidden" value="<?php echo $rowim['main']; ?>">
													<a target="_blank" href="/uploads/middle/jpg/<?php echo $rowim['image']; ?>"><i class="fa fa-link"></i>Посмотреть</a>
													<div class="del-image"><i class="fa fa-close"></i>Удалить</div>
												</div>
												<input name="image[]" type="hidden" value="<?php echo $rowim['image']; ?>"/>
											</div>
										<?
									}
								}
							?>
						</div>
					</div>-->
					<p>Добавлен <? $date = strtotime($row['regdate']); echo date("d.m.y в H:i", $date); ?></p>
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
		<div class="text-muted flex">Обновлено <?php echo showDate(strtotime($row['update_date'])); ?></div>
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
		<!--<div class="dropdown">
			<a href="/ap/?page=<?php echo $page; ?>&id=add" data-pjax="content" data-caret="false">
				<i class="material-icons">add</i>
			</a>
		</div>-->
	</div>
	<div class="card-body row">
		<?php
				    $arrP = array();
				    $pagenum = isset($_GET[$page]) ? $_GET[$page] : '';
				    $pagenum = val_string($pagenum);
				    $url_page = '/ap/?page='.$page.'&'.$page.'='.$currentPage;
				    $url_page = $_SERVER['REQUEST_URI'].'&'.$page.'=';
				    $pagenum = preg_replace("/[^0-9]/", '', $pagenum);
				    $num = 9;  
				    $query1 = mysqli_query($GLOBALS['db'], "SELECT (`id`) FROM `$page`");
				    $posts = mysqli_num_rows($query1);  
				    $total = intval(($posts - 1) / $num) + 1;  
				    $pagenum = intval($pagenum);  
				    if(empty($pagenum) or $pagenum < 0) $pagenum = 1;  
				    if($pagenum > $total) $pagenum = $total;  
				    $start = $pagenum * $num - $num;  
				    $query2 = mysqli_query($GLOBALS['db'], "SELECT * FROM `$page` {$sort_txt} LIMIT $start, $num");
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

						<div class="card-body">
				            <h4 class="card-title">
				            <a data-pjax="content" href="/ap/?page=<?php echo $page; ?>&id=<?php echo $arr[$in]['id']; ?>">Заказ #<?php echo $idstr; ?></a></h4>
							<div class="row-info">
								<div class="str">
									<div>ID</div>
									<div class="text"><?php echo $arr[$in]['id']; ?></div>
								</div>
								<div class="str">
									<div>Цена</div>
									<div class="text"><?php echo $arr[$in]['money']; ?> &#8381;</div>
								</div>
								<div class="str">
									<div>Цена доставки</div>
									<div class="text"><?php echo $arr[$in]['money_transfer']; ?> &#8381;</div>
								</div>
								<div class="str">
									<div>Наценка</div>
									<div class="text"><?php echo $arr[$in]['money_sale']; ?> &#8381;</div>
								</div>
								<p class="card-text">Статус: <b><?php echo order_status($arr[$in]['status']); ?></b>
									<br>
									Дроп: <b><?php echo $arr_status2[$arr[$in]['sended']]; ?></b>
									<!--<br>
									Комментарий к заказу: <?php echo $arr[$in]['comment']; ?>-->
								</p>
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
								<a class="dropdown-item" data-pjax="content" href="/ap/?page=<?php echo $page; ?>&id=<?php echo $arr[$in]['id']; ?>">Редактировать</a>
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
		<!--<form data-pjax="content" method="GET" action="/ap/">
			<input type="hidden" name="page" value="orders">
			<input type="hidden" name="num" value="1">
            <div class="form-group">
				<select id="custom-select1" class="form-control custom-select" name="sort">
					<option value="0" <? if($_GET['sort'] == 0) {echo "selected";} ?>>По дате</option>
					<option value="1" <? if($_GET['sort'] == 1) {echo "selected";} ?>>По рейтингу</option>
					<option value="2" <? if($_GET['sort'] == 2) {echo "selected";} ?>>От дешевых к дорогим</option>
					<option value="3" <? if($_GET['sort'] == 3) {echo "selected";} ?>>От дорогих к дешевым</option>
					<option value="4" <? if($_GET['sort'] == 4) {echo "selected";} ?>>По статусу</option>
					<option value="5" <? if($_GET['sort'] == 5) {echo "selected";} ?>>По передан сайту</option>
					<option value="6" <? if($_GET['sort'] == 6) {echo "selected";} ?>>По не передан сайту</option>
				</select>
            </div>
            <div class="form-group">
            	&nbsp;
                <button class="btn btn-primary" type="submit">Сортировать</button>
            </div>
		</form>-->
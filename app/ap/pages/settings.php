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
	$titler = 'Настройка сайта';
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
				<form class="flex ajax-edit" method="POST">
					<input type="hidden" name="add<?php echo $page; ?>" value="1">

	                <div class="form-group">
	                    <label class="form-label">Название города</label>
	                    <input type="text" class="form-control" name="city_name" value="<? echo $row['city_name']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Заголовок</label>
	                    <input type="text" class="form-control" name="title" value="<? echo $row['title']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Баннер H1</label>
	                    <input type="text" class="form-control" name="banner_1" value="<? echo $row['banner_1']; ?>" required>
	                </div>
	                <div class="form-group">
	                    <label class="form-label">Баннер H2</label>
	                    <input type="text" class="form-control" name="banner_2" value="<? echo $row['banner_2']; ?>" required>
	                </div>
	                <div class="form-group">
	                    <label class="form-label">Баннер нижний текст</label>
	                    <input type="text" class="form-control" name="banner_3" value="<? echo $row['banner_3']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Описание</label>
	                    <textarea class="form-control" name="description"><? echo $row['description']; ?></textarea>
	                </div>

					<label class="form-label">Ключевые слова</label>
					<div class="clean"></div>
					<div class="add-input">
						<div id="inputs">
							<?php
								$tags_arr = explode(", ", $row['keywords']);
								foreach($tags_arr as $key_tag => $value_tag) {
									echo '<div class="ainput"><input class="form-control" type="text" name="input[]" value="'.$value_tag.'"><div class="del-input"><i class="fal fa-times"></i></div></div>';
								}
							?>
						</div>
						<button class="btn btn-white btn-sm">Добавить&nbsp;&nbsp;<i class="fa fa-plus"></i></button>
						<br><br>
					</div>

	                <div class="form-group">
	                    <label class="form-label">Адрес</label>
	                    <textarea class="form-control" name="address"><? echo $row['address']; ?></textarea>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Стоимость доставки (от)</label>
	                    <input type="number" class="form-control" name="delivery" value="<? echo $row['delivery']; ?>" required>
	                </div>
					
	                <div class="form-group">
	                    <label class="form-label">Ссылки на соц.сети</label>
	                    <div class="row">
	                    	<div class="col-md-3">
	                    		<input type="text" class="form-control" name="soc_1" value="<? echo $row['soc_1']; ?>" placeholder="Вконтакте" required>
	                    	</div>
	                    	<div class="col-md-3">
	                    		<input type="text" class="form-control" name="soc_2" value="<? echo $row['soc_2']; ?>" placeholder="Facebook" required>
	                    	</div>
	                    	<div class="col-md-3">
	                    		<input type="text" class="form-control" name="soc_3" value="<? echo $row['soc_3']; ?>" placeholder="Instagram" required>
	                    	</div>
	                    	<div class="col-md-3">
	                    		<input type="text" class="form-control" name="soc_4" value="<? echo $row['soc_4']; ?>" placeholder="YouTube" required>
	                    	</div>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Часы работы</label>
	                    <textarea class="form-control" name="jobtime"><? echo $row['jobtime']; ?></textarea>
	                </div>

	                <!--<div class="form-group">
	                    <label class="form-label">Адрес карты</label>
	                    <textarea class="form-control" name="map"><? echo $row['map']; ?></textarea>
	                </div>-->

	                <div class="form-group">
	                    <label class="form-label">Карта (lat)</label>
	                    <input type="text" class="form-control" name="lat" value="<? echo $row['lat']; ?>" required>
	                </div>
	                <div class="form-group">
	                    <label class="form-label">Карта (lng)</label>
	                    <input type="text" class="form-control" name="lng" value="<? echo $row['lng']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Телефон</label>
	                    <input type="phone" class="form-control" name="phone" value="<? echo $row['phone']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Эл.почта</label>
	                    <input type="email" class="form-control" name="email" value="<? echo $row['email']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Телефон 2</label>
	                    <input type="phone" class="form-control" name="phone2" value="<? echo $row['phone2']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Эл.почта 2</label>
	                    <input type="email" class="form-control" name="email2" value="<? echo $row['email2']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Логин (Мой склад)</label>
	                    <input type="text" class="form-control" name="login_product_moysklad" value="<? echo $row['login_product_moysklad']; ?>">
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Пароль (Мой склад)</label>
	                    <input type="text" class="form-control" name="password_product_moysklad" value="<? echo $row['password_product_moysklad']; ?>">
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
	    <div class="row">
	        <div class="col-lg-12 d-flex">
				<form class="flex ajax" method="POST">
					<input name="edit<?php echo $page; ?>" type="hidden" value="1">
					<input name="id" type="hidden" value="<? echo $row['id']; ?>">

	                <div class="form-group">
	                    <label class="form-label">Название города</label>
	                    <input type="text" class="form-control" name="city_name" value="<? echo $row['city_name']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Заголовок</label>
	                    <input type="text" class="form-control" name="title" value="<? echo $row['title']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Баннер H1</label>
	                    <input type="text" class="form-control" name="banner_1" value="<? echo $row['banner_1']; ?>" required>
	                </div>
	                <div class="form-group">
	                    <label class="form-label">Баннер H2</label>
	                    <input type="text" class="form-control" name="banner_2" value="<? echo $row['banner_2']; ?>" required>
	                </div>
	                <div class="form-group">
	                    <label class="form-label">Баннер нижний текст</label>
	                    <input type="text" class="form-control" name="banner_3" value="<? echo $row['banner_3']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Описание</label>
	                    <textarea class="form-control" name="description"><? echo $row['description']; ?></textarea>
	                </div>

					<label class="form-label">Ключевые слова</label>
					<div class="clean"></div>
					<div class="add-input">
						<div id="inputs">
							<?php
								$tags_arr = explode(", ", $row['keywords']);
								foreach($tags_arr as $key_tag => $value_tag) {
									echo '<div class="ainput"><input class="form-control" type="text" name="input[]" value="'.$value_tag.'"><div class="del-input"><i class="fal fa-times"></i></div></div>';
								}
							?>
						</div>
						<button class="btn btn-white btn-sm">Добавить&nbsp;&nbsp;<i class="fa fa-plus"></i></button>
						<br><br>
					</div>

	                <div class="form-group">
	                    <label class="form-label">Адрес</label>
	                    <textarea class="form-control" name="address"><? echo $row['address']; ?></textarea>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Стоимость доставки (от)</label>
	                    <input type="number" class="form-control" name="delivery" value="<? echo $row['delivery']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Ссылки на соц.сети</label>
	                    <div class="row">
	                    	<div class="col-md-3">
	                    		<input type="text" class="form-control" name="soc_1" value="<? echo $row['soc_1']; ?>" placeholder="Вконтакте" required>
	                    	</div>
	                    	<div class="col-md-3">
	                    		<input type="text" class="form-control" name="soc_2" value="<? echo $row['soc_2']; ?>" placeholder="Facebook" required>
	                    	</div>
	                    	<div class="col-md-3">
	                    		<input type="text" class="form-control" name="soc_3" value="<? echo $row['soc_3']; ?>" placeholder="Instagram" required>
	                    	</div>
	                    	<div class="col-md-3">
	                    		<input type="text" class="form-control" name="soc_4" value="<? echo $row['soc_4']; ?>" placeholder="YouTube" required>
	                    	</div>
	                    </div>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Часы работы</label>
	                    <textarea class="form-control" name="jobtime"><? echo $row['jobtime']; ?></textarea>
	                </div>

	                <!--<div class="form-group">
	                    <label class="form-label">Адрес карты</label>
	                    <textarea class="form-control" name="map"><? echo $row['map']; ?></textarea>
	                </div>-->

	                <div class="form-group">
	                    <label class="form-label">Карта (lat)</label>
	                    <input type="text" class="form-control" name="lat" value="<? echo $row['lat']; ?>" required>
	                </div>
	                <div class="form-group">
	                    <label class="form-label">Карта (lng)</label>
	                    <input type="text" class="form-control" name="lng" value="<? echo $row['lng']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Телефон</label>
	                    <input type="phone" class="form-control" name="phone" value="<? echo $row['phone']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Эл.почта</label>
	                    <input type="email" class="form-control" name="email" value="<? echo $row['email']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Телефон 2</label>
	                    <input type="phone" class="form-control" name="phone2" value="<? echo $row['phone2']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Эл.почта 2</label>
	                    <input type="email" class="form-control" name="email2" value="<? echo $row['email2']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Логин (Мой склад)</label>
	                    <input type="text" class="form-control" name="login_product_moysklad" value="<? echo $row['login_product_moysklad']; ?>">
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Пароль (Мой склад)</label>
	                    <input type="text" class="form-control" name="password_product_moysklad" value="<? echo $row['password_product_moysklad']; ?>">
	                </div>

					<p>Добавлено <? $date = strtotime($row['reg_date']); echo date("d.m.y в H:i", $date); ?></p>
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
		<div class="dropdown">
			<a href="/ap/?page=<?php echo $page; ?>&id=add" data-pjax="content" data-caret="false">
				<i class="material-icons">add</i>
			</a>
		</div>
	</div>
	<!--<div class="card-body row pb-0">
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
	</div>-->
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
						<div class="card-body">
				            <h4 class="card-title"><a data-pjax="content" href="/ap/?page=<? echo $page; ?>&id=<?php echo $arr[$in]['id']; ?>"><?php echo $arr[$in]['city_name']; ?></a></h4>
							<!--<div class="row-info">
								<div class="str">
									<div>ID</div>
									<div class="text"><?php echo $arr[$in]['id']; ?></div>
								</div>
								<p class="card-text"><?php echo $arr[$in]['description']; ?></p>
							</div>-->
						</div>
		        	</div>
					<div class="card-footer d-flex align-items-center">
						<div class="text-muted flex">Добавлено <?php echo showDate(strtotime($arr[$in]['reg_date'])); ?></div>
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
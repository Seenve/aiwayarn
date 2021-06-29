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
	$titler = 'Товары';
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
	                    <label class="form-label">Город</label>
		                <select class="form-control custom-select" name="city_id">
		                	<!--<option value="0">Везде</option>-->
							<?
								foreach(settings() as $key => $value) { 
									if($value['id'] == $row['city_id']) {
										echo'<option value="'.$value['id'].'" selected>'.$value['city_name'].'</option>';
									} else {
										echo'<option value="'.$value['id'].'">'.$value['city_name'].'</option>';
									}
								}
							?>
						</select>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Страна производителя</label>
	                    <input type="text" class="form-control" name="prod" value="<? echo $row['prod']; ?>">
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Ед. измерения</label>
		                <select class="form-control custom-select" name="type">
							<?
								foreach($arrTypeProduct as $key => $value) { 
									if($key == $row['type']) {
										echo'<option value="'.$key.'" selected>'.$value.'</option>';
									} else {
										echo'<option value="'.$key.'">'.$value.'</option>';
									}
								}
							?>
						</select>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">В наличии (шт.)</label>
	                    <input type="number" class="form-control" name="stock" value="<? echo $row['stock']; ?>">
	                </div>

					<div class="form-group">
					    <label class="form-label" for="custom-select1">Категория</label>
					    <select id="custom-select1" class="form-control custom-select" name="category">
					        <?php
					            function cat_showNested2($parentID, $nums) {
					                $result3 = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '$parentID' ORDER BY `rang`");
					                $numRows += mysqli_num_rows($result3);
					                $nums += $numRows;

						            $probel = "";
									for ($i = 1; $i <= $nums; $i++) {
									    $probel .= "&nbsp;&nbsp;&nbsp;";
									}
					                
					                if ($numRows > 0) {
					                        while($row3 = mysqli_fetch_assoc($result3)) {
					                            ?>
					                            	<option value="<?php echo $row3['id']; ?>"><?php echo $probel; ?><?php echo $row3['title']; ?></option>
					                            <?
					                           	cat_showNested2($row3['id'], $nums);
					                        }
					                }
					            }
					            
					            $q_cat = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '0' ORDER BY `rang`");
			                    while($row2 = mysqli_fetch_assoc($q_cat)) {
			                        ?>
			                        <option value="<?php echo $row2['id']; ?>"><?php echo $row2['title']; ?></option>
			                        <?
			                        cat_showNested2($row2['id'], 0);
			                    }
					        ?>
					    </select>
					</div>

	                <div class="form-group">
	                    <label class="form-label">Вывод на главной</label>
		                <select class="form-control custom-select" name="favorite">
							<?
								foreach($show_arr as $key => $value) { 
									if($key == $row['favorite']) {
										echo'<option value="'.$key.'" selected>'.$value.'</option>';
									} else {
										echo'<option value="'.$key.'">'.$value.'</option>';
									}
								}
							?>
						</select>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Цена (в руб.)</label>
	                    <input type="number" class="form-control" name="price" step="0.01" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Старая цена (в руб.)</label>
	                    <input type="number" class="form-control" name="old_price" step="0.01" required>
	                </div>

					<label class="form-label">Ключевые слова</label>
					<div class="clean"></div>
					<div class="add-input">
						<div id="inputs">
						</div>
						<button class="btn btn-white btn-sm">Добавить &nbsp;&nbsp;<i class="fa fa-plus"></i></button>
						<br><br>
					</div>

					<label class="form-label">Характеристики</label>
					<div class="clean"></div>
					<div class="add-character" data-num="0">
						<div id="characters">
						</div>
						<button class="btn btn-white btn-sm">Добавить &nbsp;&nbsp;<i class="fa fa-plus"></i></button>
						<br><br>
					</div>

	                <div class="form-group">
	                    <label class="form-label">Вес (в гр.)</label>
	                    <input type="number" class="form-control" name="weight" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Краткое описание</label>
	                    <textarea class="form-control" name="description"><? echo $row['description']; ?></textarea>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Описание</label>
	                    <textarea id="editor" class="form-control" name="content"><? echo $row['content']; ?></textarea>
	                </div>

	                <!--<div class="form-group">
	                    <label class="form-label">Особенности</label>
	                    <textarea id="editor1" class="form-control ckeditor" name="content2"><? echo $row['content2']; ?></textarea>
	                </div>-->

	                <!--<div class="form-group">
	                    <label class="form-label">Документация</label>
	                    <textarea id="editor2" class="form-control ckeditor" name="content3"><? echo $row['content3']; ?></textarea>
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
	    <div class="row">
	        <div class="col-lg-12 d-flex">
				<form class="flex ajax" method="POST">
					<input name="edit<?php echo $page; ?>" type="hidden" value="1">
					<input name="id" type="hidden" value="<? echo $row['id']; ?>">

	                <div class="form-group">
	                    <label class="form-label">Название</label>
	                    <input type="text" class="form-control" name="title" value="<? echo $row['title']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Город</label>
		                <select class="form-control custom-select" name="city_id">
		                	<!--<option value="0">Везде</option>-->
							<?
								foreach(settings() as $key => $value) { 
									if($value['id'] == $row['city_id']) {
										echo'<option value="'.$value['id'].'" selected>'.$value['city_name'].'</option>';
									} else {
										echo'<option value="'.$value['id'].'">'.$value['city_name'].'</option>';
									}
								}
							?>
						</select>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Страна производителя</label>
	                    <input type="text" class="form-control" name="prod" value="<? echo $row['prod']; ?>">
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Ед. измерения</label>
		                <select class="form-control custom-select" name="type">
							<?
								foreach($arrTypeProduct as $key => $value) { 
									if($key == $row['type']) {
										echo'<option value="'.$key.'" selected>'.$value.'</option>';
									} else {
										echo'<option value="'.$key.'">'.$value.'</option>';
									}
								}
							?>
						</select>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">В наличии (шт.)</label>
	                    <input type="number" class="form-control" name="stock" value="<? echo $row['stock']; ?>">
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Вывод на главной</label>
		                <select class="form-control custom-select" name="favorite">
							<?
								foreach($show_arr as $key => $value) { 
									if($key == $row['favorite']) {
										echo'<option value="'.$key.'" selected>'.$value.'</option>';
									} else {
										echo'<option value="'.$key.'">'.$value.'</option>';
									}
								}
							?>
						</select>
	                </div>


					<div class="form-group">
					    <label class="form-label" for="custom-select1">Категория</label>
					    <select id="custom-select1" class="form-control custom-select" name="category">
					        <?php
					            function cat_showNested2($parentID, $nums, $ro) {
					                $result3 = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '$parentID' ORDER BY `rang`");
					                $numRows += mysqli_num_rows($result3);
					                $nums += $numRows;

						            $probel = "";
									for ($i = 1; $i <= $nums; $i++) {
									    $probel .= "&nbsp;&nbsp;&nbsp;";
									}
					                
					                if ($numRows > 0) {
				                        while($row3 = mysqli_fetch_assoc($result3)) {
					                    	if($row3['id'] == $ro) {
					                        ?>
					                        	<option value="<?php echo $row3['id']; ?>" selected><?php echo $probel; ?><?php echo $row3['title']; ?></option>
					                        <?
											} else {
					                        ?>
					                        	<option value="<?php echo $row3['id']; ?>"><?php echo $probel; ?><?php echo $row3['title']; ?></option>
					                        <?
					                    	}
				                           	cat_showNested2($row3['id'], $nums, $ro);
				                        }
					                }
					            }
					            
					            $q_cat = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '0' ORDER BY `rang`");
			                    while($row2 = mysqli_fetch_assoc($q_cat)) {
			                    	if($row2['id'] == $row['category']) {
			                        ?>
			                        	<option value="<?php echo $row2['id']; ?>" selected><?php echo $row2['title']; ?></option>
			                        <?
			                    	} else {
			                        ?>
			                        	<option value="<?php echo $row2['id']; ?>"><?php echo $row2['title']; ?></option>
			                        <?
			                    	}
			                        cat_showNested2($row2['id'], 0, $row['category']);
			                    }
					        ?>
					    </select>
					</div>

	                <div class="form-group">
	                    <label class="form-label">Цена (в руб.)</label>
	                    <input type="number" class="form-control" name="price" value="<? echo $row['price']; ?>" step="0.01" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Старая цена (в руб.)</label>
	                    <input type="number" class="form-control" name="old_price" value="<? echo $row['old_price']; ?>" step="0.01" required>
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
						<button class="btn btn-white btn-sm">Добавить &nbsp;&nbsp;<i class="fa fa-plus"></i></button>
						<br><br>
					</div>

					<label class="form-label">Характеристики</label>
					<div class="clean"></div>
					<div class="add-character" data-num="<? echo count(characters_products_id($row['id'])); ?>">
						<div id="characters">
							<?php
								foreach(characters_products_id($row['id']) as $key_tag => $value_tag) {
									?>
										<div class="ainput acharacter">
											<input class="form-control" type="text" name="character[<? echo $key_tag; ?>][]" value="<? echo $value_tag['name']; ?>" placeholder="Пример: Вес">
											<input class="form-control" type="text" name="character[<? echo $key_tag; ?>][]" value="<? echo $value_tag['value']; ?>" placeholder="Пример: 200 гр">
											<div class="del-input">
												<i class="fal fa-times"></i>
											</div>
										</div>
									<?
								}
							?>
						</div>
						<button class="btn btn-white btn-sm">Добавить &nbsp;&nbsp;<i class="fa fa-plus"></i></button>
						<br><br>
					</div>

	                <div class="form-group">
	                    <label class="form-label">Вес (в гр.)</label>
	                    <input type="number" class="form-control" name="weight" value="<? echo $row['weight']; ?>" required>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Архивный товар</label>
		                <select class="form-control custom-select" name="archived">
							<?
								foreach($show_arr as $key => $value) { 
									if($key == $row['archived']) {
										echo'<option value="'.$key.'" selected>'.$value.'</option>';
									} else {
										echo'<option value="'.$key.'">'.$value.'</option>';
									}
								}
							?>
						</select>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Краткое описание</label>
	                    <textarea class="form-control" name="description"><? echo $row['description']; ?></textarea>
	                </div>

	                <div class="form-group">
	                    <label class="form-label">Описание</label>
	                    <textarea id="editor" class="form-control" name="content"><? echo $row['content']; ?></textarea>
	                </div>

	                <!--<div class="form-group">
	                    <label class="form-label">Особенности</label>
	                    <textarea id="editor1" class="form-control ckeditor" name="content2"><? echo $row['content2']; ?></textarea>
	                </div>-->

	                <!--<div class="form-group">
	                    <label class="form-label">Документация</label>
	                    <textarea id="editor2" class="form-control ckeditor" name="content3"><? echo $row['content3']; ?></textarea>
	                </div>-->

					<div class="card">
						<div class="card-header d-flex align-items-center">
							<div class="flex">
								<h4 class="card-title">Модификации</h4>
							</div>
							<div class="dropdown">
								<a href="/ap/?page=products_mod&id=add&product_id=<? echo $row['uid']; ?>" data-pjax="content" data-caret="false">
									<i class="material-icons">add</i>
								</a>
							</div>
						</div>
						<div class="card-body">

							<div class="table-responsive border-bottom">
                                <table class="table mb-0">

                                    <tbody class="list">

										<?php 
											foreach (product_mods(1, $row['uid']) as $key => $value) {
												$modId = $value['id'];
												$modUid = $value['uid'];
												    $image = gallery_arr('products_mod', $modId)['0']['image'];
												?>

			                                    	<tr data-id="<? echo $modId; ?>">
			                                            <td>
			                                                <div class="media align-items-center">
			                                                    <a href="/ap/?page=products_mod&id=<?php echo $modId; ?>&product_id=<?php echo $modUid; ?>" class="avatar avatar-md mr-3" data-pjax="content">
			                                                        <img src="/uploads/images/jpeg/<?php echo $image; ?>-100x100.jpeg" alt="Avatar" class="avatar-img rounded-circle">
			                                                    </a>
			                                                    <div class="media-body">
			                                                        <a href="/ap/?page=products_mod&id=<?php echo $modId; ?>&product_id=<?php echo $modUid; ?>" class="js-lists-values-employee-name" data-pjax="content"><? echo $value['title']; ?></a><br>
			                                                        <small class="text-muted js-lists-values-employee-title">Обновлено <?php echo showDate(strtotime($value['updatedate'])); ?></small>
			                                                    </div>
			                                                </div>
			                                            </td>
			                                            <td class="text-right ">
															<div class="dropup">
																<a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
																	<i class="material-icons">more_vert</i>
																</a>
																<div class="dropdown-menu dropdown-menu-right">
																	<a href="/ap/?page=products_mod&id=<?php echo $modId; ?>&product_id=<?php echo $modUid; ?>" class="dropdown-item" data-pjax="content">Изменить</a>
																</div>
															</div>
			                                            </td>
			                                        </tr>

												<?
											}
										?>

                                    </tbody>
                                </table>
                            </div>

						</div>
					</div>

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
					<p>Добалено <? $date = strtotime($row['regdate']); echo date("d.m.y в H:i", $date); ?></p>
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
<?php
    $pageTwo = isset($_GET[$page]) ? $_GET[$page] : '';
    if($pageTwo == 'sort') {
?>
<div class="card">
    <ul class="nav nav-tabs nav-tabs-card">
        <li class="nav-item">
            <a class="nav-link" data-pjax="content" href="/ap/?page=<? echo $page; ?>&<? echo $page; ?>=edit" data-scroll="1">Редактирование</a>
        </li>
        <!--<li class="nav-item show">
            <a class="nav-link" data-pjax="content" href="/ap/?page=<? echo $page; ?>&<? echo $page; ?>=sort" data-scroll="1">Сортировка</a>
        </li>-->
    </ul>
    <div class="card-header d-flex align-items-center">
        <div class="flex">
            <h4 class="card-title"><?php echo $titler; ?></h4>
        </div>
        <div class="dropdown">
        </div>
    </div>
    <div class="card-body tab-content">

    </div>
</div>
<?
    } else {
?>
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
    <div class="tab-content">
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
                <div class="cards col-sm-12 col-md-6 col-lg-4 col-xxl-3">
                    <div class="card">
                        <div class="cart-body">
                            <a data-pjax="content" href="/ap/?page=<?php echo $page; ?>&id=<?php echo $arr[$in]['id']; ?>" class="img">
                                <?php echo gallery($page, $idstr, 0, 1, 'small', '', false, true); ?>
                            </a>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $arr[$in]['title']; ?></h4>
                                <div class="row-info">
                                    <div class="str">
                                        <div>ID</div>
                                        <div class="text"><?php echo $arr[$in]['id']; ?></div>
                                    </div>
                                    <div class="str">
                                        <div>Категория</div>
                                        <div class="text"><? echo productsCategory($arr[$in]['category'])['title']; ?></div>
                                    </div>
                                    <p class="card-text"><?php echo $arr[$in]['description']; ?></p>
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

<?
    }
?>
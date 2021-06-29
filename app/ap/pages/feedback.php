<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/" data-pjax="content">Главная</a></li>
    <li class="breadcrumb-item active">Обратная связь</li>
</ol>
<h1 class="h2">Обратная связь</h1>
<div class="card-group card-group-row">
	<?php
	    $arrP = array();
	    $pagenum = isset($_GET[$page]) ? $_GET[$page] : '';
	    $pagenum = val_string($pagenum);
	    $url_page = '/ap/?page='.$page.'&'.$page.'='.$currentPage;
	    $pagenum = preg_replace("/[^0-9]/", '', $pagenum);
	    $num = 9;  
	    $posts = count(feedback($userId));  
	    $total = intval(($posts - 1) / $num) + 1;  
	    $pagenum = intval($pagenum);  
	    if(empty($pagenum) or $pagenum < 0) $pagenum = 1;  
	    if($pagenum > $total) $pagenum = $total;  
	    $start = $pagenum * $num - $num;  
	    $arr = feedback($userId, $start, $num);

	    if($posts > 0){  
	        #echo '<div class="account-info max">';
	        for($in = 0; $in < $num; $in++)  
	        {  
	            $idstr = isset($arr[$in]['id']) ? $arr[$in]['id'] : 0;
	            if($idstr > 0) {
	                $time = strtotime($arr[$in]['regdate']);    
	?>
	    <div class="card col-sm-12 col-md-6 col-lg-4">
	        <div class="card-body">
	            <h4 class="card-title">ID #<?php echo $arr[$in]['id']; ?></h4>
				<div class="row-info">
					<div class="str">
						<div>Форма</div>
						<div class="text"><?php echo $arr[$in]['form']; ?></div>
					</div>
					<div class="str">
						<div>Имя</div>
						<div class="text"><?php echo $arr[$in]['name']; ?></div>
					</div>
					<div class="str">
						<div>Телефон</div>
						<div class="text"><a href="tel:+<?php echo $arr[$in]['phone']; ?>"><?php echo phone($arr[$in]['phone']); ?></a></div>
					</div>
					<div class="str">
						<div>Эл.почта</div>
						<div class="text"><a href="mailto:<?php echo $arr[$in]['email']; ?>"><?php echo $arr[$in]['email']; ?></a></div>
					</div>
					<div class="str">
						<div>Дата</div>
						<div class="text"><?php echo date('d.m.Y в H:i', $time); ?></div>
					</div>
					<?php if($arr[$in]['message']) { ?>		
						<br>
					<p><?php echo $arr[$in]['message']; ?></p>
					<?php } ?>
					<div class="str no">
						<div>&nbsp;</div>
						<form class="delete-form">
							<input name="delete" type="hidden" value="delete">
							<input name="id" type="hidden" value="<?php echo $arr[$in]['id']; ?>">
							<input name="table" type="hidden" value="<?php echo $page; ?>">
							<button class="btn btn-outline-danger btn-sm delete-form" type="submit">Удалить</button>
						</form>
					</div>
				</div>
	            <p class="card-text">
	                <small class="text-muted">Добавлено <?php echo showDate($time); ?></small>
	            </p>
	        </div>
	    </div>
	<?php
	            }
	        }
	    #echo '</div>';
	    } else {
			?>
			    <div class="card col-lg-12">
			        <div class="card-body">
			        	Нет данных
			        </div>
			    </div>
			<?
	    }
	?>
</div>

<?php  
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
?>
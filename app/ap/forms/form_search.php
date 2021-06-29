<?
	if (isset($_POST['search']) && isset($_POST['text'])) {
		header('Content-type: text/html; charset=utf-8');
		$page = val_string($_POST['search']);
		$word = val_string($_POST['text']);
?>
<a href="/ap/?page=<? echo $page; ?>" class="btn btn-link" data-pjax="content">Вернуться назад</a>
<div class="table-responsive border-bottom">
    <table class="table mb-0">
        <tbody class="list">
			<?php

				$query = mysqli_query($GLOBALS['db'],"SELECT * FROM `$page` WHERE `title` LIKE '%$word%' OR `description` LIKE '%$word%' OR `content` LIKE '%$word%' ORDER BY id LIMIT 100");
			    if(mysqli_num_rows($query) > 0) {
					while($row = mysqli_fetch_array($query)) {
						$uid_search = $row['id'];
						$title_search = $row['title'];
						$description_search = $row['description'];
						$content_search = $row['content'];
						$image = gallery_arr($page, $uid_search )['0']['image'];
						?>

			            	<tr data-id="<? echo $uid_search; ?>">
			                    <td>
			                        <div class="media align-items-center">
			                            <a href="/ap/?page=<?php echo $page; ?>&id=<?php echo $uid_search; ?>" class="avatar avatar-md mr-3" data-pjax="content">
			                            	<?php
			                            		if($image) {
			                            			?>
			                            				<img src="/uploads/images/jpeg/<?php echo $image; ?>-100x100.jpeg" alt="Avatar" class="avatar-img rounded-circle">
			                            			<?
			                            		} else {
			                            			?>
			                            				<img src="/ap/assets/images/no-image.svg" alt="Avatar" class="avatar-img rounded-circle">
			                            			<?
			                            		}
			                            	?>
			                            </a>
			                            <div class="media-body">
			                                <a href="/ap/?page=<?php echo $page; ?>&id=<?php echo $uid_search; ?>" class="js-lists-values-employee-name" data-pjax="content"><? echo $row['title']; ?></a><br>
			                                <small class="text-muted js-lists-values-employee-title">										<?php 
														$content = strip_tags(htmlspecialchars_decode($content_search)); 
														echo mb_strimwidth($content, 0, 120, "...");
													?></small>
			                            </div>
			                        </div>
			                    </td>
			                    <td class="text-right ">
									<div class="dropup">
										<a href="#" class="dropdown-toggle text-muted" data-caret="false" data-toggle="dropdown">
											<i class="material-icons">more_vert</i>
										</a>
										<div class="dropdown-menu dropdown-menu-right">
											<a href="/ap/?page=<?php echo $page; ?>&id=<?php echo $uid_search; ?>" class="dropdown-item" data-pjax="content">Изменить</a>
										</div>
									</div>
			                    </td>
			                </tr>
						<?php
					}
			    } else {
			        echo '<div class="card-body">По вашему запросу ничего не найдено</div>';
			    }
			
			?>
        </tbody>
    </table>
</div>
<?
	}
?>
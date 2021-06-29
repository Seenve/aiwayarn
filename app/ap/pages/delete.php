<?php
	$table = val_string($_GET['table']);
	$id = val_string($_GET['id']);
	$image = val_string($_GET['image']);
	$utm1 = val_string($_GET['utm1']);
	$utm2 = val_string($_GET['utm2']);
	$utm3 = val_string($_GET['utm3']);
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/ap/" data-pjax="content">Главная</a></li>
    <li class="breadcrumb-item active">Удаление</li>
</ol>
<h1 class="h2">Удаление</h1>

<div class="card border-left-3 border-left-danger">
	<div class="card-body">
		<?php

			if(!isset($_GET['table'])) {
				?>
					<script>
						window.location.href = "/ap/";
						$(".preloader").fadeIn("slow");
					</script>
				<?
			} else {
				
				if(isset($_GET['id'])) {
					
					$query = mysqli_query($GLOBALS['db'], "SELECT * FROM `$table` WHERE `id` = '$id'");
					$row = mysqli_fetch_assoc($query);
					
					//echo '<p><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;&nbsp;Удаление</p>';
					//echo 'Вы собираетесь удалить: <b>'.$row['title'].'</b><div class="clean"></div>';
					echo '
						<p><a href="/ap/?page='.$table.'" data-pjax="content">Вернуться назад</a></p>
						<p>Подтвердите удаление ID #'.$id.'</p>
						<form class="ajax">
							<input name="delete" type="hidden" value="delete">
							<input name="id" type="hidden" value="'.$id.'">
							<input name="image" type="hidden" value="'.$image.'">
							<input name="table" type="hidden" value="'.$table.'">
							<input name="utm1" type="hidden" value="'.$utm1.'">
							<input name="utm2" type="hidden" value="'.$utm2.'">
							<input name="utm3" type="hidden" value="'.$utm3.'">
					';
					?>
					<a href="#" class="confirm-form">Удалить</a>
							<button 
							  class="btn btn-danger" 
							  data-toggle="swal" 
							  data-swal-title="Вы уверены?"
							  data-swal-text="Вы не сможете восстановить данный контент!"
							  data-swal-type="warning"
							  data-swal-confirm-button-text="Да, удалить"
							  data-swal-confirm-cb="#swal-confirm-delete"
							  data-swal-show-cancel-button="true"
							  data-swal-cancel-button-text="Нет, отменить"
							  data-swal-cancel-cb="#swal-cancel-delete"
							  data-swal-close-on-confirm="false"
							  data-swal-close-on-cancel="false">
							  Подтвердить удаление
							</button>

							<div 
							  id="swal-cancel-delete" 
							  class="d-none"
							  data-swal-type="error"
							  data-swal-title="Отменено"
							  data-swal-text="Ваш контент не будет удален">
							</div>
						</form>
					<?
				} else {
?>
					<script>
						window.location.href = "/ap/?page=<?php echo $table; ?>";
						$(".preloader").fadeIn("slow");
					</script>
<?
				}
			}
		?>
	</div>
</div>
<?php 
include '../ap/bd.php';

if(isset($_GET['id'])){
	$id = val_string($_GET['id']);
	$resultp = mysqli_query($GLOBALS['db'], "SELECT * FROM `portfolio` WHERE `id` = '$id'");
	
	if(mysqli_num_rows($resultp) > 0){
		$rowp = mysqli_fetch_array($resultp);
		$likes = $rowp['likes']+1;

		mysqli_query($GLOBALS['db'], "UPDATE `portfolio` SET `likes`='$likes' WHERE `id` = '$id'");

		echo json_encode(array(
			'likes' => $likes,
		));
	} else {
		echo json_encode(array(
			'result' => 'error',
		));
	}
}

?>
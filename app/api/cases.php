<?php 
include '../ap/bd.php';

if(isset($_GET['num'])){
	$num = val_string($_GET['num']);
	$resultp = mysqli_query($GLOBALS['db'], "SELECT * FROM `portfolio` ORDER BY id DESC LIMIT $num, 6");
	
	if(mysqli_num_rows($resultp) > 0){

		while($rowp = mysqli_fetch_array($resultp)) {
			$idp = $rowp['id'];
			$image = gallery_arr('portfolio', $idp)['0']['image'];
            if($image){
                $image = $uploads.$image;
            } else {
                $image = '/assets/images/gor.jpg';
            }
			$name = $rowp['name'];
			$title = $rowp['title'];
			$type = $rowp['type'];
			$site_url = $rowp['site'];
			$likes = $rowp['likes'];
			echo '
				<div class="col-md-4 col-sm-6 col-xs-12 case-noactive">
					<div class="item-portfolio">
		                <a class="link-case" href="/portfolio/'.$name.'" data-pjax="content" target="_blank">
							<img class="image-portfolio" src="'.$image.'" alt="'.$title.'">
						</a>
						<ul class="item-details">
							<li class="tooltip" data-tooltip="'.$title.'"><i class="fa fa-info-circle" aria-hidden="true"></i></a><span>'.$typeportfolio_arr[$type].'</span></li>
							<li class="item-details_right"><a href="#like" class="set-like" onclick="like('.$idp.', '.$likes.'); return false;"><i class="fa fa-heart" aria-hidden="true"></i></a><span id="like'.$idp.'">'.$likes.'</span></li>
						</ul>
					</div>
				</div>
			';
		}
		
		//sleep(1);
	}else{
		echo 'NONE';
	}
}

?>
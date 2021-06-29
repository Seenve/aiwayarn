<?php
	if (isset($_POST['geocode'])) {
		if($uid) {
			if(user($uid)['admin'] == 2) {
				$coors_n = val_string($_POST['geocode']);
				$coorsr = explode(",", $coors_n);
				echo geocode($coorsr[0], $coorsr[1]);
			}
		}
	}
?>
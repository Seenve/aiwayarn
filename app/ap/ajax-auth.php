<?
	include 'bd.php';
	if(isset($_POST['auth'])) {
		$hash = md5(generate_code(10));
		$page = urlencode($_POST['pageto']);
	    $login = val_string($_POST['username']);
	    $phone = preg_replace("/[^0-9]/", '', $login);
	    $phone = preg_replace('/^(\d)(\d{3})(\d{3})(\d{2})(\d{2})$/','\2\3\4\5',(string)$phone);
	    $phone = '7'.$phone;
	    $password = md5(val_string($_POST['password']));
	    
		if($login) {
			if($password) {
				$query_account = mysqli_query($GLOBALS['db'], "SELECT * FROM `accounts` WHERE `email` = '$login' OR `uid` = '$login' OR `phone` = '$phone' ORDER BY id");
			    if(mysqli_num_rows($query_account) > 0) {
			    	$row_user = mysqli_fetch_assoc($query_account);
			    	$user_uid = $row_user['uid'];
			    	$user_email = $row_user['email'];
			    	$user_code = $row_user['code'];
			    	$user_firstname = $row_user['firstname'];
			    	if($password == $row_user['password']) {

			    		if($row_user['admin'] >= 1) {
				    		mysqli_query($GLOBALS['db'], "UPDATE `accounts` SET `hash`='$hash' WHERE `uid`='$user_uid'");

				    		$_SESSION['userhash'] = $hash;
							$_SESSION['useruid'] = $user_uid;

							echo json_encode(array(
								'result' => 'echo',
								'message' => '<script>
									/*if ($.support.pjax) {
										$.pjax({
											url: "'.urldecode($page).'", 
											container: "#content",
											"push":true,
											"replace":false,
											"timeout":10000,
											"scrollTo":false,
										});
									} else {*/
										window.location.href = "'.urldecode($page).'";
										$(".preloader").fadeIn("slow");
								</script>'
							));
			    		} else {
							echo json_encode(array(
								'result' => false,
								'message' => '<i class="fa fa-info"></i>Ошибка, вы не являетесь администратором',
							));
			    		}

			    	} else {
						echo json_encode(array(
							'result' => false,
							'message' => '<i class="fa fa-info"></i>Неверный логин/пароль',
						));
					}
			    } else {
					echo json_encode(array(
						'result' => false,
						'message' => '<i class="fa fa-info"></i>Неверный логин/пароль',
					));
			    }

			} else {
				echo json_encode(array(
					'result' => false,
					'message' => '<i class="fa fa-info"></i>Введите пароль'
				));
			}
		} else {
			echo json_encode(array(
				'result' => false,
				'message' => '<i class="fa fa-info"></i>Введите телефон или эл.почту',
				'username' => false,
				'password' => false,
			));
		}
	}

	if(isset($_POST['logout'])) {
		$login = val_string($_SESSION['useruid']);
		mysqli_query($GLOBALS['db'], "UPDATE `accounts` SET `hash`='0' WHERE `uid`='$login'");
		unset($_SESSION['userhash']);
		unset($_SESSION['useruid']);
		echo json_encode(array(
			'result' => 'echo',
			'message' => '<script>
				/*if ($.support.pjax) {
					$.pjax({
						url: "'.urldecode($page).'", 
						container: "#content",
						"push":true,
						"replace":false,
						"timeout":10000,
						"scrollTo":false,
					});
				} else {*/
					window.location.href = "'.urldecode($page).'"
					$("#preloader").fadeIn("slow");
			</script>'
		));
	}
?>
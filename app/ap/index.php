<?
    include 'bd.php';
    if (!isset($_SERVER['HTTP_X_PJAX'])) { 

		if(authuser()) {
			$account = authuser();

			include 'header.php'; 

			if(isset($_GET['page']) || strlen($_GET['page']) > 0) {
				$page = val_string($_GET['page']);
				if($page !== '') {
					$pagen='pages/'.$page.'.php';
					if (file_exists($pagen)) {
					    include $pagen;
					} else {
					    include 'pages/404.php';
					}
				} else {
					include 'pages/main.php';
				}
			} else {
				include 'pages/main.php';
			}

			include 'footer.php'; 

		} else {
			include 'auth.php'; 
		}

	} else { 
		
		if(authuser()) {
			$account = authuser();
			if(isset($_GET['page']) || strlen($_GET['page']) > 0) {
				$page = val_string($_GET['page']);
				if($page !== '') {
					$pagen='pages/'.$page.'.php';
					if (file_exists($pagen)) {
					    include $pagen;
					} else {
					    include 'pages/404.php';
					}
				} else {
					include 'pages/main.php';
				}
			} else {
				include 'pages/main.php';
			}
		} else {
?>
			<script>
				window.location.href = "/ap/";
				$("#preloader").fadeIn("slow");
			</script>
<?
		}
	}
?> 
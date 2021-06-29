<?
include '../ap/bd.php';

header('Content-type: application/json; charset=utf-8');

function admin_error($str = false) {
	return json_encode(array(
		'result' => false,
		'message' => 'Недостаточно прав для выполнения данной операции',
	));
}
function auth_error($str = false) {
	return json_encode(array(
		'result' => false,
		'message' => 'Вы не авторизованы',
	));
}
function insert_error($str = false) {
	return json_encode(array(
		'result' => false,
		'message' => 'Неверный запрос. Обратитесь в службу поддержки.',
	));
}
function insert_add($str = false, $err = '') {
	return json_encode(array(
		'result' => true,
		'title' => 'Выполнено',
		'type' => 'success',
		'redirect' => $str,
		'reload' => false,
		'message' => 'Успешно добавлено!'.$err,
	));
}
/*function insert_update($str) {
	return json_encode(array(
		'result' => true,
		'title' => 'Выполнено',
		'type' => 'success',
		'redirect' => false,
		'reload' => false,
		'notify' => true,
		'message' => 'Успешно обновлено!',
	));
}*/
function insert_update($str = false) {
	return json_encode(array(
		'result' => true,
		'title' => 'Выполнено',
		'type' => 'success',
		'redirect' => $str,
		'reload' => false,
		'message' => 'Успешно обновлено!',
	));
}

if(authuser()) {
	$uid = authuser();

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		foreach (glob("$path/forms/form_*.php") as $docFile) {
		   include $docFile;
		}
	} else {
		echo insert_error();
	}
} else {
	echo auth_error();
}


?>
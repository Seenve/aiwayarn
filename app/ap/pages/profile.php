<?php
	$pageTwo = isset($_GET[$page]) ? $_GET[$page] : '';
	if($pageTwo == 'resetpassword') {
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/ap/" data-pjax="content">Главная</a></li>
    <li class="breadcrumb-item"><a href="/ap/?page=profile" data-pjax="content">Профиль</a></li>
    <li class="breadcrumb-item active">Смена пароля</li>
</ol>
<div class="card">
	<div class="card-header d-flex align-items-center">
		<div class="flex">
			<h4 class="card-title">Смена пароля</h4>
		</div>
	</div>
	<div class="card-body row">
		<div class="col-lg-3">
			<div class="row-info form-group">
	           <form class="flex ajax-edit" method="POST">
	           		<input name="updatepassword" type="hidden" value="1">
	                <div class="form-group">
	                    <label class="form-label">Новый пароль</label>
	                    <input type="password" class="form-control" name="passwordone" placeholder="Введите новый пароль">
	                </div>
	                <div class="form-group">
	                    <label class="form-label">Повторите пароль</label>
	                    <input type="password" class="form-control" name="passwordtwo" placeholder="Повторите новый пароль">
	                </div>
					<div class="result alert alert-dismissible bg-light border-0 fade show" role="alert"></div>
					<div class="result_error alert bg-danger text-white border-0" role="alert"></div>
					<div class="result_success alert bg-success text-white border-0" role="alert"></div>
	                <button type="submit" class="btn btn-primary">Сменить пароль</button>
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
    <li class="breadcrumb-item active">Профиль</li>
</ol>
<div class="card">
	<div class="card-header d-flex align-items-center">
		<div class="flex">
			<h4 class="card-title">Профиль</h4>
		</div>
	</div>
	<div class="card-body row">
		<div class="col-lg-4">
			<div class="row-info form-group">
				<div class="str">
					<div>Имя</div>
					<div class="text"><?php echo user($account)['firstname'] ?></div>
				</div>
				<div class="str">
					<div>Фамилия</div>
					<div class="text"><?php echo user($account)['lastname'] ?></div>
				</div>
				<div class="str">
					<div>Эл.почта</div>
					<div class="text"><?php echo user($account)['email'] ?></div>
				</div>
				<div class="str">
					<div>Телефон</div>
					<div class="text"><?php echo phone(user($account)['phone']); ?></div>
				</div>
				<div class="str">
					<div>Дата регистрации</div>
					<div class="text"><?php echo date('d.m.Y в H:i', user($account)['regdate']); ?></div>
				</div>
				<p class="card-text"><?php echo $arr[$in]['description']; ?></p>
			</div>
			<a data-pjax="content" href="/ap/?page=profile&profile=resetpassword" class="btn btn-dark btn-sm">Изменить пароль</a>
		</div>
	</div>
</div>

<?
	}
?>

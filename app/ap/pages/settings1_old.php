        <?php
            /*function menu_showNested($arr, $name, $dap) {
                foreach ($arr as $key => $value) {

                    if($value['id']) {
                        if($key == 0) {
                            $dap = $dap-0.1;
                        }
                        echo '<ul class="nestable-list">';
                        if(empty($value['children'])) {
                            $url = $name.'/'.$value['name'];
                            echo '<li class="nestable-item">';
                            echo '<div class="nestable-handle">'.$value['title'].' <span>'.$url.' '.str_replace(',', '.', $dap).'</span></div>';
                            echo '</li>';
                        } else {
                            $url = $name.'/'.$value['name'];
                            echo '<li class="nestable-item">';
                            echo '<div class="nestable-handle">'.$value['title'].' <span>'.$url.' '.str_replace(',', '.', $dap).'</span></div>';
                            
                            menu_showNested($value['children'], $url, $dap);
                            
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                }
            }
            

            echo '<div class="nestable">';
                echo '<ul class="nestable-list">';

                    foreach (pagesArr() as $key => $value) {
                        $dap = '1.0';
                        if($value['id']) {
                            if(empty($value['children'])) {
                                $url = '/'.$value['name'];
                                echo '<li class="nestable-item">';
                                echo '<div class="nestable-handle">'.$value['title'].' <span>'.$url.' '.$dap.'</span></div>';
                                echo '</li>';
                            } else {
                                $url = '/'.$value['name'];
                                echo '<li class="nestable-item">';
                                echo '<div class="nestable-handle">'.$value['title'].' <span>'.$url.' '.$dap.'</span></div>';
                                
                                menu_showNested($value['children'], $url, 1.0);
                                
                                echo '</li>';
                            }
                        }
                    }
                    
                echo '</ul>';
            echo '</div>';*/
        ?>

<?php 
        //echo json_encode($array);
?>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/" data-pjax="content">Главная</a></li>
    <li class="breadcrumb-item active">Настройка сайта</li>
</ol>
<h1 class="h2">Информация</h1>
<div class="card card-body">
    <div class="row">
        <div class="col-lg-12 d-flex">
            <form class="flex ajax" method="POST">
            	<input type="hidden" name="edit-site" value="1">
                <div class="form-group">
                    <label class="form-label">Название сайта</label>
                    <input type="text" class="form-control" name="title" placeholder="Введите название сайта" value="<?php echo settings()['0']['title']; ?>">
                </div>
                <div class="form-group">
                    <label class="form-label" for="input2">Описание сайта</label>
                    <textarea class="form-control" name="description" placeholder="Введите описание сайта"><?php echo settings()['0']['description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="input1">Ключевые слова</label>
                    <textarea class="form-control" name="keywords" placeholder="Введите ключевые слова через запятую"><?php echo settings()['0']['keywords']; ?></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="input1">Адрес компании</label>
                    <textarea class="form-control" name="address" placeholder="Введите адрес компании"><?php echo settings()['0']['address']; ?></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="input1">Время работы компании</label>
                    <input class="form-control" name="job_time" value="<?php echo settings()['0']['job_time']; ?>" type="text" placeholder="Введите время работы">
                </div>
                <div class="form-group">
                    <label class="form-label" for="input1">Телефон</label>
                    <input class="form-control" name="phone" value="<?php echo settings()['0']['phone']; ?>" type="text" placeholder="+7 (9__) ___-__-__">
                </div>
                <div class="form-group">
                    <label class="form-label" for="input1">Телефон (мессенджеры)</label>
                    <input class="form-control" name="phone_messanger" value="<?php echo settings()['0']['phone_messanger']; ?>" type="text" placeholder="+7 (9__) ___-__-__">
                </div>
                <div class="form-group">
                    <label class="form-label" for="input1">Эл.почта</label>
                    <input class="form-control" name="email" value="<?php echo settings()['0']['email']; ?>" type="text" placeholder="Введите эл.почту">
                </div>
				<div class="result alert alert-dismissible bg-light border-0 fade show" role="alert"></div>
				<div class="result_error alert bg-danger text-white border-0" role="alert"></div>
				<div class="result_success alert bg-success text-white border-0" role="alert"></div>
                <button type="submit" class="btn btn-success">Сохранить</button>
            </form>
        </div>
    </div>
</div>
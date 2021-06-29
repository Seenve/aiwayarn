<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/" data-pjax="content">Главная</a></li>
    <li class="breadcrumb-item active">Меню сайта</li>
</ol>
<h1 class="h2" id="menu">Меню сайта</h1>
<?php
    $pageTwo = isset($_GET[$page]) ? $_GET[$page] : '';
    if($pageTwo == 'sort') {
?>
<div class="card">
    <ul class="nav nav-tabs nav-tabs-card">
        <li class="nav-item">
            <a class="nav-link" data-pjax="content" href="/ap/?page=<? echo $page; ?>&<? echo $page; ?>=edit" data-scroll="1">Редактирование</a>
        </li>
        <li class="nav-item show">
            <a class="nav-link" data-pjax="content" href="/ap/?page=<? echo $page; ?>&<? echo $page; ?>=sort" data-scroll="1">Сортировка</a>
        </li>
    </ul>
    <div class="card-body tab-content">
        <?php
            function menu_showNested($parentID) {
                $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `menu` WHERE `parent_id` = '$parentID' ORDER BY `rang`");
                $numRows = mysqli_num_rows($result);
                
                if ($numRows > 0) {
                    echo '<ul class="nestable-list">';
                        while($row = mysqli_fetch_array($result)) {
                            echo '<li class="nestable-item" data-id="'.$row['id'].'">';
                            echo '<div class="nestable-handle">'.$row['name'].' <span>'.$row['url'].'</span></div>';
                            
                            menu_showNested($row['id']);
                            
                            echo '</li>';
                        }
                    echo '</ul>';
                }
            }
            

            $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `menu` WHERE `parent_id` = '0' ORDER BY `rang`");
            $numRows = mysqli_num_rows($result);

            echo '<div class="nestable" id="nestableMenu">';
                echo '<ul class="nestable-list">';
                
                    while($row = mysqli_fetch_array($result)) {
                        echo '<li class="nestable-item" data-id="'.$row['id'].'">';
                        echo '<div class="nestable-handle">'.$row['name'].' <span>'.$row['url'].'</span></div>';
                        
                        menu_showNested($row['id']);
                        
                        echo '</li>';
                    }
                    
                echo '</ul>';
            echo '</div>';
        ?>
    </div>
</div>
<?
    } else {
?>
<div class="card">
    <ul class="nav nav-tabs nav-tabs-card">
        <li class="nav-item show">
            <a class="nav-link" data-pjax="content" href="/ap/?page=<? echo $page; ?>&<? echo $page; ?>=edit" data-scroll="1">Редактирование</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-pjax="content" href="/ap/?page=<? echo $page; ?>&<? echo $page; ?>=sort" data-scroll="1">Сортировка</a>
        </li>
    </ul>
    <div class="card-body tab-content">
        <?php
            function menu_showNested2($parentID) {
                $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `menu` WHERE `parent_id` = '$parentID' ORDER BY `rang`");
                $numRows = mysqli_num_rows($result);
                
                if ($numRows > 0) {
                    echo '<ul class="nestable-list">';
                        while($row = mysqli_fetch_array($result)) {
                            echo '<li class="nestable-item" data-id="'.$row['id'].'">';

                            ?>
                            <div class="nestable-handle">
                                <div class="name">
                                    <div class="text"><? echo $row['name']; ?></div>
                                    <input type="text" name="name" class="form-control form-control-sm" value="<? echo $row['name']; ?>" data-name="<? echo $row['id']; ?>">
                                </div>
                                <div class="info">
                                    <div class="url">
                                        <div class="text"><a href="<? echo $row['url']; ?>" target="_blank"><? echo $row['url']; ?></a></div>
                                        <input type="text" name="url" class="form-control form-control-sm" value="<? echo $row['url']; ?>" data-url="<? echo $row['id']; ?>">
                                    </div>
                                    <div class="btn btn-success btn-sm save-edit-menu" data-id="<? echo $row['id']; ?>">
                                        Сохранить
                                    </div>
                                    <div class="btn btn-white btn-sm close-edit-menu">
                                        <i class="far fa-times"></i>
                                    </div>
                                    <div class="btn btn-primary btn-sm btn-edit-menu">
                                        <i class="far fa-edit"></i>
                                    </div>
                                    <form class="ajax">
                                        <input name="menu_show" type="hidden" value="1">
                                        <input name="id" type="hidden" value="<? echo $row['id']; ?>">
                                        <input name="show" type="hidden" value="<? echo $row['show']; ?>">
                                        <button class="btn btn-dark btn-sm show-edit-menu" type="submit"><? if($row['show'] == 1) { echo '<i class="far fa-eye"></i>'; } else { echo '<i class="far fa-eye-slash"></i>'; } ?></button>
                                    </form>
                                    <form class="ajax-confirm" data-title="Вы уверены?" data-text="Вы не сможете восстановить данный контент!" data-type="warning" data-text-confirm="Да, удалить" data-text-cancel="Нет, отменить">
                                        <input name="delete" type="hidden" value="delete">
                                        <input name="reload" type="hidden" value="1">
                                        <input name="id" type="hidden" value="<? echo $row['id']; ?>">
                                        <input name="table" type="hidden" value="menu">
                                        <button class="ajax-confirm btn btn-danger btn-sm delete-edit-menu" type="submit"><i class="far fa-trash-alt"></i></button>
                                    </form>
                                </div> 
                            </div>
                            <?
                            
                            menu_showNested2($row['id']);
                            
                            echo '</li>';
                        }
                    echo '</ul>';
                }
            }
            

            $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `menu` WHERE `parent_id` = '0' ORDER BY `rang`");
            $numRows = mysqli_num_rows($result);

            echo '<div class="nestable nestable-edit" id="menu_edit">';
                echo '<ul class="nestable-list">';
                
                    while($row = mysqli_fetch_array($result)) {
                        echo '<li class="nestable-item">';
                        //echo '<div class="nestable-handle">'.$row['id'].': '.$row['name'].'';
                        ?>
                        <div class="nestable-handle">
                            <div class="name">
                                <div class="text"><? echo $row['name']; ?></div>
                                <input type="text" name="name" class="form-control form-control-sm" value="<? echo $row['name']; ?>" data-name="<? echo $row['id']; ?>">
                            </div>
                            <div class="info">
                                <div class="url">
                                    <div class="text"><a href="<? echo $row['url']; ?>" target="_blank"><? echo $row['url']; ?></a></div>
                                    <input type="text" name="url" class="form-control form-control-sm" value="<? echo $row['url']; ?>" data-url="<? echo $row['id']; ?>">
                                </div>
                                <div class="btn btn-success btn-sm save-edit-menu" data-id="<? echo $row['id']; ?>">
                                    Сохранить
                                </div>
                                <div class="btn btn-white btn-sm close-edit-menu">
                                    <i class="far fa-times"></i>
                                </div>
                                <div class="btn btn-primary btn-sm btn-edit-menu">
                                    <i class="far fa-edit"></i>
                                </div>
                                <form class="ajax">
                                    <input name="menu_show" type="hidden" value="1">
                                    <input name="id" type="hidden" value="<? echo $row['id']; ?>">
                                    <input name="show" type="hidden" value="<? echo $row['show']; ?>">
                                    <button class="btn btn-dark btn-sm show-edit-menu" type="submit"><? if($row['show'] == 1) { echo '<i class="far fa-eye"></i>'; } else { echo '<i class="far fa-eye-slash"></i>'; } ?></button>
                                </form>
                                <form class="ajax-confirm" data-title="Вы уверены?" data-text="Вы не сможете восстановить данный контент!" data-type="warning" data-text-confirm="Да, удалить" data-text-cancel="Нет, отменить">
                                    <input name="delete" type="hidden" value="delete">
                                    <input name="reload" type="hidden" value="1">
                                    <input name="id" type="hidden" value="<? echo $row['id']; ?>">
                                    <input name="table" type="hidden" value="menu">
                                    <button class="ajax-confirm btn btn-danger btn-sm delete-edit-menu" type="submit"><i class="far fa-trash-alt"></i></button>
                                </form>
                            </div> 
                        </div>
                        <?
                        //echo '</div>';
                        
                        menu_showNested2($row['id']);
                        echo '</li>';
                    }
                echo '</ul>';
            echo '</div>';
        ?>
        <h4 class="mt-5">Новая ссылка</h4>
        <form class="ajax" method="POST">
            <input name="add_menu" type="hidden" value="1">

            <div class="form-group">
                <label class="form-label">Название</label>
                <input type="text" class="form-control" name="name" required="">
            </div>

            <div class="form-group">
                <label class="form-label">Ссылка [URL]</label>
                <input type="text" class="form-control" name="url" required="">
            </div>

            <div class="result alert alert-dismissible bg-light border-0 fade show" role="alert" style="display: none;"></div>
            <div class="result_error alert bg-danger text-white border-0" role="alert" style="display: none;"></div>
            <!--<div class="result_success alert bg-success text-white border-0" role="alert"></div>-->
            <button class="btn btn-primary" type="submit">Добавить</button>
        </form>
        <!--<h4 class="mt-5">Сброс меню</h4>-->
        <form class="ajax-confirm" data-title="Вы уверены?" data-text="Меню будет сброшено по умолчанию" data-type="warning" data-text-confirm="Да, удалить" data-text-cancel="Нет, отменить">
            <input name="reset_menu" type="hidden" value="1">
            <button class="ajax-confirm btn btn-danger mt-4" type="submit">Сбросить по умолчанию</button>
        </form>
    </div>
</div>
<?
    }
?>
<?php  
    $pervpage = '';
    $nextpage = '';
    $pagenum1left = '';
    $pagenum2left = '';
    $pagenum1right = '';
    $pagenum2right = '';

   	if ($pagenum != 1) $pervpage = '<li><a class="box" data-pjax=content href='.$url_page.'1><<</a></li>';
    if ($pagenum != 1) $pervpage = '<li><a class="box" data-pjax=content href='.$url_page.''. ($pagenum - 1) .'><</a></li>';  
    
    if ($pagenum != $total) $nextpage = ' <li><a class="box" data-pjax=content href='.$url_page.''. ($pagenum + 1) .'>></a></li>  
                                       <li><a class="box" data-pjax=content href='.$url_page.''.$total. '>>></a></li>';  

    
    //if($pagenum - 2 > 0) $pagenum2left = '<li><a class="box" data-pjax=content href='.$url_page.''. ($pagenum - 2) .'>'. ($pagenum - 2) .'</a></li>';  
    if($pagenum - 1 > 0) $pagenum1left = '<li><a class="box" data-pjax=content href='.$url_page.''. ($pagenum - 1) .'>'. ($pagenum - 1) .'</a></li>';  
    //if($pagenum + 2 <= $total) $pagenum2right = '<li><a class="box" data-pjax=content href='.$url_page.''. ($pagenum + 2) .'>'. ($pagenum + 2) .'</a></li>';  
    if($pagenum + 1 <= $total) $pagenum1right = '<li><a class="box" data-pjax=content href='.$url_page.''. ($pagenum + 1) .'>'. ($pagenum + 1) .'</a></li>'; 

    if($num < $posts) {
        ?>
            <ul class="pagination">
                <?
                echo $pervpage.$pagenum2left.$pagenum1left.'<li><span class="current box">'.$pagenum.'</span></li>'.$pagenum1right.$pagenum2right.$nextpage;  
                ?>
            </ul>
        <?
    }


    /*if ($pagenum != 1) $pervpage = '<li><a class="prev" data-pjax=content href='.$url_page.''. ($pagenum - 1) .'>Назад</a></li>
    <li><a class="box" data-pjax=content href='.$url_page.'1>1</a></li>';  
    
    if ($pagenum != $total) $nextpage = ' 
    <li><span class="box">...</span></li>
    <li><a class="box" data-pjax=content href='.$url_page.''.$total. '>'.$total.'</a></li>
    						<li><a class="next" data-pjax=content href='.$url_page.''. ($pagenum + 1) .'>Далее</a></li>';

    
    //if($pagenum - 2 > 0) $pagenum2left = '<li><a class="box" data-pjax=content href='.$url_page.''. ($pagenum - 2) .'>'. ($pagenum - 2) .'</a></li>';  
    if($pagenum - 1 > 0) $pagenum1left = '<li><a class="box" data-pjax=content href='.$url_page.''. ($pagenum - 1) .'>'. ($pagenum - 1) .'</a></li>';  
    //if($pagenum + 2 <= $total) $pagenum2right = '<li><a class="box" data-pjax=content href='.$url_page.''. ($pagenum + 2) .'>'. ($pagenum + 2) .'</a></li>';  
    if($pagenum + 1 <= $total && $total !== $pagenum + 1) $pagenum1right = '<li><a class="box" data-pjax=content href='.$url_page.''. ($pagenum + 1) .'>'. ($pagenum + 1) .'</a></li>'; 

    if($num < $posts) {
        ?>
            <ul class="pagination">
                <?
                echo $pervpage.$pagenum2left.$pagenum1left.'<li><span class="box current">'.$pagenum.'</span></li>'.$pagenum1right.$pagenum2right.$nextpage;  
                ?>
            </ul>
        <?
    }*/
?>
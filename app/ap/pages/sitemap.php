<h1 class="h2" id="sitemap">Карта сайта</h1>
<div class="card card-body">
    <div class="row">
        <div class="col-lg-12">
            <p>Последнее обновление <? $date = strtotime(settings()['0']['sitemap']); echo date("d.m.y в H:i", $date); ?></p>
            <p>Ссылка на карту: <a href="http://<? echo $_SERVER['HTTP_HOST']; ?>/sitemap.xml" target="_blank"><? echo $_SERVER['HTTP_HOST']; ?>/sitemap.xml</a></p>
            <form class="ajax" method="POST">
                <input name="sitemap_generate" type="hidden" value="1">
                <div class="result alert alert-dismissible bg-light border-0 fade show" role="alert"></div>
                <div class="result_error alert bg-danger text-white border-0" role="alert"></div>
                <div class="result_success alert bg-success text-white border-0" role="alert"></div>
                <button class="btn btn-primary" type="submit">Сгенерировать</button>
            </form>
        </div>
    </div>
</div>
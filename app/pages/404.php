<?php if (!isset($_SERVER['HTTP_X_PJAX'])) {  include 'header.php'; } ?>

<?php include $path.'/../modules/breadcrumbs.php'; ?>

<section class="page-404">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-404__title">404</h1>
                <p>К сожалению, запрошенная вами страница не существует</p>
            </div>
        </div>
    </div>
</section>


<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'footer.php'; } ?>
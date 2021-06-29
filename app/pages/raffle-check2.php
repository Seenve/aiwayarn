<style>
	.top {
		box-shadow: none !important;
	}
</style>

    <section class="section section__hello section_no-space-bottom" id="hello">
        <div class="container">
			<div class="row">
			    <div class="col-md-8 col-md-offset-2 col__quote text-center" data-bottom="transform[swing]:translateY(0px)" data--400-top="transform[swing]:translateY(-100px)">
				    <h2 class="title__section title__h1 title_decoration title_vertical-line-top">Анкета участника</h2>
					<div class="block-quotes block-quote__about">
					    <form id="raffle_check" method="POST" action="/api/raffle-check.php">
					        <label for="firstname" class="label"></label>
                            <input type="text" class="form-control" style="text-align: center;font-weight: 600;color: yellow;border: 1px solid #fff;padding-left: 10px;padding-right: 10px;" name="id" required autocomplete="off" placeholder="Номер билета">
						   	<div id="result"></div>
						    <button type="submit" class="btn hero__btn">Проверить</button>
						</form>
					</div>
				</div>
            </div>
		</div>
	</section>

	<title>Розыгрыш денежных сертификатов от Vucs Web Studio</title>
	
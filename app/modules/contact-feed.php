<section class="contact-feed">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-xl-8">
                <div class="contact-feed__requisites">
                    <div class="contact-feed__block">
                        <h5 class="contact-feed__title">Реквизиты магазина</h5>
                        <p class="contact-feed__top-text">«AIWA YARN»</p>
                    </div>
                
                    <div class="contact-feed__block">
                        <ul class="contact-feed__list-req">
                            <li>
                                <p>Юридический адрес <b id="text2">г. Новосибирск, улица Дуси Ковальчук, 238, 2 этаж, отдел 18 </b></p>
                                <button class="copy" onclick="copytext('#text2')">
                                    <svg width="12" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.11 0H4.476a.858.858 0 00-.857.857V2.87h.783V.857c0-.04.033-.074.074-.074h6.634c.04 0 .074.033.074.074V7.49a.075.075 0 01-.074.075H9.16v.783h1.95a.858.858 0 00.857-.858V.857A.858.858 0 0011.11 0z" fill="#007AFF"/><path d="M7.522 3.652H.889a.858.858 0 00-.858.857v6.634c0 .472.385.857.858.857h6.633a.858.858 0 00.857-.857V4.509a.858.858 0 00-.857-.857zm0 7.565H.889a.075.075 0 01-.075-.074V4.509c0-.04.033-.074.075-.074h6.633c.041 0 .075.033.075.074v6.634a.075.075 0 01-.075.074z" fill="#007AFF"/></svg>
                                </button>
                            </li>

                            <li>
                                <p>ИНН <b id="text3">5433181010</b></p>
                                <button class="copy" onclick="copytext('#text3')">
                                    <svg width="12" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.11 0H4.476a.858.858 0 00-.857.857V2.87h.783V.857c0-.04.033-.074.074-.074h6.634c.04 0 .074.033.074.074V7.49a.075.075 0 01-.074.075H9.16v.783h1.95a.858.858 0 00.857-.858V.857A.858.858 0 0011.11 0z" fill="#007AFF"/><path d="M7.522 3.652H.889a.858.858 0 00-.858.857v6.634c0 .472.385.857.858.857h6.633a.858.858 0 00.857-.857V4.509a.858.858 0 00-.857-.857zm0 7.565H.889a.075.075 0 01-.075-.074V4.509c0-.04.033-.074.075-.074h6.633c.041 0 .075.033.075.074v6.634a.075.075 0 01-.075.074z" fill="#007AFF"/></svg>
                                </button>
                            </li>
                            <li>
                                <p>КПП <b id="text4">543301001</b> </p>
                                <button class="copy" onclick="copytext('#text4')">
                                    <svg width="12" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.11 0H4.476a.858.858 0 00-.857.857V2.87h.783V.857c0-.04.033-.074.074-.074h6.634c.04 0 .074.033.074.074V7.49a.075.075 0 01-.074.075H9.16v.783h1.95a.858.858 0 00.857-.858V.857A.858.858 0 0011.11 0z" fill="#007AFF"/><path d="M7.522 3.652H.889a.858.858 0 00-.858.857v6.634c0 .472.385.857.858.857h6.633a.858.858 0 00.857-.857V4.509a.858.858 0 00-.857-.857zm0 7.565H.889a.075.075 0 01-.075-.074V4.509c0-.04.033-.074.075-.074h6.633c.041 0 .075.033.075.074v6.634a.075.075 0 01-.075.074z" fill="#007AFF"/></svg>
                                </button>
                            </li>
                            <li>
                                <p>ОГРН <b id="text5">1105475001345</b></p>
                                <button class="copy" onclick="copytext('#text5')">
                                    <svg width="12" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.11 0H4.476a.858.858 0 00-.857.857V2.87h.783V.857c0-.04.033-.074.074-.074h6.634c.04 0 .074.033.074.074V7.49a.075.075 0 01-.074.075H9.16v.783h1.95a.858.858 0 00.857-.858V.857A.858.858 0 0011.11 0z" fill="#007AFF"/><path d="M7.522 3.652H.889a.858.858 0 00-.858.857v6.634c0 .472.385.857.858.857h6.633a.858.858 0 00.857-.857V4.509a.858.858 0 00-.857-.857zm0 7.565H.889a.075.075 0 01-.075-.074V4.509c0-.04.033-.074.075-.074h6.633c.041 0 .075.033.075.074v6.634a.075.075 0 01-.075.074z" fill="#007AFF"/></svg>
                                </button>
                            </li>
                        </ul>
                    </div>

                    
                </div>
            </div>
            <div class="col-lg-3 offset-lg-1 offset-xl-0 col-xl-4">
                <div class="contact-feed__form">
                    
                    <div class="form-b"> 
                        <h5 class="form-b__title">Обратная связь</h5>
                        <form data-action="/api/form-contact.php" class="form ajax">
                            <input type="hidden" name="form" value="Обратная связь">
                            <input type="text" name="firstname" placeholder="Ваше имя" required>
                            <input type="tel" name="phone" placeholder="Ваш телефон" required>
                            <textarea type="text" placeholder="Ваше сообщение" name="message" rows="5"></textarea>
                            <button type="submit" class="form-b__btn btn btn-purple btn-size_full">Отправить сообщение</button>

                            <div class="msg_success" data-text="Ваше обращение успешно отправлено."></div>

                            <div class="checkbox-private">
                                <div class="checkbox__label">
                                    <div class="checkbox__group big-form__group-input">
                                        <input type="checkbox" name="political" class="checkbox__input input" id="customCheckbox1" hidden="" checked="">
                                        <span class="checkbox__checked"></span>
                                    </div>
                                    <label class="checkbox-private__text-block" for="customCheckbox1">
                                       <span class="checkbox-private__text">Я соглашаюсь на обработку моих <a class="vis-modal-p" href="#"><small>персональных данных</small></a></span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
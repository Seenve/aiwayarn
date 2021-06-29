<h6>Где мы находимся</h6>

<div class="map__contact">
    <a class=" link--black" href="tel:<?php echo phone(settings_id($GLOBALS['city'])[0]['phone']); ?>"> 
        <i class="fas fa-phone"></i>
    <?php echo phone(settings_id($GLOBALS['city'])[0]['phone']); ?></a>
    <a class="header-contact_email link--blue" href="mailto:<?php echo settings_id($GLOBALS['city'])[0]['email2']; ?>"><?php echo settings_id($GLOBALS['city'])[0]['email2']; ?></a>
</div>

<!--<div class="map__contact">
    <a class=" link--black" href="tel:<?php echo phone(settings_id($GLOBALS['city'])[0]['phone2']); ?>"> 
        <i class="fas fa-phone"></i>
        <?php echo phone(settings_id($GLOBALS['city'])[0]['phone2']); ?></a>
    <a class="header-contact_email link--blue" href="mailto:<?php echo settings_id($GLOBALS['city'])[0]['email']; ?>"><?php echo settings_id($GLOBALS['city'])[0]['email']; ?></a>
</div>-->

<div class="map__contact">
    <a class=" link--black" href="#"> 
        <i class="fas fa-map-marker-alt"></i>
        г. <?php echo settings_id($GLOBALS['city'])[0]['city_name']; ?></a>
    <a class="header-contact_email link--blue" href="#"><?php echo settings_id($GLOBALS['city'])[0]['address']; ?></a>
</div>

<div class="map__contact">
    <?php echo nl2br(settings_id($GLOBALS['city'])[0]['jobtime']); ?>
</div>

<ul class="map__socials">
    <li>
        <a href="<?php echo settings_id($GLOBALS['city'])[0]['soc_1']; ?>">
            <i class="fab fa-vk"></i>
        </a>
    </li>
    <li>
        <a href="<?php echo settings_id($GLOBALS['city'])[0]['soc_2']; ?>">
            <i class="fab fa-whatsapp"></i>
        </a>
    </li>
    <li>
        <a href="<?php echo settings_id($GLOBALS['city'])[0]['soc_3']; ?>">
            <i class="fab fa-instagram"></i>
        </a>
    </li>
    <li>
        <a href="<?php echo settings_id($GLOBALS['city'])[0]['soc_4']; ?>">
            <i class="fab fa-facebook"></i>
        </a>
    </li>
</ul>

<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?php include $path.'/../modules/breadcrumbs.php'; ?>

<section class="map">
    <div class="tabs contact-tabs">            
        <div class="tabs__body"> 
            <div class="container">
                <h1 class="contact-organization__title">Контакты</h1>
                <div class="map__container">
                    <div id="map" class="map__content">
                    </div>
                    <div class="map__contacts">
                        <?php include 'modules/map_contacts.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<?php include $path.'/../modules/contact-feed.php'; ?>

<script>

    DG.then(function() {

        /*function mapСontact(id) {
            $.ajax({
                type: "POST",
                url: '/api/map_contacts.php',
                data: {
                    'cityId': id
                },
                //dataType: 'json',
                beforeSend: function(){
                    $('#map_contacts').addClass('loading');
                },
                success: function(response) {
                    $('#map_contacts').html(response);
                    $('#map_contacts').removeClass('loading');
                }
            });
        }*/

        var map,
            myIcon,
            markers = DG.featureGroup(),
            myDivIcon;

        var center_lat = <?php echo settings_id($GLOBALS['city'])[0]['lat']; ?>;
        var center_lng = <?php echo settings_id($GLOBALS['city'])[0]['lng']; ?>;

        if ($(window).width() >= 992) {
            center_lng = center_lng - 0.15;
        }

        map = DG.map('map', {
            center: [center_lat, center_lng],
            zoom: 11
        });

        myIcon = DG.icon({
            iconUrl: '/assets/icons/map_icon.svg',
            iconSize: [25, 33]
        });

        <?
            foreach (settings() as $key => $value) {
        ?>
            var marker<?php echo $value['id']; ?> = DG.marker([<?php echo $value['lat']; ?>, <?php echo $value['lng']; ?>], {
                icon: myIcon
            }).addTo(markers);
        <?
            }
        ?>

        markers.addTo(map);

        markers.on('click', function(e) {
            console.log(e);
            //map.setView([e.latlng.lat, e.latlng.lng]);
        });

        //map.setView([0, 0]);
        $(document).on('click', '.map .tabs__link', function(e) {
            console.log('test');
            var lat = $(this).attr('data-lat');
            var lng = $(this).attr('data-lng');
            var id = $(this).attr('data-id');
            $('.map .tabs__link').removeClass('active');
            $(this).addClass('active');
            mapСontact(id);
            if ($(window).width() >= 992) {
                map.setView([lat, lng-0.15]);
            } else {
                map.setView([lat, lng]);
            }
            return false;
        });

        //mapСontact(<?php if($arrGet['city']){echo $arrGet['city'];} else {echo $GLOBALS['city'];} ?>);

    });
</script>
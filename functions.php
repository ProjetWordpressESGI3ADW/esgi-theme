<?php 
add_action("init", "menus");

function menus() {
    register_nav_menus(array(
        "main_menu" => "Menu principal",
        "secondary_menu" => "Menu secondaire"
    ));
}

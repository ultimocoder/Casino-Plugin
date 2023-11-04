<?php 

function onlinecasino_menu() {

add_menu_page("Online Casino", "Online casino","manage_options", "onlinecasinomenu", "onlinecasinomenu",'dashicons-money-alt','150');

add_submenu_page(
  "onlinecasinomenu",       // Parent menu slug
  "Shortcode & Instruction",        // Page title
  "Online casino Shortcode",        // Menu title
  "manage_options",        // Required capability to access the page
  "onlinecasino-shortcode",         // Unique menu slug
  "onlinecasinoinstructionsFun"  // Callback function to display content
);


add_submenu_page(
  "onlinecasinomenu",       // Parent menu slug
  "Casino list",        // Page title
  "Casino list",        // Menu title
  "manage_options",        // Required capability to access the page
  "onlinecasino-list",         // Unique menu slug
  "onlinecasinoUserListFun"  // Callback function to display content
);

}

add_action("admin_menu", "onlinecasino_menu");



function onlinecasinoinstructionsFun(){
	require_once plugin_dir_path( __FILE__ ) . 'onlinecasino-shortcode.php';
}

function onlinecasinoUserListFun(){
	require_once plugin_dir_path( __FILE__ ) . 'list-view.php';
}

function onlinecasinomenu(){
	require_once plugin_dir_path( __FILE__ ) . 'onlinecasino_menu.php';

}



?>
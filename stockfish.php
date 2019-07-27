<?php
    /*
    Plugin Name: WP Stockfish
    Description: This plugin lets you run the stockfish engine on wordpress!
    Author: Paulo Sérgio
    Version: 0.0.1
    Author URI: https://github.com/paulo101977/
    License: GPL2
    */

    define( 'ROOT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );


    include(ROOT_PLUGIN_PATH . 'src/widget/stockfish_widget.php');
?>
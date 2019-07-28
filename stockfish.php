<?php
    /*
    Plugin Name: WP Stockfish
    Description: This plugin lets you run the stockfish engine on wordpress!
    Author: Paulo Sérgio
    Version: 0.0.5
    Author URI: https://github.com/paulo101977/
    License: GPL2
    */

    define( 'ROOT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );


    include(ROOT_PLUGIN_PATH . 'src/widget/stockfish_widget.php');


    // TODO: move script functions to correctly file
    function load_wp_js_scripts() { 
        $FRONT_PATH = 'src/front';
        wp_register_script(
            'chess.min.js', 
            plugins_url( $FRONT_PATH . '/js/chess.min.js', __FILE__),
            array ('jquery'),                 
            false, 
            false
        );
        wp_register_script(
            'chessboard.js',
            plugins_url( $FRONT_PATH . '/js/chessboard-1.0.0.min.js', __FILE__ ),
            array ('chess.min.js'),
            false, 
            false
        );

        // enginegame
        wp_register_script(
            'enginegame.js',
            plugins_url( $FRONT_PATH . '/enginegame.js', __FILE__ ),
            array ('chessboard.js'),
            false, 
            false
        );

        //stockfish.js
        wp_register_script(
            'stockfish.js',
            plugins_url( $FRONT_PATH . '/stockfish.js', __FILE__ ),
            array ('enginegame.js'),
            false, 
            false
        );

        wp_enqueue_script('jquery');
        wp_enqueue_script('chess.min.js');
        wp_enqueue_script('chessboard.js');
        wp_enqueue_script('enginegame.js');
        wp_enqueue_script('stockfish.js');
    }

    add_action("wp_enqueue_scripts", "load_wp_js_scripts");


    function load_css_styles() {
        $FRONT_PATH = 'src/front';


        wp_register_style( 'common-style', plugins_url( $FRONT_PATH . '/css/style.css', __FILE__ ) );
        wp_register_style( 'chessboard.css', plugins_url( $FRONT_PATH . '/css/chessboard-1.0.0.min.css', __FILE__ ) );
        wp_enqueue_style( 'common-style' );
        wp_enqueue_style( 'chessboard.css' );
    }
    // Register style sheet.
    add_action( 'wp_enqueue_scripts', 'load_css_styles' );
?>
<?php
    /*
    Plugin Name: WP Stockfish
    Description: This plugin lets you run the stockfish engine on wordpress!
    Author: Paulo Sérgio
    Version: 0.0.1
    Author URI: https://github.com/paulo101977/
    License: GPL2
    */
    class Stockfish_Widget extends WP_Widget {

        // Main constructor
        public function __construct() {
            parent::__construct(
                'stockfish_widget',
                __( 'Stockfish Widget', 'text_domain' ),
                array(
                    'customize_selective_refresh' => true,
                )
            );
        }

        // TODO: implement
        // The widget form (for the backend )
        public function form( $instance ) {	
            /* ... */
        }
    
        // TODO: implement
        // Update widget settings
        public function update( $new_instance, $old_instance ) {
            /* ... */
        }
    
        // TODO: implement
        // Display the widget
        public function widget( $args, $instance ) {
           echo "<p>Test Widget Stockfish</p>";
        }
    
    }
    
    // Register the widget
    function register_stockfish_widget() {
        register_widget( 'Stockfish_Widget' );
    }
    add_action( 'widgets_init', 'register_stockfish_widget' );
?>
<?php

if ( !defined( 'ABSPATH' ) ) exit;

class Tramontana_Movie {

    function Tramontana_Movie() {
        add_action( 'init', [$this, 'regiter_post_type'] );
    }

    public function regiter_post_type() {
        $labels = array(
            "name"          => __( 'Pel&iacute;culas', 'tramontana' ),
            'singular_name' => __( 'Pel&iacute;cula', 'tramontana' ),
        );

        $args = array(
            'label'                 => __( 'Pel&iacute;culas', 'tramontana' ),
            'labels'                => $labels,
            'menu_position'         => 25,
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'delete_with_user'      => false,
            'show_in_rest'          => true,
            'has_archive'           => false,
            'show_in_menu'          => true,
            'show_in_nav_menus'     => true,
            'capability_type'       => 'post',
            'map_meta_cap'          => true,
            'hierarchical'          => false,
            'menu_icon'             => 'dashicons-video-alt2',
            'rewrite'               => array( 'slug' => 'movie' ),
            'query_var'             => true,
            'supports'              => array( 'title' ),
        );

        register_post_type( 'ttna_movie', $args );
    }

    public function addMovie($data) {
        // Create the movie
        $post = array(
            'post_title'    => $data->original_title,
            'post_status'   => 'publish',
            'post_type'     => 'ttna_movie'
        );
        $newMovieId = wp_insert_post($post);
    }

}

?>

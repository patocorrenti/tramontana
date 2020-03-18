<?php

if ( !defined( 'ABSPATH' ) ) exit;

class Tramontana_Shortcodes {

    var $api;

    function Tramontana_Shortcodes($api) {
        $this->api = $api;

        add_action( 'wp_enqueue_scripts', [$this,'enqueue_scripts']);

        add_shortcode('movie_addform', [$this,'shortcode_movie_addform']);
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'addmovie', plugins_url('/../assets/custom/css/addmovie.css', __FILE__));
    }

    public function shortcode_movie_addform() {
        $movies = new stdClass();

        if (isset($_POST['search_movie'])) {
            $movies = $this->api->searchMovie(filter_var($_POST['search_movie'], FILTER_SANITIZE_STRING));
        }

        ob_start();
        require( dirname(__FILE__) . '/../templates/frontend/add-movie.php');
        return ob_get_clean();
    }

}

?>

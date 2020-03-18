<?php

if ( !defined( 'ABSPATH' ) ) exit;

class Tramontana_Shortcodes {

    var $Api;
    var $Movie;

    function Tramontana_Shortcodes($api, $movie) {
        $this->Api = $api;
        $this->Movie = $movie;

        add_action( 'wp_enqueue_scripts', [$this,'enqueue_scripts']);
        add_shortcode('movie_addform', [$this,'shortcode_movie_addform']);
    }

    public function enqueue_scripts() {
        wp_enqueue_style( 'addmovie', plugins_url('/../assets/custom/css/add-movie.css', __FILE__));
        wp_enqueue_script( 'addmovie', plugins_url('/../assets/custom/js/add-movie.js', __FILE__), array('jquery'));
    }

    public function shortcode_movie_addform() {
        if (!is_user_logged_in()) {
            echo '<p>'.__('Debes iniciar sesi&oacute;n para poder agregar una pel&iacute;cula', 'tramontana').'</p>';
            return false;
        }

        $movies = new stdClass();

        if (
            isset($_POST['search_movie'])
            && wp_verify_nonce( wp_unslash($_POST['_wpnonce']), 'ttna_search_movie')
        ) {
            // Search movie
            $movies = $this->Api->searchMovie(filter_var($_POST['search_movie'], FILTER_SANITIZE_STRING));
        } elseif (
            isset($_POST['movie_id'])
            && wp_verify_nonce( wp_unslash($_POST['_wpnonce']), 'ttna_add_movie')
        ) {
            // Add movie
            $movieId = (int)array_keys($_POST['movie_id'])[0];
            if ($movieId) {
                $movieData = $this->Api->getMovie($movieId);
                if ($movieData) {
                    $newMovie = $this->Movie->addMovie($movieData);
                }
            }
        }

        ob_start();
        require( dirname(__FILE__) . '/../templates/frontend/add-movie.php');
        return ob_get_clean();
    }

}

?>

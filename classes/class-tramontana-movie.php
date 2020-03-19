<?php

if ( !defined( 'ABSPATH' ) ) exit;

class Tramontana_Movie {

    var $imgUrl;

    function Tramontana_Movie() {
        $this->imgUrl = 'http://image.tmdb.org/t/p/w500';
        add_action( 'init', [$this, 'regiter_post_type'] );
        $this->registerCustomFields();
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
            'has_archive'           => true,
            'show_in_menu'          => true,
            'show_in_nav_menus'     => true,
            'capability_type'       => 'post',
            'map_meta_cap'          => true,
            'hierarchical'          => false,
            'menu_icon'             => 'dashicons-video-alt2',
            'rewrite'               => array( 'slug' => 'movies' ),
            'query_var'             => true,
            'supports'              => array( 'title', 'thumbnail' ),
        );

        register_post_type( 'ttna_movie', $args );
    }

    public function registerCustomFields () {
        acf_add_local_field_group(array(
            'key' => 'ttna-movie-custom-fields',
            'title' => 'Details',
            'fields' => array(
                array(
                    'key' => 'ttna-movie-date',
                    'label' => 'Release Date',
                    'name' => 'ttna-movie-date',
                    'type' => 'text',
                    'readonly' => true,
                    'wrapper' => array( 'width' => '33.33' ),
                ),
                array(
                    'key' => 'ttna-movie-id',
                    'label' => 'Movie DB ID',
                    'name' => 'ttna-movie-id',
                    'type' => 'text',
                    'readonly' => true,
                    'wrapper' => array( 'width' => '33.33' ),
                ),
                array(
                    'key' => 'ttna-movie-imdb_id',
                    'label' => 'IMDB ID',
                    'name' => 'ttna-movie-imdb_id',
                    'type' => 'text',
                    'readonly' => true,
                    'wrapper' => array( 'width' => '33.33' ),
                ),
                array(
                    'key' => 'ttna-movie-poster_path',
                    'label' => 'Poster',
                    'name' => 'ttna-movie-poster_path',
                    'type' => 'text',
                    'readonly' => true,
                    'wrapper' => array( 'width' => '50' ),
                ),
                array(
                    'key' => 'ttna-movie-backdrop_path',
                    'label' => 'Backdrop',
                    'name' => 'ttna-movie-backdrop_path',
                    'type' => 'text',
                    'readonly' => true,
                    'wrapper' => array( 'width' => '50' ),
                ),
                array(
                    'key' => 'ttna-movie-original_title',
                    'label' => 'Original Title',
                    'name' => 'ttna-movie-original_title',
                    'type' => 'text',
                    'readonly' => true,
                    'wrapper' => array( 'width' => '66' ),
                ),
                array(
                    'key' => 'ttna-movie-original_lenguage',
                    'label' => 'Original Lenguage',
                    'name' => 'ttna-movie-original_lenguage',
                    'type' => 'text',
                    'readonly' => true,
                    'wrapper' => array( 'width' => '34' ),
                ),
                array(
                    'key' => 'ttna-movie-overview',
                    'label' => 'Overview',
                    'name' => 'ttna-movie-overview',
                    'type' => 'textarea',
                    'readonly' => true,
                ),
                array(
                    'key' => 'ttna-movie-popularity',
                    'label' => 'Popularity',
                    'name' => 'ttna-movie-popularity',
                    'type' => 'text',
                    'readonly' => true,
                    'wrapper' => array( 'width' => '33.33' ),
                ),
                array(
                    'key' => 'ttna-movie-vote',
                    'label' => 'Vote Average',
                    'name' => 'ttna-movie-vote',
                    'type' => 'text',
                    'readonly' => true,
                    'wrapper' => array( 'width' => '33.33' ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'ttna_movie',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'active' => true,
        ));
    }

    public function addMovie($data) {

        // Check if movie already exists
        $movieExists = $this->movieExists($data->id);
        if ($movieExists) {
            return $movieExists;
        }

        // Create the movie
        $post = array(
            'post_title'    => $data->original_title,
            'post_status'   => 'publish',
            'post_type'     => 'ttna_movie'
        );
        $newMovieId = wp_insert_post($post);
        // Custom fields
        update_field('ttna-movie-date', $data->release_date, $newMovieId);
        update_field('ttna-movie-id', $data->id, $newMovieId);
        update_field('ttna-movie-imdb_id', $data->imdb_id, $newMovieId);
        update_field('ttna-movie-poster_path', $data->poster_path, $newMovieId);
        update_field('ttna-movie-backdrop_path', $data->backdrop_path, $newMovieId);
        update_field('ttna-movie-original_title', $data->original_title, $newMovieId);
        update_field('ttna-movie-original_lenguage', $data->original_language, $newMovieId);
        update_field('ttna-movie-overview', $data->overview, $newMovieId);
        update_field('ttna-movie-popularity', $data->popularity, $newMovieId);
        update_field('ttna-movie-vote', $data->vote_average, $newMovieId);
        // Thumbnail
        $this->attachImage($this->imgUrl.$data->poster_path, $newMovieId);

        return get_post($newMovieId);
    }

    public function movieExists($id) {
        $args = array(
          'post_type' => 'ttna_movie',
          'meta_query' => array(
            array(
              'key' => 'ttna-movie-id',
              'value' => $id,
              'compare' => '='
            )
          )
        );
        $posts = get_posts( $args );
        return $posts[0];
    }

    private function attachImage($imageUrl, $postId, $desc = null) {
        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');

        if ( ! empty($imageUrl) ) {
            // Download file to temp location
            $tmp = download_url( $imageUrl );
            // Set variables for storage
            // fix file filename for query strings
            preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $imageUrl, $matches);
            $file_array['name'] = basename($matches[0]);
            $file_array['tmp_name'] = $tmp;
            // If error storing temporarily, unlink
            if ( is_wp_error( $tmp ) ) {
                @unlink($file_array['tmp_name']);
                $file_array['tmp_name'] = '';
            }
            // do the validation and storage stuff
            $id = media_handle_sideload( $file_array, $postId, $desc );
            // If error storing permanently, unlink
            if ( is_wp_error($id) ) {@unlink($file_array['tmp_name']);}
            add_post_meta($postId, '_thumbnail_id', $id, true);
        }
    }

}

?>

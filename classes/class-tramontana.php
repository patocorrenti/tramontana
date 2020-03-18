<?php

if ( !defined( 'ABSPATH' ) ) exit;

class Tramontana {

    var $Api;
    var $Movie;

    function Tramontana () {

        // Requires ACF plugin
        if (!class_exists('ACF')) {
            add_action('admin_notices', [$this, 'ACF_notice']);
            return false;
        }

        $this->Api = new Tramontana_API();
        $this->Movie = new Tramontana_Movie();

        new Tramontana_Shortcodes($this->Api, $this->Movie);

    }

    public function ACF_notice () {
        echo '
        <div class="notice notice-error is-dismissible">
            <p>
            '.__('Tramontana requiere el plugin Advanced Custom Fields', 'tramontana').'
            </p>
        </div>';
    }

}

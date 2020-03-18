<?php

if ( !defined( 'ABSPATH' ) ) exit;

class Tramontana_API {

    var $apiKey;
    var $apiUrl;

    function Tramontana_API() {
        $this->apiUrl = 'https://api.themoviedb.org/3/';
        $this->apiKey = 'bb9fba5e72d3b9a1637db4703231b146';
    }

    // Data: array("param" => "value") ==> index.php?param=value
    public function callAPI($method, $url, $data = false) {

        $curl = curl_init();

        // Set method
        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result);
    }

    public function searchMovie($query) {
        $url = $this->apiUrl.'search/movie?api_key='.$this->apiKey.'&language=en-US&include_adult=false&query='.urlencode($query);
        return $this->callAPI('GET', $url);
    }

    public function getMovie($movieId) {
        $url = $this->apiUrl.'movie/'.$movieId.'?api_key='.$this->apiKey;
        return $this->callAPI('GET', $url);
    }

}

?>


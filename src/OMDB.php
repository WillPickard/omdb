<?php namespace WillPickard\OMDB;

class OMDB {
    protected $basePath;
    protected $client;


    public function __construct(){
        $this->basePath = "http://www.omdbapi.com/";
        $this->client = new \GuzzleHttp\Client();
    }

    public static function getQuery(){
        return new OMDBQuery();
    }

    public function search(OMDBQuery $q){
        $q = "?" . $q->serialize();

    }


    private function go($endpoint){
        $url = $this->basePath . $endpoint;
        try {
            $res = $this->client->get($url);
        } catch(Exception $e){}

        $res = $res->json();
        return $res;
    }
}

class OMDBQuery{
    public $movieId = "";
    public $movieTitle = "";
    public $contentType = "json";
    public $year = "";
    public $type = ""; //type of thing to return. movie, series, or episode
    public $plot = "short"; //plot to return. short or full;
    public $withTomatoes = ""; //include tomatoes ratings
    public $callback = ""; //JSONP callback
    public $search = "";
    private $propMap = array(
        "movieId"       => "i",
        "movieTitle"    => "t",
        "contentType"   => "r",
        "year"          => "y",
        "type"          => "type",
        "plot"          => "plot",
        "withTomatoes"  => "tomatoes",
        "callback"      => "callback",
        "search"        => "s"
    );

    public function serialize(){
        $q = "";
        foreach($this->propMap as $prop => $k){
            if($this->has($prop)){
                $q .= $k . "=" . urlencode($this->{$prop}) . "&";
            }
        }
        //remove the last &
        $q = substr($q, 0, strlen($q) - 1);
        return $q;
    }
    public function setMovieId($movieId){
        $this->movieId = $movieId;
    }
    public function setMovieTitle($movieTitle){
        $this->movieTitle = $movieTitle;
    }
    public function setContentType($contentType){
        $this->contentType = $contentType;
    }
    public function setYear($year){
        $this->year = $year;
    }
    public function setType($type){
        $type = strtolower($type);
        if(array_search($type, array("movie", "series", "episode")) !== false) {
            $this->type = $type;
        }
    }
    public function setPlot($plot){
        $plot = strtolower($plot);
        if(array_search($plot, array("short", "full"))) {
            $this->plot = $plot;
        }
    }
    public function withTomatoes($with=false){
        $this->withTomatoes = $with;
    }
    public function setCallBack($c){
        $this->callback = $c;
    }
    public function setSearch($s){
        $this->search = $s;
    }
    /**
     * @param string $prop
     * @return bool
     */
    public function has($prop = ""){
        $has = false;
        if(property_exists($this, $prop)){
            $propVal = $this->{$prop};
            $has = ! (empty($propVal));
        }
        return $has;
    }

}
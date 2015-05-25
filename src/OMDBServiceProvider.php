<?php namespace WillPickard\OMDB;

use Illuminate\Support\ServiceProvider;

class OMDBServiceProvider extends ServiceProvider {

    public function register(){
        $this->app["OMDB"] = $this->app->share(function ($app){
            $o = new OMDB();
            return $o;
        });
    }
}
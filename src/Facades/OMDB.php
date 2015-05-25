<?php namespace WillPickard\OMDB\Facades;

use Illuminate\Support\Facades\Facade;

class OMDB extends Facade{
    protected static function getFacadeAccessor() { return 'OMDB'; }
}
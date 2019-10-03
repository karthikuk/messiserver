<?php 
namespace Moly\Providers;

use Moly\Supports\Facades\App;

class ServiceProvider {

    protected $app;

    public function __construct()
    {
        $this->app = App::resolve('app', true);
    }
}
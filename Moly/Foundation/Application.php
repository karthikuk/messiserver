<?php
namespace Moly\Foundation;

use Moly\Foundation\Providers\FoundationProvider;

class Application extends Container {

    protected static $instantiateCnt = 0;

    public function __construct()
    {
        static::$instantiateCnt++;

        $this->appSetup();

        $this->registerByFoundationProvider();

        $this->registerByServiceProviders();


    }

    protected function appSetup()
    {
        static::setInstance($this);

        $this->instance('app', $this);
    }

    protected function registerByFoundationProvider()
    {
        (new FoundationProvider)->register();
    }

    protected function registerByServiceProviders()
    {
       
        $appConfig = include(__DIR__."/../../config/app.config.php");

        $providers = $appConfig['providers'];

        if(is_array($providers))
        {
            foreach($providers as $provider)
            {
                (new $provider)->register();
            }
        }
    }

    protected function instance($abstract, $instance)
    {
        $this->instances[$abstract] = $instance;
    }

    

    public function loadHelpers()
    {
        require __DIR__.'/Helpers/Helpers.php';
        require __DIR__.'/../../routes/routes.php';
    }    
}
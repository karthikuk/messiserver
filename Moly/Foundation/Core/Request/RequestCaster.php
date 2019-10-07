<?php
namespace Moly\Server\Request;


trait RequestCaster {

    

    

    public function isRoute()
    {
       
        return pathinfo($this->uri, PATHINFO_EXTENSION) ? false : true;
    }

    public function isAsset()
    {
        return pathinfo($this->uri, PATHINFO_EXTENSION) ? true : false;
    }

    
}
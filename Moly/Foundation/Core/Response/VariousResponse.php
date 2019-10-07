<?php
namespace Moly\Server\Response;

use Moly\Server\Facades\MConfig;
use Symfony\Component\Mime\MimeTypes;

trait VariousResponse
{
   

    public function resources($file = null)
    {
        $path = pathinfo($file);

        $file = MConfig::get('path') . $file; 
     
        if(!@file_exists($file))
        {
            return $this->notFound();
        }

     
        $this->header('Content-Type', implode(";",(new MimeTypes)->getMimeTypes($path["extension"])));
        
        $this->header("Content-Length", filesize($file) );
        
        $this->header('Connection', 'close');
        
        $this->header('Host', MConfig::hostwithport());
        
        $this->body = file_get_contents($file);

        return $this;
    }

    
}
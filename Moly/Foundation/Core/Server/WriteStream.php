<?php
namespace Moly\Server;



class WriteStream 
{

    protected $socket = null;

    protected $buffer = null;

    public function __construct($socket = null, $buffer  = null)
    {
       $this->writeStreamProperties($socket, $buffer);
    }

    protected function writeStreamProperties($socket, $buffer) : self
    {
        $this->socket = $this->socket ?? $socket;

        $this->buffer = $this->buffer ?? $buffer;
        
        return $this;
    }

    public function doWrite($socket = null, $buffer = null) : self
    {
        return $this->writeStreamProperties($socket, $buffer)
                            ->write()
                            ->close();
    }

    protected function write() : self
    {
        @fwrite($this->socket, $this->buffer);

        return $this;
    }

    protected function close() : self
    {
        @fclose($this->socket);

        return $this;
    }
}








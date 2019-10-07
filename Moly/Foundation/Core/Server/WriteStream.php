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

        //stream_socket_sendto($this->socket, $this->buffer, STREAM_OOB);

        return $this;
    }

    protected function close() : self
    {
        stream_socket_shutdown ($this->socket , STREAM_SHUT_WR );

        @fclose($this->socket);

        return $this;
    }
}








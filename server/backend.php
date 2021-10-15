<?php

Class Backend
{
    // Any persistent database connections could be managed here.
    // todo: establish JWT for future calls.
    
    protected function respondWith($data, $headers = array())
    {
        if (is_array($headers) && count($headers))
            foreach ($headers as $set)
                header($set);

        echo $data;
    }
    
    public function __call($name, $args)
    {
        $this->respondWith("", array("HTTP/1.1 404 Not Found"));
    }
}

?>
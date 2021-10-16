<?php

require_once("../server/config.php");
require_once("../vendor/autoload.php");

use Firebase\JWT\JWT;

Class Backend
{
    // Any persistent database connections could be managed here.
    // todo: establish JWT for future calls.

    private $clock;
    private $issuer;
    private $encoding;
    private $jwt;

    function __construct($encoding = "HS256")
    {
        $this->clock = new DateTimeImmutable();
        $this->issuer = "localhost";
        $this->encoding = $encoding;
    }

    public function decodeJWT($jwt)
    {
        return JWT::decode($jwt, JTW_SECRET, array($this->encoding));
    }

    protected function issueJWT()
    {
        $data = [
            "iss" => $this->issuer,
            "iat" => $this->clock->getTimestamp(),
            "exp" => $this->clock->modify("+2 minutes")->getTimestamp(),
        ];

        $this->jwt = JWT::encode($data, JTW_SECRET, $this->encoding);
    }

    protected function renewJWT()
    {
        if (empty($this->jwt))
        {
            $this->issueJWT();
        }
        else
        {
            $decoded = $this->decodeJWT($this->jwt);
            $decoded["iat"] = $this->clock->getTimestamp();
            $decoded["exp"] = $this->clock->modify("+2 minutes")->getTimestamp();
            $this->jwt = JWT::encode($decoded, JTW_SECRET, $this->encoding);
        }
    }

    protected function respondWith($data, $headers = array())
    {
        header_remove();

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
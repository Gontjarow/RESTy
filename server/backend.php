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

        // Turns out $jwt doesn't survive between connections.
        $jwt = JWT::encode($data, JTW_SECRET, $this->encoding);
        $this->jwt = $jwt;
        $_SESSION["JWT"] = $jwt;
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

    protected function validateJWT($jwt)
    {
        // todo: This could be a single function-call from a framework.
        // For this demo, there's only one user, so I'll handwave this a little bit...
        // 1. Check that the JWT is well formed.
        //  A) three segments: "header.body.signature" (base64url)
        //  B) header/signature should decode into valid JSON
        // 2. Check the signature.
        //  A) "alg" should match stored JWT
        //  B) Re-encode stored JWT and check signatures match.
        // 3. Check the standard claims.
        //  A) "iss" should match us.
        //  B) "exp" shouldn't be in the past.

        if ($_SESSION["JWT"] == $jwt)
            return true;
        else
            return false;
    }

    protected function broadcastJWT()
    {
        $this->respondOK($this->jwt);
    }

    // todo: These could go into a Response class.
    protected function respondWith($data, $headers = array())
    {
        header_remove();

        if (is_array($headers) && count($headers))
            foreach ($headers as $set)
                header($set);

        echo $data;
    }

    protected function respondOK($data)
    {
        $this->respondWith($this->json($data),
            array("Content-Type: application/json", "HTTP/1.1 200 OK"));
    }

    protected function respondNotAcceptable($data)
    {
        $this->respondWith($this->json($data, true),
            array("Content-Type: application/json", "HTTP/1.1 406 Not Acceptable"));
    }

    protected function respondUnauthorized($data)
    {
        $this->respondWith($this->json($data, true),
            array("Content-Type: application/json", "HTTP/1.1 401 Unauthorized"));
    }

    protected function respondNotFound($data)
    {
        $this->respondWith($this->json($data, true),
            array("Content-Type: application/json", "HTTP/1.1 404 Not Found"));
    }

    protected function json($content = "", $error = false)
    {
        return "{\"error\":".json_encode($error).", \"content\":".json_encode($content)."}";
    }

    public function __call($name, $args)
    {
        $this->respondWith("", array("HTTP/1.1 404 Not Found"));
    }
}

?>
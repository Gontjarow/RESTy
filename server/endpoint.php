<?php

require_once("../server/config.php");
require_once("../server/backend.php");

class Endpoint extends Backend
{
    // todo: Validate input before using endpoints?

    public function getBooks($query = array())
    {
        $this->renewJWT();

        if (!is_array($query) || empty($query) || !is_numeric($query["ISBN"]))
        {
            $this->respondNotAcceptable("ISBN must be a number");
            exit();
        }

        $url = BOOKS_URI."isbn/".$query["ISBN"].".json";
        $data = file_get_contents($url);

        if (empty($data))
        {
            $this->respondNotFound("Something went wrong");
            exit();
        }

        $this->respondWith($data,
            array("Content-Type: application/json", "HTTP/1.1 200 OK"));
    }

    public function getMovies($query = array())
    {
        $this->renewJWT();

        if (!is_array($query) || empty($query))
        {
            $this->respondNotAcceptable("Request was empty");
            exit();
        }

        if (count($query) != 3
        || empty($query["Title"]))
        {
            $this->respondNotAcceptable("Required: Title");
            exit();
        }

        $url = MOVIES_URI."?apikey=".MOVIES_API."&t=".$query["Title"];
        if (!empty($query["Plot"])) $url.="&plot=".$query["Plot"];
        if (!empty($query["Year"])) $url.="&y=".$query["Year"];

        $data = file_get_contents($url);
        $arr = json_decode($data, true);

        if ($arr["Response"] == "True")
        {
            $this->respondWith($data,
                array("Content-Type: application/json", "HTTP/1.1 200 OK"));
        }
        else
        {
            $this->respondNotFound("Movie not found");
        }
    }
}

?>

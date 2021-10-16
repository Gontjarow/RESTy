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
            $this->respondWith("ISBN must be a number!", array("HTTP/1.1 406 Not Acceptable"));
            exit();
        }

        $url = BOOKS_URI."isbn/".$query["ISBN"].".json";
        $data = file_get_contents($url);

        if (empty($data))
        {
            $this->respondWith("Something went wrong!", array("HTTP/1.1 404 Not Found"));
            exit();
        }

        $this->respondWith($data, array("HTTP/1.1 200 OK"));
    }

    // IMDB ID: tt1234567
    public function getMovieByIMDBId($id)
    {
        $url = MOVIES_URI."?apikey=".MOVIES_API."&i=".$id;

        echo "Movie!"; // todo
    }

    public function getMovieByTitle($title)
    {
        $this->renewJWT();

        $url = MOVIES_URI."?apikey=".MOVIES_API."&t=".$title;

        $data = file_get_contents($url);

        //? $stuff = json_decode($data);
        //? $stuff = json_encode($data);
        $this->respondWith($data, array("HTTP/1.1 200 OK"));
        //echo "Movie!"; // todo
    }
}

?>

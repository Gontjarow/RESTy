<?php

require_once("../server/config.php");
require_once("../server/backend.php");

class Endpoint extends Backend
{
    // todo: Validate input before using endpoints?

    public function getBookByISBN()
    {
        echo "Book!"; // todo
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

<?php

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
        $url = MOVIES_URI."?apikey=".MOVIES_API."&t=".$title;

        echo "Movie!"; // todo
    }
}

?>

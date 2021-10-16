<!DOCTYPE html>
<html>
<head>
<title>Search Engine (tm)</title>
</head>
<body>

<form action="client.php/getMovies" method="GET">

    <label>Search movies</label>

    <div>
        <label for="Search">Title</label>
        <input type="text" pattern="[a-zA-Z0-9 :_]+" placeholder="Search..." name="Title" id="Title">

        <label for="Year">Year</label>
        <input type="text" pattern="[0-9]+" placeholder="Year (optional)" name="Year" id="Year">

        <label for="Plot">Plot:</label>
        <select name="Plot" id="Plot">
            <option value="short" selected>Short</option>
            <option value="full">Full</option>
        </select>
        <button type="submit">Search</button>
    </div>
</form>

<form action="client.php/getBooks" method="GET">

    <label>Search books</label>

    <div>
        <label for="Search">ISBN</label>
        <input type="text" pattern="[0-9]+" placeholder="Search..." name="ISBN" id="ISBN">
        <button type="submit">Search</button>
    </div>
</form>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
<title>Search Engine (tm)</title>
</head>
<body>

<form action="index.php" method="GET">

    <label>Search for</label>

    <div>
        <div style="display:inline-block">
            <input name="Category" type="radio" id="Books" value="Books">
            <label>Books</label>
        </div>
        <div style="display:inline-block">
            <input name="Category" type="radio" id="Movies" value="Movies" checked="checked">
            <label>Movies</label>
        </div>
    </div>

    <input type="text" pattern="[a-zA-Z0-9 :_]+" placeholder="Search..." class="form-input" name="txt" id="txt">

    <?php include 'client.php';?>

</div>

</body>
</html>

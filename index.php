<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Hub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        include('db.php');
    ?>

    <div class="header">
        <h1>Welcome to Library Hub</h1>
        <div class="nav-links">
            <a href="upload.php">Upload</a>
            <a href="update.php">Update</a>
            <a href="delete.php">Delete</a>
        </div>
    </div>

    <div class="navbar">
        <a href="index.php">All</a>
        <?php
        //iya nabutang ro genre
        $genres = ['Fantasy', 'Adventure', 'Romance', 'Horror', 'Mystery'];

        // Generate genre links
        foreach ($genres as $genre) {
        echo '<a href="index.php?genre=' . urlencode($genre) . '">' . $genre . '</a>';
        }
         ?>
    </div>

    <div class="book-collection">
        <?php
        // halin sa database ro book ag kung siing genre halin
        $selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : 'All';
        $sql = ($selectedGenre === 'All') ? "SELECT * FROM tbl_book" : "SELECT * FROM tbl_book WHERE genre = '$selectedGenre'";
        $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="book">';
        echo '<img src="images/' . $row["image"] . '" alt="' . $row["title"] . '">';
        echo '<h2>' . $row["title"] . '</h2>';
        echo '<p>Author: ' . $row["author"] . '</p>';
        echo '<p>Genre: ' . $row["genre"] . '</p>';
        echo '<p>Publication Year: ' . $row["publication_year"] . '</p>';
        echo '</div>';
    }
    } else {
            echo '<p>No books found</p>';
    }

    $conn->close();
    ?>
    </div>
</body>
</html>

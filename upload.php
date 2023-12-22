<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="UUD.css">
</head>
<body>
    <?php
    include('db.php');

    // Process it upload
    $uploadMessage = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $genre = $_POST['genre'];
        $publicationYear = $_POST['publication_year'];

        // Kara kampi dapat may images nga folder name agud idto tanan pic it book
        $targetDir = 'images/';
        $targetFile = $targetDir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // boook details para sa database
            $sql = "INSERT INTO tbl_book (title, author, genre, publication_year, image) VALUES ('$title', '$author', '$genre', $publicationYear, '" . basename($_FILES['image']['name']) . "')";
            if ($conn->query($sql) === TRUE) {
                $uploadMessage = '<p class="success">Book uploaded successfully!</p>';
            } else {
                $uploadMessage = '<p class="error">Error uploading book: ' . $conn->error . '</p>';
            }
        } else {
            $uploadMessage = '<p class="error">Error uploading file.</p>';
        }
    }
    ?>

    <div class="container mt-5">
        <h1>Upload Book</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
            <label for="author">Author:</label>
            <input type="text" class="form-control" id="author" name="author" required>
            </div>

            <div class="form-group">
                <label for="genre">Genre:</label>
                <select class="form-control" id="genre" name="genre" required>
                    <option value="Fantasy">Fantasy</option>
                    <option value="Adventure">Adventure</option>
                    <option value="Romance">Romance</option>
                    <option value="Horror">Horror</option>
                    <option value="Mystery">Mystery</option>
                </select>
            </div>

            <div class="form-group">
            <label for="publication_year">Publication Year:</label>
            <input type="number" class="form-control" id="publication_year" name="publication_year" required>
            </div>

            <div class="form-group">
            <label for="image">Book Cover Image:</label>
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
            </div>

            <?php echo $uploadMessage;?>

            <div class="form-group">
            <button type="submit" class="btn btn-primary">Upload</button>
            <a href="index.php" class="btn btn-danger">Go Back</a>
            </div>

        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

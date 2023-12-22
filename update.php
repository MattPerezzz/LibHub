<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="UUD.css">
</head>
<body>
    <?php
    include('db.php');

    // para mag guwa sa option ro mga books
    $bookListSql = "SELECT book_id, title FROM tbl_book";
    $bookListResult = $conn->query($bookListSql);

    if (isset($_GET['book_id'])) {
        $book_id = $_GET['book_id'];

        $sql = "SELECT * FROM tbl_book WHERE book_id = $book_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            $row = array(
                'title' => '',
                'author' => '',
                'genre' => '',
                'publication_year' => '',
            );
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $author = $_POST['author'];
            $genre = $_POST['genre'];
            $publicationYear = $_POST['publication_year'];

            if (!empty($_FILES['image']['name'])) {
                $targetDir = __DIR__ . '/images/';
                $targetFile = $targetDir . basename($_FILES['image']['name']);

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    
                    $sql = "UPDATE tbl_book SET title = '$title', author = '$author', genre = '$genre', publication_year = $publicationYear, image = '" . basename($_FILES['image']['name']) . "' WHERE book_id = $book_id";

                    if ($conn->query($sql) === TRUE) {
                        $success_message = 'Book updated successfully!';
                    } else {
                        $error_message = 'Error updating book: ' . $conn->error;
                    }
                } else {
                    $error_message = 'Error uploading file.';
                }
        }else { //else code maskin di baylohan ro pic ga process gihapon
                $sql = "UPDATE tbl_book SET title = '$title', author = '$author', genre = '$genre', publication_year = $publicationYear WHERE book_id = $book_id";
                if ($conn->query($sql) === TRUE) {
                    $success_message = 'Book updated successfully!';
                } else {
                    $error_message = 'Error updating book: ' . $conn->error;
                }
            }
        }
    } else {
        $row = array(
            'title' => '',
            'author' => '',
            'genre' => '',
            'publication_year' => '',
        );
    }
    ?>
    
    <div class="container mt-5">
        <h1>Update Book</h1>
        <form action="update.php?book_id=<?php echo $book_id; ?>" method="post" enctype="multipart/form-data">
            <!--kara ga pili it book-->
            <div class="form-group">
                <label for="selected_book">Select Book to Update:</label>
                <select class="form-control" id="selected_book" name="selected_book">
                <?php
                while ($book = $bookListResult->fetch_assoc()) {
                echo '<option value="' . $book['book_id'] . '">' . $book['title'] . '</option>';
                }
                ?>
                </select>
            </div>
            <button type="button" class="btn btn-success" onclick="selectBook()">Select Book</button>

            <!-- Kaara uman may option pang genre -->
            <div class="form-group">
                <label for="genre">Genre:</label>
                <select class="form-control" id="genre" name="genre" required>
                <option value="" <?php echo ($row['genre'] == '') ? 'selected' : ''; ?>>Select Genre</option>
                    <?php
                    $genres = ['Fantasy', 'Adventure', 'Romance', 'Horror', 'Mystery'];
                    foreach ($genres as $genre) {
                        echo '<option value="' . $genre . '" ' . (($row['genre'] == $genre) ? 'selected' : '') . '>' . $genre . '</option>';
                    }
                    ?>
                </select>
            </div>

            <!-- Details it book nga uploaded na -->
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title']; ?>" required>
            </div>

            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo $row['author']; ?>" required>
            </div>

            <div class="form-group">
                <label for="publication_year">Publication Year:</label>
                <input type="number" class="form-control" id="publication_year" name="publication_year" value="<?php echo $row['publication_year']; ?>" required>
            </div>

            <div class="form-group">
                <label for="image">Book Cover Image:</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>
            <!-- Message status kung goods ro pag update -->
            <?php
            if (isset($error_message)) {
                echo '<p class="error">' . $error_message . '</p>';
            }
            if (isset($success_message)) {
                echo '<p class="success">' . $success_message . '</p>';
            }
            ?>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-danger">Go Back</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        function selectBook() {
            var selectedBookId = document.getElementById('selected_book').value;
            window.location.href = 'update.php?book_id=' + selectedBookId;
        }
    </script>
</body>
</html>

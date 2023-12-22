<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="UUD.css">
</head>
<body>
    <?php
    include('db.php');

    // display books sa options
    $bookListSql = "SELECT book_id, title FROM tbl_book";
    $bookListResult = $conn->query($bookListSql);

    $successMessage = '';
    $errorMessage = '';

    //checking data sa database ag pag sueod sa page ag para sa pag delete
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['selected_book'])) {
            $book_id = $_POST['selected_book'];

            $sql = "SELECT * FROM tbl_book WHERE book_id = $book_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $deleteSql = "DELETE FROM tbl_book WHERE book_id = $book_id";
                if ($conn->query($deleteSql) === TRUE) {
                    $successMessage = 'Book deleted successfully!';
                } else {
                    $errorMessage = 'Error deleting book: ' . $conn->error;
                }
            } else {
                $errorMessage = 'Book not found.';
            }
        }
    }
    ?>

    <div class="container mt-5">
        <h1>Delete Book</h1>

        <form action="delete.php" method="post">
            <div class="form-group">
                <label for="selected_book">Select Book to Delete:</label>
                <select class="form-control" id="selected_book" name="selected_book">
                <?php
                while ($book = $bookListResult->fetch_assoc()) {
                echo '<option value="' . $book['book_id'] . '">' . $book['title'] . '</option>';
                }
                ?>
                </select>
            </div>
                <?php

        //status message
        if (!empty($successMessage)) {
            echo '<p class="success">' . $successMessage . '</p>';
        }
        if (!empty($errorMessage)) {
            echo '<p class="error">' . $errorMessage . '</p>';
        }
        ?>
            <div class="form-group">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="index.php" class="btn btn-primary">Go Back</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

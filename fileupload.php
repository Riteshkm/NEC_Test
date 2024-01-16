<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .error{
            color:red;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark navbar-expand-sm bg-dark">
        <div class="container">
        <a href="/" class="navbar-brand">
        <i class="fas fa-blog"></i> &nbsp;
        <?php $user = $_SESSION['user']; ?>
        Welcome, <?=$user['name']?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbarCollapse" class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="logout.php" class="nav-link active">
                    Logout
                </a>
            </li>
        </ul>
        </div>

    </div>
</nav>
<div class="container mt-5">
    <h1 class="mb-4">File Upload</h1>

    <div id="fileUploadForm">
        <form id="uploadForm" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" class="form-control-file" id="file" name="file" accept=".jpg, .jpeg, .png, .gif" required>
            </div>
            <input type="submit" class="btn btn-info" value="Upload">
        </form>
        <div id="uploadResult"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $("#uploadForm").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "crud.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $("#uploadResult").html(response);
                },
                error: function () {
                    $("#uploadResult").html("Error uploading file.");
                }
            });
        });
    });
</script>
</body>
</html>
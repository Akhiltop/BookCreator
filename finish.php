<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Finish</title>
<style>
    .button {
        margin-top: 10px;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }
    .button:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>
<div class="container">
    <h2>Finish</h2>
    <form method="post" action="pdf_template.php">
        <button type="submit" class="button">Generate PDF</button>
    </form>
</div>
</body>
</html>

<?php


session_start();


if (!isset($_SESSION['frontpage'])) {
  $_SESSION['frontpage'] = [
    'text' => 'Book Name',
    'backgroundImage' => 'background1.jpg',
    'author' => 'Your Name'
  ];
}


$frontpage = $_SESSION['frontpage'];


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update $frontpage with form data
    $frontpage['text'] = $_POST['book_name'] ?? $frontpage['text'];
    $frontpage['author'] = $_POST['author_name'] ?? $frontpage['author'];
    // Handle file upload for front cover (you might want to validate and handle this properly)
    $frontpage['backgroundImage'] = $_POST['front_encoded']??$frontpage['backgroundImage'];


    $_SESSION['frontpage'] = $frontpage;
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Front Cover</title>
<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    display: flex;
  }

  .page-container {
    display: flex;
    flex-direction: column;
    gap: 10px; 
    padding: 20px;
    width: 60vw; 
    align-items: center;
  }

  .page {
    position: relative;
    width: calc(56.56vh); 
    height: calc(80vh); 
    border: 1px solid black;
    padding: 10px;
    box-sizing: border-box;
    cursor: pointer;
  }

  .page.selected {
    background-color: #e0e0e0; 
  }

  .header-box,
  .written-box {
    position: absolute;
    border: 1px solid #ccc;
    background: transparent;
    
    font-size: 9vh;
    resize: none;
    pointer-events: none; /* Disable direct editing */
  }

  .header-box {
    top: 10px;
    left: 10px;
    width: calc(100% - 20px);
    height: 40vh;
  }

  .written-box {
    bottom: 10px;
    right: 10px;
    width: 80%;
    height: 3vh;
    font-size: 2.5vh;
  }

  .container {
    position: fixed;
    top: 0;
    right: 0;
    height: 100%;
    width: 25vw;
    padding: 1.5vh;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
  }

  .button {
    margin-top: 1.5vh;
    padding: 1.5vh;
    width: 100%;
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

  
  form {
    width:100%;
    display: flex;
    flex-direction: column;
    gap: 1.5vh;
    font-size:1.5vh;
    
    
  }

  input{
    font-size:1.5vh;
  }


  input[type="text"],
  input[type="file"] {
    width: 100%;
    padding: 1.5vh;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
  }

  input[type="submit"] {
    width: 100%;
    margin-top: 1.5vh;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    padding:1.5vh;
    transition: background-color 0.3s;
  }

  input[type="submit"]:hover {
    background-color: #45a049;
  }

  h2{
    font-size:3vh; 
  }
</style>
</head>
<body>
<div class="page-container">
    <!-- Display pages here -->
    <h2>Front Cover Page</h2>
    
    <div class="page">
        <textarea class="header-box"><?php echo $frontpage['text']; ?></textarea>
        <textarea class="written-box">Written By <?php echo $frontpage['author']; ?></textarea>
        <img id="frontCover" src="<?php echo $frontpage['backgroundImage']; ?>" width="100%" height="100%">
    </div>
</div>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <label for="bookName">Name of the Book</label>
        <input type="text" id="bookName" name="book_name" value="<?php echo $frontpage['text']; ?>">
        <label for="authorName">Author of the Book</label>
        <input type="text" id="authorName" name="author_name" value="<?php echo $frontpage['author']; ?>">
        <label for="frontCover">Upload front cover</label>
        <input type="file" id="frontCoverInput" name="front_cover">
        <input type="text" style="display:none;" id="frontencoded" name="front_encoded" value="<?php echo $frontpage['backgroundImage']; ?>">

        <input type="submit" value="Save Changes">
    </form>
    <button class="button" id="frontnextstep">Next Steps</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update live preview
    document.getElementById('bookName').addEventListener('input', function() {
        document.querySelector('.header-box').innerText = this.value;
    });
    
    document.getElementById('authorName').addEventListener('input', function() {
        document.querySelector('.written-box').innerText = 'Written By ' + this.value;
    });
    
    // Update image preview with base64 encoded image
    document.getElementById('frontCoverInput').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('frontCover').src = e.target.result;
                document.getElementById('frontencoded').value=e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});
document.getElementById('frontnextstep').addEventListener('click', function() {
    // Redirect to back.php
    window.location.href = 'back.php';
});
</script>
</body>
</html>

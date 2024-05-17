<?php

session_start();

$backpage = [
  'text' => 'Book Name',
  'author' => 'Your Name',
  'authorImage' => 'background1.jpg',
  'backgroundImage' => 'background1.jpg',
  'authorMessage' => 'Your Message',
];



// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update $backpage with form data
    $backpage['text'] = $_POST['book_name'] ?? $backpage['text'];
    $backpage['author'] = $_POST['author_name'] ?? $backpage['author'];
    $backpage['authorMessage'] = $_POST['author_message'] ?? $backpage['authorMessage'];
    // Handle file upload for back cover
    $backpage['backgroundImage'] = $_POST['back_encoded']??$backpage['backgroundImage'];
    $backpage['authorImage'] = $_POST['back_encoded_author']??$backpage['authorImage'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Back Cover</title>
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
    width: 56.56vh; 
    height: 80vh; 
    border: 1px solid black;
    padding: 10px;
    box-sizing: border-box;
    cursor: pointer;
    background-image: url("<?php echo $backpage['backgroundImage']; ?>");
  }

  .page.selected {
    background-color: #e0e0e0; 
  }

  .header-box,
  .written-box {
    
    border: 1px solid #ccc;
    background: transparent;
    font-size: 5vh;
    resize: none;
    pointer-events: none; /* Disable direct editing */
  }

  .header-box {
    
    width: calc(100% - 20px);
    height: 6vh;
    
  }

  .written-box {
   
    width: 80%;
    height: 3vh;
    font-size: 2vh;
  }

  .container {
    position: fixed;
    top: 0;
    right: 0;
    height: 100%;
    width: 25vw;
    padding: 10px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
  }

  .button {
    margin-top: 10px;
    padding: 10px;
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
    font-size: 1.5vh;
    
  }

  input{
    font-size: 1.5vh;
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

  p{
    font-size:1.5vh;
  }

  h2{
    font-size:3vh; 
  }
  
</style>
</head>
<body>
<div class="page-container">
    <!-- Display pages here -->
    <h2>Back Cover Page</h2>
    
    <div class="page" id="pageimage">
        
        
        <textarea class="header-box"><?php echo $backpage['text']; ?></textarea>
        <textarea class="written-box">Written By <?php echo $backpage['author']; ?></textarea>
        <hr/>
        <div style="display:flex">
            <div style="width:30%">
                <img id="backCover" src="<?php echo $backpage['authorImage']; ?>" width="100%"/>
                
                <p id="authorN"><?php echo $backpage['author']; ?></p>
            </div>
            <div>
                <p id="authorMsg"><?php echo $backpage['authorMessage']; ?></p>
           </div>   
        </div>
        <hr/>
        
            <p>Published by BriBooks.</p>
            <p>BriBooks is the world's leading children creative writing platform,enabling children to learn creative writing and publish their books on global outlets such as Amazon. Powered by a cutting-edge AI system, BriBooks combines the complete process of ideation,creativity,book writing,publishing,and selling on one single platform.</p> 
            <br/>
            <p>© BriBooks</p>
            <hr/>
            <div style="display:flex">
              <div style="width:70%">
                  <p>www.bribooks.com</p>
                  <p>Preview copy for limited distribution</p>
              </div >
                  
              <div style="width:30%">
              <img id="qrimage" src="<?php echo $backpage['backgroundImage']; ?>" width="100%">
              </div>  
            </div>

    </div>
</div>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <label for="bookName">Name of the Book</label>
        <input type="text" id="bookName" name="book_name" value="<?php echo $backpage['text']; ?>">
        <label for="authorName">Author of the Book</label>
        <input type="text" id="authorName" name="author_name" value="<?php echo $backpage['author']; ?>">
        <label for="authorMessage">Author Message</label>
        <input type="text" id="authorMessage" name="author_message" value="<?php echo $backpage['authorMessage']; ?>">
        <label for="backCover">Upload back cover</label>
        <input type="file" id="backCoverInput" name="back_cover">
        <input type="text" style="display: none;" id="backencoded" name="back_encoded" value="<?php echo $backpage['backgroundImage']; ?>">
        <label for="backCoverAuthor">Upload Author Image</label>
        <input type="file" id="backCoverInputAuthor" name="back_cover_author">
        <input type="text" style="display: none;" id="backencodedauthor" name="back_encoded_author" value="<?php echo $backpage['authorImage']; ?>">
  
        <input type="submit" value="Save Changes">
    </form>
    <button class="button" id="backnextstep">Next Steps</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update live preview
    document.getElementById('bookName').addEventListener('input', function() {
        document.querySelector('.header-box').innerText = this.value;
    });
    
    document.getElementById('authorName').addEventListener('input', function() {
        document.querySelector('.written-box').innerText = 'Written By ' + this.value;
        document.querySelector('#authorN').innerText = this.value;
    });

    document.getElementById('authorMessage').addEventListener('input', function() {
        document.querySelector('#authorMsg').innerText = this.value;
    });
    
    // Update image preview with base64 encoded image
    document.getElementById('backCoverInput').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('pageimage').style.backgroundImage = 'url("' + e.target.result + '")';;
                document.getElementById('backencoded').value=e.target.result;
                document.getElementById('qrimage').src=e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
    document.getElementById('backCoverInputAuthor').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('backCover').src = e.target.result;
                document.getElementById('backencodedauthor').value=e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
});
document.getElementById('backnextstep').addEventListener('click', function() {
    // Redirect to finish.php
    window.location.href = 'finish.php';
});
</script>
</body>
</html>

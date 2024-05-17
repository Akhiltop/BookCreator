<?php

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome Page</title>
<style>
  body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #f0f0f0;
  }
  
  .container {
    text-align: center;
  }
  
  h1 {
    font-size: 2em;
    color: #333;
  }
  
  h2 {
    font-size: 1.5em;
    color: #666;
    margin-top: 10px;
  }
  
  button {
    padding: 10px 20px;
    font-size: 1.2em;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  
  button:hover {
    background-color: #45a049;
  }
</style>
</head>
<body>
  <div class="container">
    <h1>Welcome User</h1>
    <h2>Start writing your next bestseller today!</h2>
    <button id="writeButton">Write a book</button>
  </div>
  <script>
    // Add event listener to the button
    document.getElementById('writeButton').addEventListener('click', function() {
      // Redirect to editor.php
      window.location.href = 'editor.php';
    });
  </script>
</body>
</html>

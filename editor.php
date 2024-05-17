<?php
session_start();

// Initialize pages if not already set
if (!isset($_SESSION['pages'])) {
    $_SESSION['pages'] = [
        ['text' => 'Text 1', 'backgroundImage' => 'background1.jpg'],
    ];
}

$pages = $_SESSION['pages'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        $selectedPage = $_POST['selected-page'];
        
        if ($_POST['action'] == 'set-background') {
            if (isset($_POST['background_encoded']) && !empty($_POST['background_encoded'])) {
                $pages[$selectedPage - 1]['backgroundImage'] = $_POST['background_encoded'];
            }
        } elseif ($_POST['action'] == 'add-page') {
            $defaultPage = [
                'text' => 'New Text',
                'backgroundImage' => 'background1.jpg'
            ];
            array_splice($pages, $selectedPage, 0, [$defaultPage]);
        } elseif ($_POST['action'] == 'delete-page') {
            if (isset($pages[$selectedPage - 1])) {
                unset($pages[$selectedPage - 1]);
                $pages = array_values($pages); // Re-index the array
            }
        } elseif ($_POST['action'] == 'save-text') {
            $pages[$selectedPage - 1]['text'] = $_POST['page_text'];
        }
        $_SESSION['pages'] = $pages; // Save the updated pages array back to session
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editor Page</title>
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
    width: calc((100vw - 270px));
    align-items: center;
  }

  .page {
    width: calc((100vw - 400px));
    height: calc((100vw - 400px) / 1.4141);
    border: 1px solid black;
    padding: 10px;
    box-sizing: border-box;
    position: relative;
    cursor: pointer;
  }

  .page.selected {
    background-color: #e0e0e0;
  }

  .text-box {
    position: absolute;
    top: 10px;
    left: 10px;
    width: 50%;
    height: calc(100% - 20px);
    border: 1px solid #ccc;
    box-sizing: border-box;
    resize: none;
    background: transparent;
    color: black;
    font-size: 20px;
  }

  .container {
    position: fixed;
    top: 0;
    right: 0;
    height: 100%;
    width: 200px;
    padding: 10px;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .button {
    margin-bottom: 10px;
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
</style>
</head>
<body>
<div class="page-container">
    <?php foreach ($pages as $key => $page): ?>
        <h2>Page <?php echo $key + 1; ?></h2>
        <div class="page <?php echo ($key === (isset($_POST['selected-page']) ? ($_POST['selected-page'] - 1) : 0)) ? 'selected' : ''; ?>" data-page="<?php echo $key + 1; ?>" onclick="selectPage(<?php echo $key + 1; ?>)">
            <textarea class="text-box" data-page-text="<?php echo $key + 1; ?>"><?php echo htmlspecialchars($page['text']); ?></textarea>
            <img src="<?php echo htmlspecialchars($page['backgroundImage']); ?>" width="100%" height="100%">
        </div>
    <?php endforeach; ?>
</div>
<div class="container">
    <form method="post" enctype="multipart/form-data" id="editorForm">
        <input type="hidden" name="selected-page" id="selected-page" value="<?php echo isset($_POST['selected-page']) ? $_POST['selected-page'] : 1; ?>">
        <input type="hidden" name="background_encoded" id="background_encoded">
        <input type="hidden" name="page_text" id="page_text">
        <input type="file" name="background-image" id="background-image" style="display: none;" onchange="handleFileSelect(event)">
        <button class="button" name="action" value="set-background" onclick="document.getElementById('background-image').click(); return false;">Set Background</button>
        <button class="button" name="action" value="add-page" onclick="document.getElementById('selected-page').value = parseInt(document.getElementById('selected-page').value);">Add Page</button>
        <button class="button" name="action" value="delete-page" onclick="document.getElementById('selected-page').value = parseInt(document.getElementById('selected-page').value);">Delete Page</button>
        <button class="button" name="action" value="save-text" onclick="saveText()">Save Text</button>
    </form>
    <button class="button" id="editornextstep">Next Steps</button>
</div>

<script>
document.getElementById('editornextstep').addEventListener('click', function() {
    window.location.href = 'front.php';
});

function selectPage(pageNumber) {
    document.getElementById('selected-page').value = pageNumber;
    var pages = document.querySelectorAll('.page');
    pages.forEach(function(page) {
        page.classList.remove('selected');
    });
    var selectedPage = document.querySelector('.page[data-page="' + pageNumber + '"]');
    selectedPage.classList.add('selected');
}

function handleFileSelect(event) {
    var file = event.target.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function(e) {
        var imgSrc = e.target.result;
        document.getElementById('background_encoded').value = imgSrc;
        var selectedPage = document.querySelector('.page.selected img');
        selectedPage.src = imgSrc;

    };
    
    reader.readAsDataURL(file);
}

function saveText() {
    var selectedPage = document.getElementById('selected-page').value;
    var textBox = document.querySelector('.text-box[data-page-text="' + selectedPage + '"]');
    document.getElementById('page_text').value = textBox.value;
    document.getElementById('editorForm').submit();
}
</script>
</body>
</html>

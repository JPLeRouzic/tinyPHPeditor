<?php

/*
 * This code receives two arguments:
 * - The content to edit (a post or acomment)
 * - The file path where to save this content 
 */
$file_path = $_GET['file_path'] ?? 1;
$return_path = $_GET['return_path'] ?? 1;
$post = $_GET['postid'] ?? 1;

// Read the content of the file
$text_content = '';
if (file_exists($file_path)) {
    $text_content = file_get_contents($file_path);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Text Editor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .editor-container {
            max-width: 800px;
            margin: auto;
        }
        .toolbar {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .toolbar button {
            border: none;
            background-color: #f0f0f0;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        .toolbar button:hover {
            background-color: #e0e0e0;
        }
        textarea {
            width: 100%;
            height: 300px;
            font-family: monospace;
            font-size: 16px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="editor-container">
    <div class="toolbar">
        <button onclick="formatText('h1')">H1</button>
        <button onclick="formatText('h2')">H2</button>
        <button onclick="formatText('h3')">H3</button>
        <button onclick="formatText('bold')">B</button>
        <button onclick="formatText('italic')">I</button>
        <button onclick="formatText('underline')">U</button>
        <button onclick="insertLink()">🔗 Link</button>
    </div>

    <form method="post" action="save_text.php">
        <textarea id="editor" name="text"><?php echo htmlspecialchars($text_content); ?></textarea>
        <input type="submit" style="display: none;" id="saveButton">
    </form>
</div>

<script>
    function formatText(tag) {
        const editor = document.getElementById('editor');
        const selectedText = editor.value.substring(editor.selectionStart, editor.selectionEnd);

        let wrappedText;
        switch (tag) {
            case 'h1':
                wrappedText = `\n<h1>${selectedText}</h1>\n`;
                break;
            case 'h2':
                wrappedText = `\n<h2>${selectedText}</h2>\n`;
                break;
            case 'h3':
                wrappedText = `\n<h3>${selectedText}</h3>\n`;
                break;
            case 'bold':
                wrappedText = `<b>${selectedText}</b>`;
                break;
            case 'italic':
                wrappedText = `<i>${selectedText}</i>`;
                break;
            case 'underline':
                wrappedText = `<u>${selectedText}</u>`;
                break;
            default:
                wrappedText = selectedText;
        }

        editor.setRangeText(wrappedText, editor.selectionStart, editor.selectionEnd, 'end');
    }

    function insertLink() {
        const editor = document.getElementById('editor');
        const selectedText = editor.value.substring(editor.selectionStart, editor.selectionEnd);
        const url = prompt('Enter the URL:');

        if (url) {
            const link = `<a href="${url}">${selectedText || url}</a>`;
            editor.setRangeText(link, editor.selectionStart, editor.selectionEnd, 'end');
        }
    }
</script>

</body>
</html>



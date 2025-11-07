<?php
session_start();

if (!isset($_GET['file']) || empty($_GET['file'])) {
    die('No file specified.');
}

$file = urldecode($_GET['file']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Book Viewer</title>
    <style>
        #timer {
            position: fixed;
            top: 10px;
            right: 10px;
            color: #0f0;
            font-family: monospace;
        }
    </style>
</head>

<body>
    <iframe src="<?php echo htmlspecialchars($file); ?>" width="100%" height="100%"></iframe>
    <div id="timer">Reading: <span id="time">0</span>s</div>

    <script>
        let seconds = 0;
        const timerEl = document.getElementById("time");
        setInterval(() => {
            seconds++;
            timerEl.textContent = seconds;
        }, 1000);

        window.addEventListener("beforeunload", () => {
            const formData = new FormData();
            formData.append("file", "<?php echo htmlspecialchars($file); ?>");
            navigator.sendBeacon("<?php echo $base_url; ?>auth/action.php?action=closereading", formData);
        });
    </script>
</body>

</html>
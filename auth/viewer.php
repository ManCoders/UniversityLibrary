<?php
session_start();

// --- Check login ---
if (!isset($_SESSION['student']) && !isset($_SESSION['faculty']) && !isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

// --- Get and sanitize file parameter ---
$file = $_GET['file'] ?? null;
if (!$file) die("File not specified.");

// Decode URL-encoded path
$file = urldecode($file);

// Base directory for files
$baseDir = realpath(__DIR__ . '/files'); // absolute path to files folder

// Construct absolute file path
$filePath = realpath($baseDir . '/' . $file);

// Security check: prevent directory traversal
if (!$filePath || strpos($filePath, $baseDir) !== 0 || !file_exists($filePath)) {
    die("File not found.");
}

// Serve PDF.js viewer HTML (same as before)
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PDF Viewer</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.9.179/pdf_viewer.min.css" />
<style>
  body { margin: 0; height: 100vh; overflow: hidden; background: #333; }
  #viewerContainer { width: 100%; height: 100%; }
</style>
</head>
<body>
<div id="viewerContainer"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.9.179/pdf.min.js"></script>
<script>
const pdfjsLib = window['pdfjs-dist/build/pdf'];
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.9.179/pdf.worker.min.js';

const url = '<?php echo addslashes($filePath); ?>';
const container = document.getElementById('viewerContainer');

pdfjsLib.getDocument(url).promise.then(pdf => {
    for (let i = 1; i <= pdf.numPages; i++) {
        pdf.getPage(i).then(page => {
            const scale = 1.5;
            const viewport = page.getViewport({ scale });
            const canvas = document.createElement('canvas');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            container.appendChild(canvas);
            page.render({ canvasContext: canvas.getContext('2d'), viewport: viewport });
        });
    }
});

// Disable right-click & basic shortcuts
document.addEventListener('contextmenu', e => e.preventDefault());
document.addEventListener('keydown', e => {
    if ((e.ctrlKey && ['s','p','c','u'].includes(e.key.toLowerCase())) || e.key === 'F12') e.preventDefault();
});
</script>
</body>
</html>

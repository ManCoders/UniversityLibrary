<?php

http_response_code(404);

// Optional: display a message
echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>404 Not Found</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        h1 { font-size: 72px; margin-bottom: 0; }
        p { font-size: 24px; color: #555; }
        a { color: #007BFF; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>404</h1>
    <p>Page not found.</p>
    <p><a href='http://localhost/UniversityLibrary/'>Go back to Home</a></p>
</body>
</html>";

exit();

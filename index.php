<?php
// Define a log file
$logFile = 'user_behavior.log';

// Collect and log data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'unknown';
    $x = $_POST['x'] ?? 0;
    $y = $_POST['y'] ?? 0;
    
    // Log the action and coordinates
    $data = sprintf("%s - Action: %s, X: %d, Y: %d\n", date('Y-m-d H:i:s'), $action, $x, $y);
    file_put_contents($logFile, $data, FILE_APPEND);
    
    // Simple behavior prediction based on action
    if ($action === 'click') {
        echo "User is likely interested in the clicked element.";
    } elseif ($action === 'mouse_move') {
        echo "User is exploring the element.";
    } else {
        echo "Unknown user behavior.";
    }
} else {
    echo "No data received.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Behavior Prediction</title>
    <style>
    body {
        font-family: Arial, sans-serif;
    }

    .trackable {
        margin: 50px;
        padding: 20px;
        border: 1px solid #ccc;
    }
    </style>
</head>

<body>
    <div class="trackable" id="trackableElement">
        Hover or click me to track behavior.
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const trackableElement = document.getElementById('trackableElement');

        trackableElement.addEventListener('mousemove', function(e) {
            trackUserBehavior('mouse_move', e.clientX, e.clientY);
        });

        trackableElement.addEventListener('click', function(e) {
            trackUserBehavior('click', e.clientX, e.clientY);
        });

        function trackUserBehavior(action, x, y) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'track.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(`action=${action}&x=${x}&y=${y}`);
        }
    });
    </script>
</body>

</html>
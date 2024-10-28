<?php
$host = 'smtp.gmail.com'; // Your SMTP server
$port = 587; // SMTP port
$timeout = 10; // Timeout in seconds

$connection = @fsockopen($host, $port, $errno, $errstr, $timeout);
if ($connection) {
    echo "Connected to $host on port $port";
    fclose($connection);
} else {
    echo "Failed to connect: $errstr ($errno)";
}
?>

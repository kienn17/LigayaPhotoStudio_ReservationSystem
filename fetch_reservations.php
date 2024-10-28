<?php
include 'db.php';

$query = "SELECT * FROM book_record WHERE date >= CURDATE() ORDER BY date, time";
$stmt = $pdo->prepare($query);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($reservations);
?>

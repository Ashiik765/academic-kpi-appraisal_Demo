<?php
$db = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
$stmt = $db->query("SELECT id, migration, batch FROM migrations ORDER BY id");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($rows, JSON_PRETTY_PRINT);

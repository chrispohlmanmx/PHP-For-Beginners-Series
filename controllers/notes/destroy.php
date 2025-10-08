<?php


use Core\Database;

$config = require base_path('config.php');
$db = new Database($config['database']);


$currentUserId = 1;
$note = $db->query('select * from Notes where id = :id', [
  'id' => $_GET['id']
])->findOrFail();

authorize($note['user_id'] === $currentUserId);


$db->query('delete from Notes where id = :id', [
  'id' => $_POST['id'],
]);

header('location: /notes');
exit();

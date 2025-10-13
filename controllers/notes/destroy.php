<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

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

<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$currentUserId = 3;

$note = $db->query("select * from notes where id = :id ",[
    'id' => $_POST['id']
])->findOrFail();

authorized($note['user_id'] === $currentUserId);

// form was submitted. delete the current note.
$db->query('delete from notes where id= :id',[
    'id' => $_POST['id']
]);
header('Location: /notes');
exit();
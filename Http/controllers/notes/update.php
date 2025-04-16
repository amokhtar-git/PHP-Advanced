<?php

use Core\App;
use Core\Database;
use Core\Validator;


$db = App::resolve(Database::class);

$currentUserId = 3;
// find corresponding note
$note = $db->query("select * from notes where id = :id ",[
    'id' => $_POST['id']
])->findOrFail();
// authorize that the current user can edit the note
authorized($note['user_id'] === $currentUserId);
// validate the form
$errors = [];
if( ! Validator::string($_POST['body'],1, 1000) ){
    $errors['body'] = 'A body can not be more than 1,000 charachters.';
}
// if no validation error, update the record in the notes database table.
if(count($errors)){
    return view('notes/edit.view.php',[
        'heading' => 'Edit Note',
        'errors' => $errors,
        'note' => $note
    ]);
}
$db->query('update notes set body = :body where id = :id',[
    'id' => $_POST['id'],
    'body' => $_POST['body']
]);
// redirect the user
header('Location: /notes');
exit();
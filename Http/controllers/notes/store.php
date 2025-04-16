<?php
use Core\App;
use Core\Validator;
use Core\Database;

$db = App::resolve(Database::class);

$errors = [];

if( ! Validator::string($_POST['body'],1, 1000) ){
    $errors['body'] = 'A body can not be more than 1,000 charachters.';
}
if(! empty($errors)) {
    return view("notes/create.view.php",[
        'heading' => 'Create Note',
        'errors' => $errors
    ]);
}
$db->query("INSERT INTO notes (body, user_id) VALUES (:body, :user_id)",[
    ':body' => $_POST['body'],
    ':user_id' => 3,
]);
header('Location: /notes');
exit();
<?php

use Core\Authenticator;
use Core\Session;
use Core\ValidationExecption;
use Http\Forms\LoginForm;



// Log in the user if the credentials match.

$form = LoginForm::validate($attributes = [
    'email' => $_POST['email'],
    'password' => $_POST['password']
]);

$signedIn = (new Authenticator)->attempt($attributes['email'], $attributes['password']);
if(! $signedIn){
    $form->error('email', 'No match account found for that email address and password.')->throw();
}
redirect('/');

// return redirect('/login');
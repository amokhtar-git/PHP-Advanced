<?php
namespace Core;

class Authenticator

{
    public function attempt($email, $password)
    {
        $user = App::resolve(Database::class)
            ->query('select * from users where email = :email',[
            'email' => $email,
        ])->find();

        if( $user ){
            if( password_verify($password, $user['password'])){
                $this->login([
                    'email' => $email
                ]);
                // header('Location: /');
                // exit();
                return true;
            }
        }
        return false;
    }
    public function login($user)
    {
        $_SESSION['user'] = [
            'email' => $user['email']
        ];
        session_regenerate_id(true);
        setcookie(
            session_name(),
            session_id(),
            time() + 3600,
            '/',
            $_SERVER['HTTP_HOST'],
            isset($_SERVER['HTTPS']),
            true  // httponly
        );
    }
    public function logout()
    {
        Session::destroy();
    }
}
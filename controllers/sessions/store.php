<?php

// log in user if credentials match
//


use Core\App;
use Core\Validator;
use Core\Database;

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];

if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address';
}

if (! Validator::string($password)) {
    $errors['password'] = 'Please provide a valid password';
}

if (! empty($errors)) {
    return view('sessions/create.view.php', [
      'errors' => $errors,
      'heading' => 'Log In',
    ]);
}

$db = App::resolve(Database::class);

$user = $db->query('select * from Users where email = :email', [
  'email' => $email,
])->find();

if ($user) {

    if (password_verify($password, $user['password'])) {

        login([
          'email' => $email,
        ]);

        header('location: /');
        exit();
    }
}

return view('sessions/create.view.php', [
  'errors' => [
  'email' => 'No matching account found for that email address and password',
  ]
]);

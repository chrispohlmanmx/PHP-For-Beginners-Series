<?php

use Core\App;
use Core\Validator;
use Core\Database;

$email = $_POST['email'];
$password = $_POST['password'];

$errors = [];

if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address';
}

if (! Validator::string($password, 7, 255)) {
    $errors['password'] = 'Password should be between 7 and 255 characters';
}

if (! empty($errors)) {
    return view('registration/create.view.php', [
      'errors' => $errors,
      'heading' => 'Register',
    ]);
}

$db = App::resolve(Database::class);

$user = $db->query('select * from Users where email = :email', [
  'email' => $email,
])->find();

if ($user) {
    header('location: /');
    exit();

} else {
    $db->query('INSERT INTO Users(email, password) VALUES(:email, :password)', [
      'email' => $email,
      'password' => $password
    ]);

    $_SESSION['user'] = [
      'email' => $email,
    ];

    header('location: /');
    exit();
}

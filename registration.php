<?php

require_once("config.php");
if (!empty(S_SESSION['user_id'])) {
    header("location: /index.php");
}
$errors = [];
if (!empty($_POST)) {
    if (empty($_POST['user_name'])) {
        $errors[] = 'Please enter User Name';
    }
    if (empty($_POST['email'])) {
        $errors[] = 'Please enter email';
    }
    if (empty($_POST['first_name'])) {
        $errors[] = 'Please enter First Name';
    }
    if (empty($_POST['last_name'])) {
        $errors[] = 'Please enter Last Name';
    }
    if (empty($_POST['password'])) {
        $errors[] = 'Please confirm password';
    }
    if (empty($_POST['confirm_password'])) {
        $errors[] = 'Please confirm password';
    }
    if (empty($_POST['user_name']) > 225) {
        $errors[] = 'User Name too long. Max length is 225 characters';
    }
    if (empty($_POST['first_name']) > 225) {
        $errors[] = 'First Name too long. Max length is 225 characters';
    }
    if (empty($_POST['last_name']) > 225) {
        $errors[] = 'Last Name too long. Max length is 225 characters';
    }
    if (empty($_POST['password']) || strlen($_POST['password'])< 6) {
        $errors[] = 'Password should contains at least 6 characters';
    }
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $errors[] = 'Your confirm password is not match password';
    }
    if (empty($errors)) {
        $stmt = $dbConn->prepare('INSERT INTO users(`username`, `email`, `password`, `first_name`, `last_name`) VALUES(:username, :email, :password, :first_name, :last_name)');
        $stmt->execute(array(
            'username' => $_POST['user_name'],
            'email' => $_POST['email'],
            'password' => sha1($_POST['password'] . SALT),
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name']));
        header("location: /login.php?registration=1");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Guest Book</title>
    <meta charset="UTF-8">
</head>
<body>
<h1>Registration Page</h1>
<div>
    <form method="post">
        <div style="color: red;">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error; ?></p>
            <?php endforeach;; ?>
        </div>
        <div>
            <label>User Name:</label>
            <div>
                <input type="text" name="user_name" required=""
                       value="<?php echo(!empty($_POST['user_name'] ? $_POST['user_name'] : '')) ?>">
            </div>
        </div>
        <div>
            <label>Email:</label>
            <div>
                <input type="email" name="email" required=""
                       value="<?php echo(!empty($_POST['email'] ? $_POST['email'] : '')) ?>">
            </div>
        </div>
        <div>
            <label>First Name:</label>
            <div>
                <input type="text" name="first_name" required=""
                       value="<?php echo(!empty($_POST['first_name'] ? $_POST['first_name'] : '')) ?>">
            </div>
        </div>
        <div>
            <label>Last Name:</label>
            <div>
                <input type="text" name="last_name" required=""
                       value="<?php echo(!empty($_POST['last_name'] ? $_POST['last_name'] : '')) ?>">
            </div>
        </div>
        <div>
            <label>Password:</label>
            <div>
                <input type="password" name="password" required="" value="">
            </div>
        </div>
        <div>
            <label>Confirm Password:</label>
            <div>
                <input type="password" name="confirm_password" required="" value="">
            </div>
        </div>
        <div>
            <br>
            <input type="submit" name="submit" value="Register">
        </div>
    </form>
</div>
</body>
</html>

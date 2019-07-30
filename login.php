<?php

require_once "config.php";
if (!empty($_SESSION['user_id'])) {
    header('location: /index.php');
}
$errors = [];
$isRegistered = 0;
if ($_GET['registration']){
    $isRegistered = 1;
}
if (!empty($_POST)) {
    if (empty($_POST['user_name'])) {
        $errors[] = 'Please enter User Name / Email';
    }
    if (empty($_POST['password'])) {
        $errors[] = 'Please enter password';
    }
    if (empty($errors)) {
        $stmt = $dbConn->prepare('SELECT id FROM users WHERE (username = :username or email = :username) and password = :password');
        $stmt->execute(array('username' => $_POST['user_name'], 'password' => sha1($_POST['password'] . SALT)));
        $id = $stmt->fetchColumn();
        if (!empty($id)) {
            $_SESSION['user_id'] = $id;
            die("Вы успешно авторизированы");
        } else {
            $errors[] = 'Please enter valid credentails';
        }
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
<?php if (!empty($isRegistered)) :?>
<h2>Вы успешно зарегестрировались! Используйте свои данные для входа на сайт</h2>
<?php endif; ?>

<h1>Log In Page</h1>
<div>
    <form method="post">
        <div style="color: red;">
            <?php foreach ($errors as $error) : ?>
                <p><?php echo $error; ?></p>
            <?php endforeach;; ?>
        </div>
        <div>
            <label>User Name / Email:</label>
            <div>
                <input type="text" name="user_name" required=""
                       value="<?php echo(!empty($_POST['user_name'] ? $_POST['user_name'] : '')) ?>">
            </div>
        </div>
        <div>
            <label>Password:</label>
            <div>
                <input type="password" name="password" required="" value="">
            </div>
        </div>
        <div>
            <br>
            <input type="submit" name="submit" value="Log In">
        </div>
    </form>
</div>
</body>
</html>
<?php

require_once "config.php";

if (!empty($_SESSION['user_id'])) {
    header('location: /index.php');
}

if (!empty($_POST['comment'])) {
    $stmt = $pdo->prepare("INSERT INTO comment(`user_id`, `comment`) VALUES(:user_id, :comment)");
    $stmt->execute(array('user_id' => $_SESSION['user_id'], 'comment' => $_POST['comment']));
}

$stmt = $pdo->prepare("SELECT * FROM comment ORDER BY id DESC ");
$stmt->execute();
$comments = $stmt->fletchAll();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comments Page</title>
</head>
<body>
<div id="comments-header">
    <h1>Comments Page</h1>
</div>
<div id="comments-form">
    <h3>Please create your comment</h3>
    <form method="post">
        <div>
            <label>Comment</label>
            <div>
                <textarea name="comment"></textarea>
            </div>
        </div>
        <div>
            <br>
            <input type="submit" name="submit" value="Save">
        </div>
    </form>
</div>
<div id="comments-panel">
    <h3>Comments:</h3>
    <?php foreach ($comments as $comment): ?>
        <p <?php if ($comment['user_id'] == $_SESSION['user_id']) echo 'style="font=weight:bold;"' ?>> <?php echo $comment['comment']; ?>
            <span class="comment-date"><?php echo $comment['created']; ?></span></p>
    <?php endforeach; ?>
</div>
</body>
</html>

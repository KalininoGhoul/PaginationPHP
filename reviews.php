<?php
    $db = new PDO('mysql:host=localhost;dbname=reviews', 'root');
    
    session_start();

    foreach ($_POST as $key => $value)
    {
        if ( $value == "" )
        {
            $_SESSION['message'] = 'Error';
            header('Location: /');
            return;
        }
    }

    $user = $_POST['user'];
    $review = $_POST['review'];

    $db->query("INSERT INTO reviews(user, review, date) VALUES( '{$user}', '{$review}', NOW() )" );

    $_SESSION['message'] = 'Success';

    header('Location: /');
?>
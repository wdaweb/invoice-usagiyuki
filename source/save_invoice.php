<?php
    include_once "../h/db.php";

    $err = 0;
    foreach ($_POST as $key => $val) {
        if (empty($val)) {
            $err = 1;
            setcookie("err", $err, time()+1, "/");
            header("location:../index.php");
            exit;
        }
    }

    if (insert()) {
        $err = 3;
    } else {
        $err = 2;
    }

    setcookie("err", $err, time()+1, "/");
    header("location:../index.php");
?>
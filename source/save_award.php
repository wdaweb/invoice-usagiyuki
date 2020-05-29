<?php
    include_once "../h/db.php";

    $err = 0;
    foreach ($_POST as $key => $val) {
        if (empty($val) && (($key != "other2") && ($key != "other3"))) {
            $err = 1;
            setcookie("err", $err, time()+1, "/");
            header("location:../invoice.php");
            exit;
        }
    }

    switch (check()) {
        case 0 :
            $err = 2;
            break;
        case 1 :
            if (insert(1)) {
                $err = 3;
            } else {
                $err = 2;
            }
            break;
        case -1 :
            if (update()) {
                $err = 4;
            } else {
                $err = 2;
            }            
            break;
    }

    setcookie("err", $err, time()+1, "/");
    header("location:../invoice.php");
?>
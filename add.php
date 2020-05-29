<?php
include_once "./h/db.php";

for ($i = 0; $i < 1000; $i++) {
    $_POST['period'] = 6;//rand(1, 6);
    $_POST['year'] = 2020;//rand(2020, 2021);
    $_POST['code'] = "nt";
    $_POST['number'] = rand(100000, 99999999);
    $_POST['expend'] = rand(10, 5000);

    insert();
}
echo "add success";
?>
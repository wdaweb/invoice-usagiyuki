<?php
    $dsn = "mysql:host=localhost;charset=utf8;dbname=invoiceDB";
    $pdo = new PDO($dsn, "root", "");
    date_default_timezone_set("Asia/Taipei");

    function check() {
        global $pdo;
    
        $sql = "select * from `award` where `year` = $_POST[year] && `period` = $_POST[period]";
        $dbdata = $pdo->query($sql);
    
        if (!$dbdata) {
            return 0;
        } else {
            $row = $dbdata->fetchAll(PDO::FETCH_ASSOC);
            if (empty($row)) {
                return 1;
            } else {
                return -1;
            }
        }
    }

    function insert($type = 0) {
        global $pdo;
    
        switch ($type) {
            case 0 :
                $sql = "insert into `invoice` (`period`, `year`, `code`, `number`, `expend`) VALUES ('$_POST[period]', '$_POST[year]', '$_POST[code]', '$_POST[number]', '$_POST[expend]')";
                break;
            case 1 :
                $sql = "insert into `award` (`year`, `period`, `super`, `special`, `top1`, `top2`, `top3`, `other1`, `other2`, `other3`) VALUES 
                ('$_POST[year]', '$_POST[period]', '$_POST[super]', '$_POST[special]', '$_POST[top1]', '$_POST[top2]', '$_POST[top3]', '$_POST[other1]', '$_POST[other2]', '$_POST[other3]')";
                break;
        }

        $dbdata = $pdo->query($sql);
        if (!$dbdata) {
            // echo "<pre>";print_r($pdo->errorInfo());"</pre>";
            // echo "<br>".$sql;
            return false;
        } else {
            // $row = $dbdata->fetchAll(PDO::FETCH_ASSOC);
            // echo print_r($row);
            return true;
        }
    }
    
    function update() {
        global $pdo;
    
        if (empty($_POST['other2'])) {
            $_POST['other2'] = 0;
        }
        if (empty($_POST['other3'])) {
            $_POST['other3'] = 0;
        }
        $sql = "update `award` set `year`= $_POST[year], `period`= $_POST[period], `super`= $_POST[super], `special`= $_POST[special], `top1`= $_POST[top1],
        `top2`= $_POST[top2], `top3`= $_POST[top3], `other1`= $_POST[other1], `other2`= $_POST[other2], `other3`= $_POST[other3] 
        where `year` = $_POST[year] && `period` = $_POST[period]";
    
        $dbdata = $pdo->query($sql);
        if (!$dbdata) {
            // echo "<pre>";print_r($pdo->errorInfo());"</pre>";
            // echo "<br>".$sql;
            return false;
        } else {
            // $row = $dbdata->fetchAll(PDO::FETCH_ASSOC);
            // echo print_r($row);
            return true;
        }
    }

    function getaward() {
        global $pdo;
    
        $sql = "select * from `award` where `year` = $_POST[year] && `period` = $_POST[period]";
        $dbdata = $pdo->query($sql);
    
        if (!$dbdata) {
            return 0;
        } else {
            $row = $dbdata->fetch(PDO::FETCH_ASSOC);
            if (empty($row)) {
                return 0;
            } else {
                return $row;
            }
        }
    }
    function getinvo() {
        global $pdo;
    
        $sql = "select * from `invoice` where `year` = $_POST[year] && `period` = $_POST[period]";
        $dbdata = $pdo->query($sql);
    
        if (!$dbdata) {
            return 0;
        } else {
            $row = $dbdata->fetchAll(PDO::FETCH_ASSOC);
            if (empty($row)) {
                return 0;
            } else {
                return $row;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php include "./common/title.php"; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@500&family=Open+Sans:ital@0;1&display=swap" rel="stylesheet">
    <link rel=stylesheet href="./css/style.css">
    <?php
      include "./h/db.php";
    ?>
</head>
<body>
<?php
        $key = ["id", "year", "period", "super", "special", "top1", "top2", "top3", "other1", "other2", "other3"];
        $tit = ["編號", "年份", "期別", "特別獎", "特獎", "頭獎1", "頭獎2", "頭獎3", "加開1", "加開2", "加開3"];
        $period = ceil(date("n") / 2);
        if (!empty($_GET["code"])) {
            $period = $_GET["code"];
        }
    ?>
    <div class="cent">
        <div>
            <a class="hear" href="./index.php">回首頁</a>
            <a class="hear" href="./invoice.php">輸入對獎號碼</a>
            <a class="hear" href="./list.php">發票清單</a>
            <a class="hear" href="./award.php">對獎</a>            
        </div>
        <br>
        <div>
            <a class="mon <?=($period==1)?'nowmon':'';?>" href="./query.php?code=1">1,2</a>
            <a class="mon <?=($period==2)?'nowmon':'';?>" href="./query.php?code=2">3,4</a>
            <a class="mon <?=($period==3)?'nowmon':'';?>" href="./query.php?code=3">5,6</a>
            <a class="mon <?=($period==4)?'nowmon':'';?>" href="./query.php?code=4">7,8</a>
            <a class="mon <?=($period==5)?'nowmon':'';?>" href="./query.php?code=5">9,10</a>
            <a class="mon <?=($period==6)?'nowmon':'';?>" href="./query.php?code=6">11,12</a>
        </div>
        <br>
        <?php            
            $sql = "select * from `award` where `period` = $period order by `year` asc";

            $dbdata = $pdo->query($sql);
            if (!$dbdata) {
                echo "<pre>";print_r($pdo->errorInfo());"</pre>";
                echo "<br>".$sql;
            } else {
                echo "<table class='tb1'>";
                echo "<tr>";
                for($i = 0; $i < sizeof($key); $i++) {
                    echo "<td>";
                    echo $tit[$i];
                    echo "</td>";
                }
                echo "</tr>";
                foreach($dbdata as $val) {
                    echo "<tr>";
                    for($i = 0; $i < sizeof($key); $i++) {
                        echo "<td>";
                        if (($key[$i] == "other1") || ($key[$i] == "other2") || ($key[$i] == "other3")) {
                            if ($val[$key[$i]] != 0) {
                                echo sprintf("%03d", $val[$key[$i]]);
                            } else {
                                echo "";
                            }                            
                        } else {
                            if (($key[$i] == "super") || ($key[$i] == "special") || ($key[$i] == "top1")
                                || ($key[$i] == "top2") || ($key[$i] == "top3")) {
                                echo sprintf("%08d", $val[$key[$i]]);
                            } else {
                                echo $val[$key[$i]];
                            }
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
        ?>
    </div>
</body>
</html>
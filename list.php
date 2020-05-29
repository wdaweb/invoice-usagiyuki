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
        $key = ["id", "year", "code", "number", "expend"];
        $tit = ["編號", "年份", "標記", "號碼", "花費"];
        $period = ceil(date("n") / 2);
        if (!empty($_GET["code"])) {
            $period = $_GET["code"];
        }
    ?>
    <div class="cent">
        <div>
            <a class="hear" href="./index.php">回首頁</a>
            <a class="hear" href="./invoice.php">輸入對獎號碼</a>            
            <a class="hear" href="./award.php">對獎</a>
            <a class="hear" href="./query.php">各期號碼</a>
        </div>
        <br>
        <div>            
            <?php
                for ($i = 1; $i < 7; $i++) {
            ?>            
            <a class="mon <?=($period==$i)?'nowmon':'';?>" href="./list.php?code=<?=$i;?>"><?=(($i*2) - 1) . "," . $i*2;?></a>
            <?php
            }?>
            <!-- <a class="mon <?=($period==1)?'nowmon':'';?>" href="./list.php?code=1">1,2</a>
            <a class="mon <?=($period==2)?'nowmon':'';?>" href="./list.php?code=2">3,4</a>
            <a class="mon <?=($period==3)?'nowmon':'';?>" href="./list.php?code=3">5,6</a>
            <a class="mon <?=($period==4)?'nowmon':'';?>" href="./list.php?code=4">7,8</a>
            <a class="mon <?=($period==5)?'nowmon':'';?>" href="./list.php?code=5">9,10</a>
            <a class="mon <?=($period==6)?'nowmon':'';?>" href="./list.php?code=6">11,12</a> -->
        </div>
        <br>
        <div class = "over">
            <?php            
                $sql = "select * from `invoice` where `period` = $period order by `year` asc";

                $dbdata = $pdo->query($sql);
                if (!$dbdata) {
                    echo "<pre>";print_r($pdo->errorInfo());"</pre>";
                    echo "<br>".$sql;
                } else {
                    echo "<table>";
                    echo "<tr>";
                    for($i = 0; $i < sizeof($key); $i++) {
                        echo "<td>";
                        echo $tit[$i];
                        echo "</td>";
                    }
                    echo "</tr>";
                    $count = 0;
                    foreach($dbdata as $val) {
                        echo "<tr>";
                        for($i = 0; $i < sizeof($key); $i++) {
                            echo "<td>";
                            echo $val[$key[$i]];
                            echo "</td>";
                        }
                        echo "</tr>";
                        //$count++;
                        if ($count > 20) {
                        break;
                        }
                    }
                    echo "</table>";
                }
            ?>
        </div>
    </div>
    <br>
</body>
</html>
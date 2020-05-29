<?php
  include_once "./h/db.php";
  if (empty($_POST['year'])) {
    $_POST['year'] = date("Y");
  }
  if (empty($_POST['period'])) {
    $_POST['period'] = ceil(date("n") / 2);
  }  
  $year = $_POST['year'];
  $period = $_POST['period'];
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php include "./common/title.php"; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@500&family=Open+Sans:ital@0;1&display=swap" rel="stylesheet">
    <link rel=stylesheet href="./css/style.css">
</head>
<body>
  <div class="cent">
    <div>
      <a class="hear" href="./index.php">回首頁</a>
      <a class="hear" href="./invoice.php">輸入對獎號碼</a>
      <a class="hear" href="./list.php">發票清單</a>
      <a class="hear" href="./query.php">各期號碼</a>
    </div>
    <br>
    <div>
      <form action="?" method="post">
        <div>
          年份:
          <select name="year">
            <option value="2020" <?=($year==2020)?"selected='selected'":'';?>>2020</option>
            <option value="2021" <?=($year==2021)?"selected='selected'":'';?>>2021</option>
            <option value="2022" <?=($year==2022)?"selected='selected'":'';?>>2022</option>
          </select>
          期別:
          <select name="period" >
            <option value="1" <?=($period==1)?"selected='selected'":'';?>>1,2月</option>
            <option value="2" <?=($period==2)?"selected='selected'":'';?>>3,4月</option>
            <option value="3" <?=($period==3)?"selected='selected'":'';?>>5,6月</option>
            <option value="4" <?=($period==4)?"selected='selected'":'';?>>7,8月</option>
            <option value="5" <?=($period==5)?"selected='selected'":'';?>>9,10月</option>
            <option value="6" <?=($period==6)?"selected='selected'":'';?>>11,12月</option>
          </select>
          <input type="submit" value="查詢">
        </div>
      </from>
    </div>
    <div>
      <?php
        $aw = ['super', 'special', 'top1', 'top2', 'top3', 'other1', 'other2', 'other3'];
        $awtit = ['特別獎', '特獎', '頭獎', '二獎', '三獎', '四獎', '五獎', '六獎', '增開六獎'];
        $money = [10000000, 2000000, 200000, 40000, 10000, 4000, 1000, 200, 200];
        $sub = [3,4,5,6,7];
        $winning = [];
        $tmp = [];
        for($i = 0; $i < 9; $i++ ) {
          $winning[$i] = [];
          $tmp[$i] = [];
        }
        $rows = getaward();
        if ($rows == 0) {
          echo "尚無對獎資料";
        } else {
          //echo print_r($rows);
          $cun = 0;
          $invos = getinvo();
          if ($invos == 0) {
            echo "無當期發票";
          } else {
            //echo print_r($invos);
            foreach($invos as $val) {
              $len = sizeof($aw);
              $num = $val['number'];
              $awid = 0;
              $awid_temp = 10;
              for ($i = 0; $i < $len; $i++) {
                if ($rows[$aw[$i]] == 0) continue;
                if (strlen($rows[$aw[$i]]) < 3) {
                  $str = sprintf("%03d", $rows[$aw[$i]]);
                } else {
                  $str = $rows[$aw[$i]];
                }
                $awid = compare($i, $num, $str, $awid);

                if (($awid < 3 || $awid > 7) && ($awid != -1)) {
                  array_push($tmp[$awid], $val);
                  // array_push($winning[$awid], $num);
                  break;
                } else {
                  if ($awid != -1) {
                    if ($awid_temp == 10) {
                      $awid_temp = $awid;
                    } else if ($awid < $awid_temp) {
                      $awid_temp = $awid;
                    }
                  }                  
                }
                if (($i == 4) && ($awid_temp != 10)) {
                  array_push($tmp[$awid_temp], $val);
                  // array_push($winning[$awid_temp], $num);
                  break;
                }
              }
            }
            $len = sizeof($awtit);
            echo "<div class='awdiv'>";
            for ($i = 0; $i < $len; $i++) {
              $sublen = sizeof($tmp[$i]);
              echo "<div>" . $awtit[$i] . "</div>";
              echo "<div class='btline'>發票張數 : <samp class='amount'>" . $sublen . "</samp> 中獎金額 : <samp class='money'>" . $sublen * $money[$i] . "</samp></div>";
              echo "<div class='btspace'>";              
              if ($sublen == 0) {
                echo "&nbsp;";
              } else {
                foreach ($tmp[$i] as $tmp_row) {
                  echo "<samp>" . $tmp_row['code'] . '-' . $tmp_row['number'] . "</samp>";
                }
              }              
              echo "</div>";
            }
            echo "</div>";
            // echo print_r($winning);
            // echo print_r($tmp);
          }
        }

        function compare($idx, $a, $b, $awid) {
          global $winning;

          if ($idx > 4) {            
            $str1 = mb_substr($a,  -3);
            if (strcmp($str1, $b) == 0) {
              //array_push($winning[8], $a);
              return 8;
            }
          } else {
            if (strcmp($a, $b) == 0) {
              if ($idx < 2) {
                // array_push($winning[$idx], $a);
                return $idx;
              } elseif ($idx < 5) {
                // array_push($winning[2], $a);
                return 2;
              }
            }
          }

          if ($idx == 2 || $idx == 3 || $idx == 4) {
            for($i = 1; $i < 6; $i++) {
              $str1 = mb_substr($a,  $i - 8);
              $str2 = mb_substr($b,  $i - 8);

              if (strcmp($str1, $str2) == 0) {
                // array_push($winning[2 + $i], $a);
                return $i + 2;
              }
            }
          }
          return -1;
        }
      ?>
    </div>
  </div>
</body>
</html>
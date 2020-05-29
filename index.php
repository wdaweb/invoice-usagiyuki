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
      <a class="hear" href="./invoice.php">輸入對獎號碼</a>
      <a class="hear" href="./list.php">發票清單</a>
      <a class="hear" href="./award.php">對獎</a>
      <a class="hear" href="./query.php">各期號碼</a>
    </div>
    <br>
    <?php
      if (!empty($_COOKIE['err'])) {
        echo "<div>";
        switch ($_COOKIE['err']) {
            case "3" :
                echo "資料新增成功" . "<br>";
                break;
            case "1" :
                echo "資料不完全" . "<br>";
                break;
            case "2" :
                echo "資料庫錯誤" . "<br>";
                break;
            default:
                break;
        }
        echo "</div>";
      }
    ?>
    <form action="./source/save_invoice.php" method="post" id="add">
      <div>
        期別:
      </div>
      <div>
        <select name="period" >
          <option value="1">1,2月</option>
          <option value="2">3,4月</option>
          <option value="3">5,6月</option>
          <option value="4">7,8月</option>
          <option value="5">9,10月</option>
          <option value="6">11,12月</option>
        </select>
      </div>
      <div>
        年份:
      </div>
      <div>
        <select name="year">
          <option value="2020">2020</option>
          <option value="2021">2021</option>
          <option value="2022">2022</option>
        </select>
      </div>
      <div>
        <label for="pagetitle">獎號:</label>
      </div>
      <div>
        <input type="text" id="pagetitle" name="code" placeholder="by">
        <input type="number" id="pagenum" name="number" placeholder="12345678">
      </div>
      <div>
        花費:
      </div>
      <div>
        <input type="number" name="expend">
      </div>
      <div>
        <input type="submit" value="儲存">
      </div>
    </form>
  </div>
</body>
</html>
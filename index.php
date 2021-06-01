<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>test</title>
  </head>
  <body>

<?php
  $url = 'localhost'; //mysqlサーバー名
  $user = 'root'; //ユーザーID
  $pass = 'Toriaezu@0705'; //パスワード
  $db = 'shinjinkadai_deta'; //データベース名

// mysqliへ接続
$link = mysqli_connect($url,$user,$pass) or die("mysqliへの接続に失敗しました。");

// データベースを選択する
$sdb = mysqli_select_db($link, $db) or die("データベースの選択に失敗しました。");
echo "aaaaas";

?>

    <h1>aaa</h1>
  </body>
</html>

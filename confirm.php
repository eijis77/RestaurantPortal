<?php
// セッションの開始
session_start();

$star = $_POST['kata'];
$message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');
$kind = $_SESSION['kind'];
// 入力値をセッション変数に格納
$_SESSION['star'] = $star;
$_SESSION['message'] = $message;
?>
<!DOCTYPE HTML>
<html lang ="ja">
<head>
<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="shinjin.css">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta charset="utf-8">
<title>ユーザー登録フォーム</title>
</head>
<style media="screen">
  p,th{
    margin:20px 0;
    display: block;
  }
  .main_log{
    padding:20px 30px;
  }
</style>
<body id="log_body">
<main class="main_log">
<h1>投稿確認画面</h1>
<form action="submit.php" method="post">
<table>
<tr><th>ユーザー名： </th><td><?php echo substr($_SESSION['EMAIL'],0,strcspn($_SESSION['EMAIL'],'@')); ?> さん</td></tr>
<tr><th>店名：</th><td><?php echo $kind; ?></td></tr>
<tr><th>評価：</th><td><?php echo $star; ?></td></tr>
<tr><th>投稿文：</th><td><?php echo $message; ?></td></tr>
</table>
<a href="javascript:history.back()" class="fix">修正する</a>
<input id="send" type="submit" value="登録" class="log_button">
</form>
</main>
</body>
</html>

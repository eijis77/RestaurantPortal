<?php

function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

session_start();
//ログイン済みの場合
if (isset($_SESSION['EMAIL'])) {
  echo 'ようこそ' .  h($_SESSION['EMAIL']) . "さん<br>";
  echo "<a href='/logout.php'>ログアウトはこちら。</a>";
	$email = $_SESSION['EMAIL'];
}else{
	echo 'ようこそ ゲスト さん';
  echo "<a href='/signUp.php'>ログインはこちら。</a>";
	$email = "";

}

//データベース接続
$server = "localhost";
$userName = "root";
$password = "Toriaezu@0705";
$dbName = "shinjinkadai_deta";

$mysqli = new mysqli($server, $userName, $password,$dbName);

if ($mysqli->connect_error){
	echo $mysqli->connect_error;
	exit();
}else{
	$mysqli->set_charset("utf-8");
}
$sql_form = "SELECT * FROM formdata";
$sql_form_result = $mysqli -> query($sql_form);

$sql_shop = "SELECT * FROM shopdata";
$sql_shop_result = $mysqli -> query($sql_shop);

$sql_genre = "SELECT DISTINCT genre FROM shopdata";
$sql_genre_result = $mysqli -> query($sql_genre);

//レコード件数（店舗）
$shop_row_count = $sql_shop_result->num_rows;
//レコード件数（投稿）
$form_row_count = $sql_form_result->num_rows;
?>

<!DOCTYPE html>
<html>

<head>
	<title>人気店一覧</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="shinjin.css">
</head>

<body>
	<h1 class="topt">人気料理一覧</h1>
<?php if (isset($email)) { ?>
	<a class="tosubmit" href="input.php">投稿する</a>
<?php }else{ ?>
	<a class="tosubmit" href="" style="text-align:center;">投稿するには<br>ログインしてください</a><?php }?>
	<p class="shop_num">掲載店舗数：<?php echo $shop_row_count; ?></p>
  <p class="form_num">口コミ投稿数：<?php echo $form_row_count; ?></p>
	<img src="food.jpg" class="foodpic" alt="">
	<div id="container">

<?php
while($genre_row = $sql_genre_result->fetch_array(MYSQLI_ASSOC)){
	$genre_rows[] = $genre_row;
  $genre_name = $genre_row['genre'];
?>
    <p class="shopname"><?php echo $genre_name;?></p>
    <div class="flex slide">
<?php
  $sql_shop = "SELECT * FROM shopdata where genre = '".$genre_name."'";
  $sql_shop_result = $mysqli -> query($sql_shop);

  while ($shop_row = $sql_shop_result->fetch_array(MYSQLI_ASSOC)) {
    $shop_rows[] = $shop_row;
?>
      <div class="box">
        <p class="shopname"><?php echo $shop_row['name'];?></p>
        <p class="address"><?php echo $shop_row['address'];?></p>
        <p class="shopgenre"><?php echo $shop_row['genre'];?></p>
        <div class="picdiv"><img src="images/<?php echo $shop_row['id'];?>.jpg" class="shoppic"></div>
        <p class="number"><?php echo $shop_row['number'];?></p>
      </div>
<?php
  }
?>
    </div>
<?php
}
//結果セットを開放
$sql_genre_result->free();
$sql_shop_result->free();
//データベース切断
$mysqli->close();
?>

  </div>
</body>
</html>

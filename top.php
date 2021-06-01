<?php

function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

session_start();
//ログイン済みの場合
if (isset($_SESSION['EMAIL'])) {
?>
<header>
  <a href="top.php"><img src="images/logo.png" alt="" class="left logo"></a>
  <div class="right bottom">
    <p class="welcome">ようこそ<?php echo $_SESSION['EMAIL']; ?>さん</p>
    <a href='/logout.php' class="logout">ログアウト</a>
  </div>
</header>
<?php
	$email = $_SESSION['EMAIL'];
}else{
?>
<header>
  <img src="images/logo.png" alt="" class="left logo">
  <div class="right bottom">
    <p class="welcome">ようこそゲストさん</p>
    <a href='/signUp.php' class="logout">ログイン</a>
  </div>
</header>

<?php
	$email = "";

}

//データベース接続
//mysql接続
$dsn = 'mysql:dbname=shinjinkadai_deta;host=localhost';
$user = 'root';
$password = 'Toriaezu@0705';
try{
    $PDO = new PDO($dsn, $user, $password);
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}

$sql_form = "SELECT * FROM formdata";
$sql_form_result = $PDO -> query($sql_form);

$sql_shop = "SELECT * FROM shopdata";
$sql_shop_result = $PDO -> query($sql_shop);

$sql_genre = "SELECT DISTINCT genre FROM shopdata";
$sql_genre_result = $PDO -> query($sql_genre);

//レコード件数（店舗）
$shop_row_count = $sql_shop_result->rowCount();
//レコード件数（投稿）
$form_row_count = $sql_form_result->rowCount();
?>

<!DOCTYPE html>
<html>

<head>
	<title>人気店一覧</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="shinjin.css">
</head>

<body>
	<h1 class="topt">人気店舗一覧</h1>
	<p class="shop_num">掲載店舗数：<span><?php echo $shop_row_count; ?></span> 口コミ投稿数：<span><?php echo $form_row_count; ?></span></p>
	<img src="food.jpg" class="foodpic" alt="">
	<div id="container">

<?php
while($genre_row = $sql_genre_result->fetch(PDO::FETCH_ASSOC)){
	$genre_rows[] = $genre_row;
  $genre_name = $genre_row['genre'];
?>
    <p class="shopname"><?php echo $genre_name;?></p>
    <div class="flex slide">
<?php
  $sql_shop = "SELECT * FROM shopdata where genre = '".$genre_name."'";
  $sql_shop_result = $PDO -> query($sql_shop);

  while ($shop_row = $sql_shop_result->fetch(PDO::FETCH_ASSOC)) {
    $shop_rows[] = $shop_row;
    $shop_name = $shop_row['name'];

    $sql_shop_star = "SELECT AVG(star) FROM formdata where kind ='".$shop_name."'";
    $sql_shop_star_result = $PDO -> query($sql_shop_star);
    $ave_star = $sql_shop_star_result->fetchColumn();
?>
      <a class="box" href="detail.php?shop_id=<?php echo $shop_row['id']; ?>">
        <p class="shopname"><?php echo $shop_row['name'];?></p>
        <div class="flex">
          <div class="star-rating flex">
            <div class="star-rating-front" style="width:<?php echo $ave_star*20;?>%">★★★★★</div>
            <div class="star-rating-back">★★★★★</div>
          </div>
          <span><?php echo floor($ave_star*pow(10,2))/pow(10,2);?></span>
        </div>
        <p class="address"><?php echo $shop_row['address'];?></p>
        <p class="shopgenre"><?php echo $shop_row['genre'];?></p>
        <div class="picdiv"><img src="images/<?php echo $shop_row['id'];?>.jpg" class="shoppic"></div>
        <p class="number"><?php echo $shop_row['number'];?></p>
      </a>
<?php
  }
?>
    </div>
<?php
}
//結果セットを開放
//データベース切断
$PDO = null;
?>

  </div>
</body>
</html>

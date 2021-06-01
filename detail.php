<?php
function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

session_start();
$shop_id = $_GET['shop_id'];
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
/*
$this_url = $_SERVER['REQUEST_URI'];
$pos = strpos( $this_url, '=' );
$res_str = substr( $this_url, $pos+1 );*/

//データベース接続
$dsn = 'mysql:dbname=shinjinkadai_deta;host=localhost';
$user = 'root';
$password = 'Toriaezu@0705';
try{
    $PDO = new PDO($dsn, $user, $password);
}catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
}
//店情報の取得
$this_shop_result = $PDO -> query('SELECT * FROM shopdata where id ="'.$shop_id.'"');
$this_shop_row = $this_shop_result->fetch(PDO::FETCH_ASSOC);
$this_shop_rows[] = $this_shop_row;
//投稿情報の取得
$shopname = $this_shop_row['name'];
$this_shop_form_result = $PDO -> query('SELECT * FROM formdata where kind ="'.$shopname.'"');
//レコード件数の取得（投稿）
$this_form_row_count = $this_shop_form_result->rowCount();
//平均値の測定
$sql_this_shop_star = "SELECT AVG(star) FROM formdata where kind ='".$shopname."'";
$sql_this_shop_star_result = $PDO -> query($sql_this_shop_star);
$ave_star = $sql_this_shop_star_result->fetchColumn();

?>
<html>
<head>
	<title>人気料理一覧</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="shinjin.css">
</head>
<body>
<?php if ($email != "") { ?>
	<a class="tosubmit" href="input.php?kind=<?php echo $this_shop_row['name'];?>">投稿する</a>
<?php }else{ ?>
	<a class="tosubmit" href="signUp.php" style="text-align:center;">投稿するには<br>ログインしてください</a><?php }?>
	<div id="container">
    <img src="images/<?php echo $shop_id ?>.jpg" alt="店画像" style="width:88%;">
    <p class="detail_name"><?php echo $this_shop_row['name'];?></p>
  <div class="flex margin">
    <div class="star-rating flex">
      <div class="star-rating-front" style="width:<?php echo $ave_star*20;?>%">★★★★★</div>
      <div class="star-rating-back">★★★★★</div>
    </div>
    <p style="margin:0;"><?php echo floor($ave_star*pow(10,2))/pow(10,2);?></p>
    <p style="margin:0;">（<?php echo $this_form_row_count ?>）</p>
  </div>
  <p class="detail_address"><?php echo $this_shop_row['address'];?></p>
  <p class="detail_genre"><?php echo $this_shop_row['genre'];?></p>
  <p class="detail_number"><?php echo $this_shop_row['number'];?></p>

  <?php


while($this_shop_form_row = $this_shop_form_result->fetch(PDO::FETCH_ASSOC)){
  $this_shop_form_rows[] = $this_shop_form_row;
?>
  <div class="box2">
    <p class="username">
<?php
  if (is_null($this_shop_form_row['userid'])){
    echo 'ゲストさん';
  }else{
?>
  <p><?php echo substr($this_shop_form_row['userid'], 0, strcspn($this_shop_form_row['userid'],'@'));?>さん</p>
<?php
  }
?>
    <div class="flex margin">
      <div class="star-rating flex">
        <div class="star-rating-front" style="width:<?php echo $this_shop_form_row['star']*20;?>%">★★★★★</div>
        <div class="star-rating-back">★★★★★</div>
      </div>
      <p style="margin:0;"><?php echo $this_shop_form_row['star'];?></p>
    </div>
      <p style="line-height:1.6em;"><?php echo $this_shop_form_row['message'];?></p>
<?php
      	if ($this_shop_form_row['userid'] == $email){
?>
      <style media="screen">
        .tosubmit{
          display: none;
        }
      </style>
      <p id="openModal" class="edit">編集する</p>
      <section id="modalArea" class="modalArea">
        <div id="modalBg" class="modalBg"></div>
        <div class="modalWrapper">
          <div class="modalContents">
            <form action="edit.php?id=<?php echo $this_shop_form_row['id'];?>" method="post" class="form_log editp">
              <p>編集フォーム</p>
            <table style="margin:0;">
            <p class="input_kind">店名：<?php echo $this_shop_row['name'];?></p>
            <tr><th>評価：</th>
            <td>
            <input type="radio" name="kata" value="1" id="one"><label for="one">1</label>
            <input type="radio" name="kata" value="2" id="two"><label for="two">2</label>
            <input type="radio" name="kata" value="3" id="three"><label for="three">3</label>
            <input type="radio" name="kata" value="4" id="four"><label for="four">4</label>
            <input type="radio" name="kata" value="5" id="five"><label for="five">5</label>
            </td></tr>
            </table>
            <p>投稿文</p>
            <textarea name="message" cols="50" rows="5"><?php echo $this_shop_form_row['message'];?></textarea>
            <input id="send" type="submit" value="送信する" class="log_button">
            </form>
          </div>
          <div id="closeModal" class="closeModal">
            ×
          </div>
        </div>
      </section>
      <p id="openModal2" class="del">削除する</p>
      <section id="modalArea2" class="modalArea">
        <div id="modalBg2" class="modalBg"></div>
        <div class="modalWrapper">
          <div class="modalContents">
            <form action="del.php?id=<?php echo $this_shop_form_row['id'];?>" method="post" class="form_log editp">
            <p>削除確認画面</p>
            <p>投稿を削除しますか？</p>
            <div class="flex right">
              <div id="closeModal2" class="close_button">
                閉じる
              </div>
              <input id="send2" type="submit" value="削除する" class="del_button">
            </div>
            </form>
          </div>
          <div id="closeModal2" class="closeModal">
            ×
          </div>
        </div>
      </section>
<?php
        }else{
      	}
?>
  </div>

  <?php
}
$PDO = null;
?>
</div>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
$(function () {
$('#openModal').click(function(){
    $('#modalArea').fadeIn();
});
$('#closeModal , #modalBg').click(function(){
  $('#modalArea').fadeOut();
});
});
$(function () {
$('#openModal2').click(function(){
    $('#modalArea2').fadeIn();
});
$('#closeModal2 , #modalBg2').click(function(){
  $('#modalArea2').fadeOut();
});
});
</script>
</body>

</html>

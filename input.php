<?php
function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

session_start();
$input_kind = $_GET['kind'];
//ログイン済みの場合
$_SESSION['kind'] = $input_kind;
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
  p{
    margin:20px 0;
  }
  textarea{
    margin: auto;
   display: block;
   width: 100%;
   border-radius: 5px;
   font-size: 15px;
   margin-bottom: 3em;
  }
  .main_log{
    padding:20px 30px;
  }
</style>
<body id="log_body">
  <main class="main_log">
<form action="confirm.php" method="post" class="form_log">
  <h1>投稿フォーム</h1>
<table style="margin:0;">
<p class="input_kind">店名：<?php echo $input_kind; ?></p>

<tr><th>評価：</th>
<td>
<input type="radio" name="kata" value="1" id="one" checked><label for="one">1</label>
<input type="radio" name="kata" value="2" id="two"><label for="two">2</label>
<input type="radio" name="kata" value="3" id="three"><label for="three">3</label>
<input type="radio" name="kata" value="4" id="four"><label for="four">4</label>
<input type="radio" name="kata" value="5" id="five"><label for="five">5</label>

</td></tr>

</table>
<p>投稿文</p>
<textarea name="message" cols="50" rows="12"></textarea>

<input id="send" type="submit" value="送信する" class="log_button">
</form>
</main>
</body>
</html>

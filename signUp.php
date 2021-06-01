<!DOCTYPE html>
<html lang="ja">
 <head>
   <meta charset="utf-8">
   <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
   <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
   <link rel="stylesheet" href="shinjin.css">
   <meta name="viewport" content="width=device-width, initial-scale=1" />
   <title>ログイン画面</title>
 </head>
 <body id="log_body">
   <main class="main_log">
   <h1 style="text-align:center;margin-top: 0em;margin-bottom: 1em;" class="h1_log">ログインしてください</h1>
   <form action="login.php" method="post" class="form_log">
     <!--<label for="email" class="label">メールアドレス</label><br>-->
     <input type="email" name="email" class="textbox un" placeholder="メールアドレス"><br>
     <!--<label for="password" class="label">パスワード</label><br>-->
     <input type="password" name="password" class="textbox pass" placeholder="パスワード"><br>
     <button type="submit" class="log_button">ログインする</button>
   </form>
   <h1 style="text-align:center;margin-top: 2em;margin-bottom: 1em;" class="h1_log">初めての方はこちら</h1>
   <form action="register.php" method="post" class="form_log">
     <!--<label for="email" class="label">メールアドレス</label><br>-->
     <input type="email" name="email" class="textbox un" placeholder="メールアドレス"><br>
     <!--<label for="password" class="label">パスワード</label><br>-->
     <input type="password" name="password" class="textbox pass" placeholder="パスワード"><br>
     <button type="submit" class="log_button">新規登録する</button>
     <p style="text-align:center;margin-top: 1.5em;">※パスワードは半角英数字をそれぞれ１文字以上含んだ、８文字以上で設定してください。</p>
   </form>
 </main>
 </body>
</html>

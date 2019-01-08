<?php
session_start();
$_SESSION['login'] = [];
$_SESSION['user_id'] = [];
if(isset($_COOKIE[session_name()]) == true){
    setcookie(session_name(), '', time()-42000, '');
}
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログアウト | Lyrics Parser | 情報ネットワーク特論2018</title>
    <meta name="description" content="歌詞をパースしてくれるWEBアプリケーション。">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="image/favicon.ico">
    <link rel="stylesheet" type="text/css" href="dist/bundle.css">
</head>
<body>
<header class="site-header">
    <h1 class="site-header__title">Lyrics Parser</h1>
</header>

<main id="top" class="site-main" role="main">
    <article class="site-main__content">
        <section class="logout">
            <p class="logout__text">ログアウトしました。</p>
            <a class="logout__link" href="index.php">ログイン画面へ</a>
        </section>
    </article>
</main>

<footer class="site-footer">
    <p class="site-footer__content">@ <?= date('Y'); ?> Yudai TAMURA</p>
</footer>
<script src="dist/bundle.js"></script>
</body>
</html>
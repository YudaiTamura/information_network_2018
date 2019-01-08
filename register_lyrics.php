<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規歌詞登録 | Lyrics Parser | 情報ネットワーク特論2018</title>
    <meta name="description" content="歌詞をパースしてくれるWEBアプリケーション。">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="image/favicon.ico">
    <link rel="stylesheet" type="text/css" href="dist/bundle.css">
</head>
<body>
<header class="site-header">
    <h1 class="site-header__title">Lyrics Parser</h1>
</header>

<?php
session_start();
session_regenerate_id(true);
if (!isset($_SESSION['login'])) { ?>
    <main id="top" class="site-main" role="main">
        <section class="not-login">
            <p class="not-login__text">ログインされていません</p>
            <a class="not-login__link" href="index.php">ログイン画面</a>
        </section>
    </main>
    <?php
    exit();
} ?>

<main id="top" class="site-main" role="main">
    <nav class="site-main__navigation">
        <a class="site-main__navigation__item" href="lyrics_list.php">歌詞リスト</a>
        <a class="site-main__navigation__item" href="register_lyrics.php">歌詞検索</a>
        <a class="site-main__navigation__item" href="logout.php">ログアウト</a>
    </nav>

    <article class="site-main__content">
        <section class="register-lyrics">

            <form class="register-lyrics__form" method="post" action="register_lyrics_accept.php">
                <p class="register-lyrics__form__label">登録したい曲の曲名を入力してください</p>
                <input name="song_title" type="text" class="register-lyrics__form__song-title" placeholder="例：花">
                <p class="register-lyrics__form__label">登録したい曲の歌手名を入力してください</p>
                <input name="singer_name" type="text" class="register-lyrics __form__singer-name" placeholder="例：滝廉太郎">
                <button type="submit" class="register-lyrics__form__submit">新規登録</button>
            </form>

        </section>
    </article>
</main>

<footer class="site-footer">
    <p class="site-footer__content">© 2018 Yudai TAMURA</p>
</footer>
<script src="dist/bundle.js"></script>
</body>
</html>
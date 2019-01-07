<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規ユーザ登録 | Lyrics Parser | 情報ネットワーク特論2018</title>
    <meta name="description" content="歌詞をパースしてくれるWEBアプリケーション。">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="image/favicon.ico">
</head>
<body>
<header class="site-header">
    <h1 class="site-header__title">Lyrics Parser</h1>
</header>

<main id="top" class="site-main" role="main">
    <article class="site-main__content">
        <?php
        $pdo = new PDO(
            'mysql:dbname=lyrics_parser;host=localhost;',
            'root',
            'root',
            [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4']
        );

        $userName = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        try {
            $statement = $pdo->prepare('INSERT INTO `user` (`name`, `password`) VALUES (?, ?)');
            $statement->execute([$userName, $password]);
        } catch (PDOException $e) {
            header('Content-Type: text/plain; charset=UTF-8', true, 500);
            exit($e->getMessage());
        }

        $pdo = null; ?>

        <section class="add-new-user-done">
            <p class="add-new-user-done__text">
                新しいスタッフ <?= $userName; ?> さんを追加しました。
            </p>
            <a class="add-new-user-done__link" href="index.php">ログイン画面へ</a>
        </section>

    </article>
</main>

<footer class="site-footer">
    <p class="site-footer__content">© <?= date('Y'); ?> Yudai TAMURA</p>
</footer>
<script src="dist/bundle.js"></script>
</body>
</html>
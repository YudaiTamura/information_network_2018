<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン | Lyrics Parser | 情報ネットワーク特論2018</title>
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
            $statement = $pdo->prepare('SELECT * FROM `user` WHERE `name`=?');
            $statement->execute([$userName]);
        } catch (PDOException $e) {
            header('Content-Type: text/plain; charset=UTF-8', true, 500);
            exit($e->getMessage());
        }

        $usrIdMatchesPassword = false;
        $userId = null;
        while ($userRecord = $statement->fetch(PDO::FETCH_ASSOC)) {
            if (password_verify($password, $userRecord['password'])) {
                $usrIdMatchesPassword = true;
                $userId = $userRecord['id'];
                break;
            }
        }

        if ($usrIdMatchesPassword) {
            session_start();
            $_SESSION['login'] = 1;
            $_SESSION['user_id'] = $userId;
            header('Location: lyrics_list.php');
        } else { ?>
            <section class="login-failure">
                <p class="login-failure__text">ユーザ名かパスワードが間違ってます</p>
                <button class="login-failure__back" type="button" onclick="history.back()">戻る</button>
            </section>
        <?php }
        $pdo = null; ?>
    </article>
</main>

<footer class="site-footer">
    <p class="site-footer__content">© <?= date('Y'); ?> Yudai TAMURA</p>
</footer>
<script src="dist/bundle.js"></script>
</body>
</html>
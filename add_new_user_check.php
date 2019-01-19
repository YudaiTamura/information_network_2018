<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規ユーザ登録 | Lyrics Parser | 情報ネットワーク特論2018</title>
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
        <section class="add-new-user-check">
            <div class="add-new-user-check__wrapper">
                <?php
                $userName = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);
                $passwordAgain = htmlspecialchars($_POST['password-again']);

                if ($userName) { ?>
                    <p class="add-new-user-check__wrapper__content">ユーザ名： <?= $userName; ?></p>
                <?php } else { ?>
                    <p class="add-new-user-check__wrapper__content font-pink">ユーザ名が入力されていません</p>
                <?php }

                $passwordConditionFulfilled = preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $password);

                if (empty($password)) { ?>
                    <p class="add-new-user-check__wrapper__content font-pink">パスワードが入力されていません</p>
                <?php } else if ($password != $passwordAgain) { ?>
                    <p class="add-new-user-check__wrapper__content font-pink">パスワードが一致しません</p>
                <?php } else { // パスワードが入力されていて、かつ再度入力したものも一致しているとき
                    if (!$passwordConditionFulfilled) { ?>
                        <p class="add-new-user-check__wrapper__content font-pink">
                            小文字、大文字、数字をそれぞれ1種類以上含む8文字以上のパスワードを設定してください
                        </p>
                    <?php } else {
                        $display_password = '';
                        for ($i = 1; $i <= mb_strlen($password); $i++) {
                            $display_password = $display_password . '･';
                        } ?>
                        <p class="add-new-user-check__wrapper__content">
                            パスワード：<?= $display_password; ?>
                        </p>
                    <?php }
                } ?>
            </div>

            <form class="add-new-user-check__form" method="post" action="add_new_user_done.php">
                <button type="button" onclick="history.back()">戻る</button>
                <?php if ($userName && $password && $password == $passwordAgain && $passwordConditionFulfilled) { ?>
                    <input name="username" type="hidden" value="<?= $userName; ?>">
                    <input name="password" type="hidden" value="<?= password_hash($password, PASSWORD_BCRYPT); ?>">
                    <button type="submit">追加</button>
                <?php } ?>
            </form>
        </section>
    </article>
</main>

<footer class="site-footer">
    <p class="site-footer__content">© <?= date('Y'); ?> Yudai TAMURA</p>
</footer>
</body>
</html>
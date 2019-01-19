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
        <section class="login">
            <h2 class="login__title">ログイン</h2>
            <form class="login__form" method="post" action="login_check.php">
                <p class="login__form__label">USER NAME</p>
                <input name="username" type="text" class="login__form__username" placeholder="ユーザ名を入力してください">
                <p class="login__form__label">PASSWORD</p>
                <input name="password" type="password" class="login__form__password" placeholder="パスワードを入力してください">
                <button type="submit" class="login__form__submit">ログイン</button>
            </form>
        </section>

        <section class="add-new-user">
            <h2 class="add-new-user__title">新規ユーザ登録</h2>
            <form class="add-new-user__form" method="post" action="add_new_user_check.php">
                <p class="add-new-user__form__label">ユーザ名を入力してください</p>
                <input name="username" type="text" class="add-new-user__form__username" placeholder="例：山田太郎">
                <p class="add-new-user__form__label">パスワードを入力してください</p>
                <input name="password" type="password" class="add-new-user __form__password"
                       placeholder="小文字、大文字、数字をそれぞれ1種類以上含む8文字以上">
                <input name="password-again" type="password" class="add-new-user__form__password-again"
                       placeholder="確認のため、再度パスワードを入力してください">
                <button type="submit" class="add-new-user__form__submit">新規登録</button>
            </form>
        </section>
    </article>
</main>

<footer class="site-footer">
    <p class="site-footer__content">@ <?= date('Y'); ?> Yudai TAMURA</p>
</footer>
</body>
</html>
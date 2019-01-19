<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>歌詞リスト | Lyrics Parser | 情報ネットワーク特論2018</title>
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
    <footer class="site-footer">
        <p class="site-footer__content">© 2018 Yudai TAMURA</p>
    </footer>
    <?php
    exit();
} ?>

<main id="top" class="site-main with-nav" role="main">
    <nav class="site-main__navigation">
        <a class="site-main__navigation__item" href="lyrics_list.php">歌詞リスト</a>
        <a class="site-main__navigation__item" href="register_lyrics.php">歌詞検索</a>
        <a class="site-main__navigation__item" href="logout.php">ログアウト</a>
    </nav>

    <article class="site-main__content">
        <section class="lyrics-list">
            <?php
            $pdo = new PDO(
                'mysql:dbname=lyrics_parser;host=localhost;',
                'root',
                'root',
                [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4']
            );
            try {
                $statement = $pdo->prepare(
                    'SELECT song.id, song.title, singer.name, song.lyrics
                    FROM song
                    INNER JOIN singer ON singer.id = song.singer_id
                    INNER JOIN user_song ON user_song.song_id = song.id
                    WHERE user_song.user_id = ?;'
                );
                $statement->execute([$_SESSION['user_id']]);
            } catch (PDOException $e) {
                header('Content-Type: text/plain; charset=UTF-8', true, 500);
                exit($e->getMessage());
            }

            if ($record = $statement->fetch()) { ?>
                <table class="lyrics-list__table">
                    <caption class="lyrics-list__table__caption">登録済みの曲</caption>
                    <tr class="lyrics-list__table__row">
                        <th class="lyrics-list__table__row__label">曲名</th>
                        <th class="lyrics-list__table__row__label">歌手名</th>
                        <th class="lyrics-list__table__row__label">表示</th>
                        <th class="lyrics-list__table__row__label">歌詞</th>
                    </tr>
                    <tr class="lyrics-list__table__row">
                        <td id="song-<?= $record["id"]; ?>" class="lyrics-list__table__row__data">
                            <?= $record["title"]; ?>
                        </td>
                        <td class="lyrics-list__table__row__data"><?= $record["name"]; ?></td>
                        <td class="lyrics-list__table__row__data">
                            <button type="button" class="lyrics-list__table__row__data__display-lyrics">表示</button>
                        </td>
                        <td class="lyrics-list__table__row__data"><?= $record["lyrics"]; ?></td>
                    </tr>
                    <?php while ($record = $statement->fetch()) { ?>
                        <tr class="lyrics-list__table__row">
                            <td id="song-<?= $record["id"]; ?>" class="lyrics-list__table__row__data">
                                <?= $record["title"]; ?>
                            </td>
                            <td class="lyrics-list__table__row__data"><?= $record["name"]; ?></td>
                            <td class="lyrics-list__table__row__data">
                                <button type="button" class="lyrics-list__table__row__data__display-lyrics">表示</button>
                            </td>
                            <td class="lyrics-list__table__row__data"><?= $record["lyrics"]; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p class="lyrics-list__no-lyrics-to-display">登録された曲がありません</p>
            <?php } ?>
        </section>
    </article>
</main>

<footer class="site-footer">
    <p class="site-footer__content">© 2018 Yudai TAMURA</p>
</footer>
<script src="dist/bundle.js"></script>
</body>
</html>
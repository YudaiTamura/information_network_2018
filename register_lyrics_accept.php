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
        <section class="register-lyrics-accept">
            <?php
            $songTitle = htmlspecialchars($_POST['song_title']);
            $singerName = htmlspecialchars($_POST['singer_name']);

            if ($songTitle == "") { ?>
                <p class="register-lyrics-accept__no-title font-red">曲名が入力されていません</p>
            <?php }

            if ($singerName == "") { ?>
                <p class="register-lyrics-accept__no-singer font-red">歌手名が入力されていません</p>
            <?php }

            if ($songTitle == "" or $singerName == "") { ?>
                <button class="register-lyrics-accept__back-to-register" type="button" onclick="history.back()">
                    戻る
                </button>
            <?php } else {
                $pdo = new PDO(
                    'mysql:dbname=lyrics_parser;host=localhost;',
                    'root',
                    'root',
                    [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4']
                );
                try { // 入力された曲名と歌手名とユーザIDの組み合わせがDBにあるかチェック
                    $checkTheSongAlreadyExistInDbQuery = $pdo->prepare(
                        'SELECT * FROM song
                        INNER JOIN singer ON singer.id = song.singer_id
                        INNER JOIN user_song ON user_song.song_id = song.id
                        WHERE song.title = ? AND singer.name = ? AND user_song.user_id = ?;'
                    );
                    $checkTheSongAlreadyExistInDbQuery->execute([$songTitle, $singerName, $_SESSION['user_id']]);
                } catch (PDOException $e) {
                    header('Content-Type: text/plain; charset=UTF-8', true, 500);
                    exit($e->getMessage());
                }
                if ($record = $checkTheSongAlreadyExistInDbQuery->fetch()) { // 登録しようとした曲が既に登録されている場合はリダイレクト
                    header('Location: lyrics_list.php#song-' . $record['id']);
                } else { // 登録しようとした曲がまだ登録されていない場合はDBに曲名、歌手名、ユーザIDのみを登録して、重い処理はバックグラウンドで実行する
                    try {
                        // 歌手名をDBにインサート
                        $insertSingerNameQuery = $pdo->prepare('INSERT INTO singer (`name`) VALUES (?)');
                        $insertSingerNameQuery->execute([$singerName]);

                        // 曲名をDBにインサート
                        $insertSongTitleQuery = $pdo->prepare(
                            'INSERT INTO song (title, singer_id)
                            SELECT ?, id FROM singer
                            WHERE `name` = ?;'
                        );
                        $insertSongTitleQuery->execute([$songTitle, $singerName]);

                        // ユーザIDをDBにインサート
                        $insertUserIdQuery = $pdo->prepare(
                            'INSERT INTO user_song (user_id, song_id)
                            SELECT ?, song.id FROM song
                            INNER JOIN singer ON singer.id = song.singer_id
                            WHERE song.title = ? AND singer.name = ?;'
                        );
                        $insertUserIdQuery->execute([$_SESSION['user_id'], $songTitle, $singerName]);

                        // background_lyrics_parser.phpにsong.idを渡すためにクエリ実行
                        $getSongIdQuery = $pdo->prepare(
                            'SELECT song.id, song.title, singer.name FROM song
                            INNER JOIN singer ON singer.id = song.singer_id
                            WHERE song.title = ? AND singer.name = ?;'
                        );
                        $getSongIdQuery->execute([$songTitle, $singerName]);
                        $songInformation = $getSongIdQuery->fetch();
                        $songIdForBackgroundProgram = $songInformation['id'];
                        $songTitleForBackgroundProgram = $songInformation['title'];
                        $singerNameForBackgroundProgram = $songInformation['name'];

                    } catch (PDOException $e) {
                        header('Content-Type: text/plain; charset=UTF-8', true, 500);
                        exit($e->getMessage());
                    }
                    // バックグラウンドでその曲の歌詞を歌詞サイトから取ってくる
                    $command = 'nohup ' . PHP_BINDIR . '/php background_lyrics_parser.php "' .
                        $songIdForBackgroundProgram . '" "' .
                        $songTitleForBackgroundProgram . '" "' .
                        $singerNameForBackgroundProgram . '" > /dev/null &';
                    exec($command);
                    ?>

                    <div class="register-lyrics-accept__done">
                        <ul class="register-lyrics-accept__done__song-info">
                            <li class="register-lyrics-accept__done__song-info__item">
                                曲名： <?= $songTitle; ?>
                            </li>
                            <li class="register-lyrics-accept__done__song-info__item">
                                歌手名： <?= $singerName; ?>
                            </li>
                        </ul>
                        <p class="register-lyrics-accept__done__text">
                            上記の歌詞の登録を受け付けました。
                            反映には時間がかかることがあります。
                            また、歌詞ネットに存在しない曲の場合は歌詞の登録は行われません。
                        </p>
                    </div>

                <?php }
                $pdo = null;
            } ?>
        </section>
    </article>
</main>

<footer class="site-footer">
    <p class="site-footer__content">© <?= date('Y'); ?> Yudai TAMURA</p>
</footer>
<script src="dist/bundle.js"></script>
</body>
</html>
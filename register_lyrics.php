<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規歌詞登録 | Lyrics Parser | 情報ネットワーク特論2018</title>
    <meta name="description" content="歌詞をパースしてくれるWEBアプリケーション。">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="image/favicon.ico">
</head>
<body>
<header class="site-header">
    <h1 class="site-header__title">Lyrics Parser</h1>
</header>

<main id="top" class="site-main" role="main">
    <nav class="site-main__navigation">
        <a class="site-main__navigation__item" href="lyrics_list.php">歌詞リスト</a>
        <a class="site-main__navigation__item" href="index.php">歌詞検索</a>
    </nav>

    <article class="site-main__content">
        <form action="post" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>曲名：</td>
                    <td><input type="text" name="title" style="margin-right: 20px" value=<%= inputtedTexts["title"] %>>
                    </td>
                    <td style=color:red><%= errorMessages["title"] %></td>
                </tr>
                <tr>
                    <td>歌手名：</td>
                    <td><input type="text" name="singerName" style="margin-right: 20px" value=<%= inputtedTexts["singerName"] %>></td>
                    <td style=color:red><%= errorMessages["singerName"] %></td>
                </tr>
                <tr>
                    <td>mp3ファイル：</td>
                    <td><input type="file" name="mp3file" size="30"></td>
                    <td style=color:red><%= errorMessages["mp3file"] %></td>
                </tr>
            </table>

            <input type="submit" value="新たに登録する">
        </form>
    </article>
</main>

<footer class="site-footer">
    <p class="site-footer__content">© 2018 Yudai TAMURA</p>
</footer>
</body>
</html>
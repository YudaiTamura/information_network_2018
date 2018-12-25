<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>歌詞リスト | Lyrics Parser | 情報ネットワーク特論2018</title>
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
        <div class="divForReference" align="center">
            <form action="./" method="get">
                <table>
                    <tr>
                        <td>曲名：</td>
                        <td><input type="text" name="title" style="margin-right: 20px"></td>
                        <td style=color:red></td>
                    </tr>
                    <tr>
                        <td>歌手名：</td>
                        <td><input type="text" name="singerName" style="margin-right: 20px"></td>
                        <td style=color:red></td>
                    </tr>
                </table>
                <input type="submit" value="登録済み曲を検索">
            </form>
            <% if (boardList.length == 0){ %>
            <p>検索結果がありません</p>
            <% } %>
        </div>
        <div align="center">
            <a class="register" href="registration/">
                曲の新規登録を行う
            </a>
        </div>
        <br>
        <% if (boardList.length != 0){ %>
        <div align="center">
            <table border="1">
                <caption><b>登録済みの曲</b></caption>
                <tr>
                    <th>#</th>
                    <th>曲名</th>
                    <th>歌手名</th>
                </tr>
                <% boardList.forEach(function (value) { %>
                <tr>
                    <td><a name="anchor<%= value["id"] %>"><%= value["id"] %></a></td>
                    <td><a><%= value["title"] %></a></td>
                    <td><%= value["name"] %></td>
                    
                </tr>
                <% }); %>
            </table>
        </div>
    </article>
</main>

<footer class="site-footer">
    <p class="site-footer__content">© 2018 Yudai TAMURA</p>
</footer>
</body>
</html>
<?php
$songIdToRegister = $argv[1];
$songTitleToRegister = $argv[2];
$singerNameToRegister = $argv[3];

try {

    // まずは曲名で検索して歌手名が一致する曲へのURLを取得する
    $urlToSearchByTitle = 'https://www.uta-net.com/search/?Aselect=2&Keyword=' . $songTitleToRegister . '&Bselect=4';
    $singerNameMatchesSearchResult = false;
    $urlToSingleSongPage = '';
    $songListPageDom = new DOMDocument;
    @$songListPageDom->loadHTMLFile($urlToSearchByTitle);
    $xpath = new DOMXPath($songListPageDom);
    foreach ($xpath->query('//div[contains(@class,"result_table")]/table/tbody/tr') as $targetNode) {
        $singerNameFromSearchedBySongTitleList = $xpath->evaluate('string(./td[contains(@class,"td2")]/a)', $targetNode);
        if ($singerNameToRegister == $singerNameFromSearchedBySongTitleList) {
            $singerNameMatchesSearchResult = true;
            $urlToSingleSongPage = "https://www.uta-net.com" . $xpath->evaluate('string(./td[contains(@class,"td1")]/a/@href)', $targetNode);
            break;
        }
    }


    // 歌手名と曲名のペアが検索に引っかからなかった場合
    if ($urlToSingleSongPage == '') {
        throw new Exception('歌手名と曲名のペアが検索に引っかからなかった');
    }


    // 歌手名が一致した曲のURLにアクセスして歌詞をパースする
    $songSinglePageDom = new DOMDocument;
    @$songSinglePageDom->loadHTMLFile($urlToSingleSongPage);
    $xpath = new DOMXPath($songSinglePageDom);
    $correctTitle = "";
    $lyricsText = "";
    foreach ($xpath->query('//div[@id="view_kashi"]') as $viewKashiNode) {
        $correctTitle = $xpath->evaluate('string(./div/div[contains(@class,"title")]/h2)', $viewKashiNode);
        $lyricsText = $xpath->evaluate('string(./div/div[@id="flash_area"]/div/div[@id="kashi_area"])', $viewKashiNode);
    }


    // 取得した歌詞と正しい曲名をDBに書き込む
    $pdo = new PDO(
        'mysql:dbname=lyrics_parser;host=localhost;',
        'root',
        'root',
        [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4']
    );
    try {
        $updateLyricsAndTitleQuery = $pdo->prepare('UPDATE song SET title=?, lyrics=? WHERE id=?;');
        $updateLyricsAndTitleQuery->execute([$correctTitle, $lyricsText, $songIdToRegister]);
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
    $pdo = null;


} catch (Exception $e) { // 目当ての検索結果がなかった時は該当するレコードをテーブルから削除
    $pdo = new PDO(
        'mysql:dbname=lyrics_parser;host=localhost;',
        'root',
        'root',
        [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4']
    );
    try {
        $deleteUserSongRecordQuery = $pdo->prepare('DELETE FROM `user_song` WHERE `song_id`=?;');
        $deleteUserSongRecordQuery->execute([$songIdToRegister]);
        $deleteSongRecordQuery = $pdo->prepare('DELETE FROM `song` WHERE `id`=?;');
        $deleteSongRecordQuery->execute([$songIdToRegister]);
    } catch (PDOException $e) {
        header('Content-Type: text/plain; charset=UTF-8', true, 500);
        exit($e->getMessage());
    }
    $pdo = null;
    exit($e->getMessage());
}
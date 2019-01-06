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
    foreach ($xpath->query('//div[@class="result_table"]/table/tbody/tr') as $targetNode) {
        $singerNameFromSearchedBySongTitleList = $xpath->evaluate('string(./td[@class="td2"]/a)', $targetNode);
        if ($singerNameToRegister == $singerNameFromSearchedBySongTitleList) {
            $singerNameMatchesSearchResult = true;
            $urlToSingleSongPage = "https://www.uta-net.com" . $xpath->evaluate('string(./td[@class="side td1"]/a/@href)', $targetNode);
            break;
        }
    }


    // 歌手名と曲名のペアが検索に引っかからなかった場合
    /*if ($urlToSingleSongPage == '') {
        // TODO: エラーに飛ばす
    }*/


    // 歌手名が一致した曲のURLにアクセスして歌詞をパースする
    $songSinglePageDom = new DOMDocument;
    @$songSinglePageDom->loadHTMLFile($urlToSingleSongPage);
    $xpath = new DOMXPath($songSinglePageDom);
    $correctTitle = "";
    $lyricsText = "";
    foreach ($xpath->query('//div[@id="view_kashi"]') as $viewKashiNode) {
        $correctTitle = $xpath->evaluate('string(./div/div[@class="title"]/h2)', $viewKashiNode);
        $lyricsText = $xpath->evaluate('string(./div/div[@id="flash_area"]/div/div[@id="kashi_area"])', $viewKashiNode);
    }

    file_put_contents('output.txt', $correctTitle);



} catch (Exception $e) { // 曲名の検索結果がなかった時は該当するレコードをテーブルから削除
    // TODO: DBからレコード削除する処理
    file_put_contents('output.txt', "エラー！！！");
}
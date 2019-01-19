# このリポジトリについて
 PHPの演習授業での制作物を管理するリポジトリです。
 内容としては[こちら](https://github.com/YudaiTamura/lyrics-parser-for-practice)のコードの簡易版をPHPに書き換えただけです。
 開発はGitHub Flowでやりたい。とおもったが、ちいさいアプリなので基本的にはdevelopブランチで開発して、動くようになったらmasterにマージすることにする。

# 概要
[歌ネット](https://www.uta-net.com)で歌詞を検索すると、歌詞は出てくるものの、コピーができないようにプロテクトがかかっている。
しかし、htmlのソースにはしっかり歌詞が書かれているのでhtmlのソースから歌詞のテキストをパースしてDBに突っ込んじゃいましょう、というプログラム。

# Requirements
* PHP >= 7.2
* MySQL >= 5.6.38
* npm >= 6.4.1

# インストール
リポジトリのクローン
```
$ git clone git@github.com:YudaiTamura/information_network_2018.git
$ cd information_network_2018
```
DBの作成
```
mysql> sql/database.sql
```
SCSSのビルド
```
$ npm install
$ npm run build
```
<?php

/* DB設定 */
// DBの種類 (0: MySQL, 1: PostgreSQL)
$db_type   = 1;
// ホスト名
$db_host   = 'localhost';
// ポート (NULLでデフォルト)
$db_port   = NULL;
// DB名
$db_name   = 'gokusotsu_blog';
// ユーザ名
$db_user   = 'gokusotsu';
// パスワード
$db_passwd = 'Hise78-F';


/* サイト設定 */
// サイトタイトル
$site_title = '獄卒ブロガー(仮)';
// サイトトップのURL
$site_url = 'http://kazy111.info/blogger';
// サーバ上での設置場所
$file_path = '/usr/home/kazy/public_html/blogger/';
// メールフォームの送り先メールアドレス
$admin_mail = 'kazy@kazy111.info';

// トップページヘッダに表示する説明
$header_description = '<a href="http://www.gokusotsu.com/top/?cat=3">獄卒ch</a>関係な人のブログを勝手に集めたページ／ブログ横断でカテゴリ検索できるよ';
// フッタに表示する説明
$footer_description = '意見、報告、要望は<a href="http://twitter.com/kazy111">じゃわてぃー</a>まで';
// 最初に表示するテーマ
$default_theme='default';
// トップページでのデフォルトのソート順 viewer, name, time, random
$default_sort='random';


// 記事一覧等で1ページに表示する数
$page_size = 15;



// timezone
date_default_timezone_set('Asia/Tokyo');
setlocale(LC_TIME, 'ja_JP.UTF-8');

// デバッグフラグ
$debug = TRUE;

?>
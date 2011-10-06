
<div class="main">

<h1 id="title"><a href="{$site_url}">{$site_title}</a></h1>

{include file="$file_path/themes/default/header_text.tpl"}


<div id="menu">
<div class="option">
<div>テーマ: {$theme_data}</div>
</div>
</div>
<a href="{$site_url}/rss.php"><img src="{$relative_dir_to_top}/themes/default/feed-icon.png" width="24" height="24" /></a>

<br />

<div id="tagcloud">
{$tagcloud_data}
</div>

<div class="contents">

<div id="notice"></div>

<div id="article">
{$item_data}
</div>


{$navigate_data}

<h3>収集先</h3>
{$feed_data}

{include file="$file_path/themes/default/footer_text.tpl"}

</div>

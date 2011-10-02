
<div class="main">

<h1 id="title"><a href="{$site_url}">{$site_title}</a></h1>

{include file="$file_path/themes/default/header_text.tpl"}


<div id="menu">
<div class="option">
<div>テーマ: {$theme_data}</div>
</div>
</div>

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

<div class="article">
<span class="article_title"><a href="{$permalink}">{$title}</a></span>
<div class="article_header">
  <span class="article_author"><a href="{$blog_url}">{$author}</a></span>
  {if $category != ''}
  <span class="article_category"><a href="{$category_url}">[{$category}]</a></span>
  {/if}
   - <span class="article_date">{$date}</span>
</div>
<div class="article_body">
  <span class="article_description" id="desc{$id}">{$description}...
  {if $body != '' && trim(trim(trim($body,'<p>'),'</p>')) != trim($description) }
    <a onclick="$('#desc{$id}').slideUp();$('#detail{$id}').slideDown();">More</a>
  {/if}
  </span>
  {if $body != '' && $body != $description}
  <div class="article_detail" style="display: none;" id="detail{$id}">
  <a onclick="$('#desc{$id}').slideDown();$('#detail{$id}').slideUp();">Close</a><br/>
  {$body}
  </div>
  {/if}
</div>
<div class="article_footer"></div>
</div>

<div id="body">
    <p>{current_page}/{current_fun}</p>
    <!-- Variable Pairs -->
    <?php
    foreach ($content as $row)
    {
        if (!empty($row['disabled']))
        {
            ?><div class="content_block"><b><?=$row['content_title']?></b></div><?php
        }
        else
        {
            ?><div class="content_block"><a href="<?=$row['content_url']?>"><b><?=$row['content_title']?></b></a></div><?php
        }
    }
    ?>
    <!-- Variable Pairs -->
</div>
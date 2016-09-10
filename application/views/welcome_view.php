<div id="body">
    <p>{current_page}/{current_fun}</p>
    <!-- Variable Pairs --><div class="container-fluid"><div class="row"><?php foreach ($content as $row){
            ?><div class="col-xs-12 col-sm-6 col-md-4 col-lg-3"><?php
            if (empty($row['disabled'])) { ?><a href="<?=$row['content_url']?>"><?php }
            ?><div class="content_block"><b><?=$row['content_title']?></b></div><?php
            if (empty($row['disabled'])) { ?></a><?php }
            ?></div><?php
    } ?></div></div><!-- Variable Pairs -->
</div>
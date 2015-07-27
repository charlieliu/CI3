<div data-role="panel" id="left-panel" data-position="left" data-theme="b">
    <div style="margin-left:1em;">
        <a href="<?=base_url()?>" data-ajax="false">
            <div style="padding:2px 6px;">
                <div>Home</div>
            </div>
        </a>
    </div>
    <?php foreach ($head_list as $row): ?>
        <div style="margin-left:1em;">
            <a href="<?=$row['content_url']?>" data-ajax="false"><div style="padding:2px 6px;"><div><?=$row['content_title']?></div></div></a>
            <?PHP if(count($row['children'])): ?>
                <?php foreach ($row['children'] as $val): ?>
                <div style="margin-left:1em;">
                    <a href="<?=$val['content_url']?>" data-ajax="false"><div style="padding:2px 6px;"><div><?=$val['content_title']?></div></div></a>
                </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    <?php endforeach ?>
</div>
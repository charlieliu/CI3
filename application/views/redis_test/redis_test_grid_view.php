<?php foreach ($redis_act as $black): ?>
    <div class="content_block">
    <h3><?=$black['title']?></h3>DB:<span class="dblink"><?=$redis_db?></span>
    <?php foreach ($black['act'] as $key=>$value): ?>
        <div class="mg1em">
            <div><?=$value?></div>
            <form id="<?=$key?>" class="redis_test" method="POST">
                <input type="hidden" name="redis_act" value="<?=$key?>">
                <?php if( substr_count($value,'option') ): ?><input type="text" name="opt_str" value="" placeholder="option"><?php endif; ?>
                <?php if( substr_count($value,'key') ): ?><input type="text" name="key_str" value="" placeholder="key"><?php endif; ?>
                <?php if( substr_count($value,'index') ): ?><input type="text" name="ind_str" value="" placeholder="index"><?php endif; ?>
                <?php if( substr_count($value,'count') ): ?><input type="text" name="ind_str" value="" placeholder="count"><?php endif; ?>
                <?php if( substr_count($value,'offset') ): ?><input type="text" name="off_str" value="" placeholder="offset"><?php endif; ?>
                <?php if( substr_count($value,'BEFORE|AFTER') ): ?><input type="text" name="off_str" value="" placeholder="BEFORE|AFTER"><?php endif; ?>
                <?php if( substr_count($value,'pivot') ): ?><input type="text" name="field_str" value="" placeholder="pivot"><?php endif; ?>
                <?php if( substr_count($value,'field') ): ?><input type="text" name="field_str" value="" placeholder="field"><?php endif; ?>
                <?php if( substr_count($value,'value') ): ?><input type="text" name="val_str" value="" placeholder="value"><?php endif; ?>
                <?php if( substr_count($value,'integer') ): ?><input type="text" name="val_str" value="" placeholder="integer"><?php endif; ?>
                <?php if( substr_count($value,'min') ): ?><input type="text" name="val_str" value="" placeholder="min"><?php endif; ?>
                <?php if( substr_count($value,'start') ): ?><input type="text" name="val_str" value="" placeholder="start"><?php endif; ?>
                <?php if( substr_count($value,'float') ): ?><input type="text" name="val_str" value="" placeholder="float"><?php endif; ?>
                <?php if( substr_count($value,'key2') ): ?><input type="text" name="key_str2" value="" placeholder="key2"><?php endif; ?>
                <?php if( substr_count($value,'value2') ): ?><input type="text" name="val_str2" value="" placeholder="value2"><?php endif; ?>
                <?php if( substr_count($value,'max') ): ?><input type="text" name="val_str2" value="" placeholder="max"><?php endif; ?>
                <?php if( substr_count($value,'score') ): ?><input type="text" name="score" value="" placeholder="score"><?php endif; ?>
                <?php if( substr_count($value,'member') ): ?><input type="text" name="val_str" value="" placeholder="member"><?php endif; ?>
                <?php if( substr_count($value,'end') ): ?><input type="text" name="val_str2" value="" placeholder="end"><?php endif; ?>
                <?php if( substr_count($value,'key3') ): ?><input type="text" name="key_str3" value="" placeholder="key3"><?php endif; ?>
                <?php if( substr_count($value,'dstkey') ): ?><input type="text" name="dstkey" value="" placeholder="dstkey"><?php endif; ?>
                <?php if( substr_count($value,'value3') ): ?><input type="text" name="val_str3" value="" placeholder="value3"><?php endif; ?>
                <?php if( substr_count($value,'numkey') ): ?><input type="text" name="numkey" value="" placeholder="numkey"><?php endif; ?>
                <input type="hidden" name="{csrf_name}" value="{csrf_value}">
                <input type="submit" value="<?=$key?>">
            </form>
        </div>
    <?PHP endforeach; ?>
    </div>
<?PHP endforeach; ?>
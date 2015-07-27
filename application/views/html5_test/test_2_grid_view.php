<?php foreach ($type_arr as $data): ?>
    <li>
        <form class="contact1">
            <div class="content_block mg1em padding1em">
                <?php if($data['type']=='text'): ?>
                    &lt;input type="<?=$data['type']?>"&nbsp;name="<?=$data['type']?>" id="<?=$data['type']?>"&nbsp;<span style="color:red;">required</span>&gt;
                <?php else: ?>
                    &lt;input&nbsp;<span style="color:red;">type="<?=$data['type']?>"</span>&nbsp;name="<?=$data['type']?>" id="<?=$data['type']?>" required&gt;
                <?php endif; ?>
            </div>
            <table class="mg1em" border="1" style="text-align:center;">
                <tr>
                    <?php foreach ($data['browser_support'] as $key => $value): ?><th><?=$key?></th><?PHP endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($data['browser_support'] as $key => $value): ?><td><?=(empty($value)?'X':'O')?></td><?PHP endforeach; ?>
                </tr>
            </table>
            <div class="mg1em">
                <input type="<?=$data['type']?>" name="<?=$data['type']?>" id="<?=$data['type']?>" required>
                <input type="hidden" name="{csrf_name}" value="{csrf_value}">
                <input type="submit" name="submit" value="Submit">
            </div>
            <div class="mg1em results"></div>
        </form>
    </li>
<?PHP endforeach; ?>

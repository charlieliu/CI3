<tr>
    <?php foreach ($th as $value): ?><th><?=$value?></th><?php endforeach; ?>
</tr>
<?php foreach ($td as $row): ?>
    <tr>
        <?php foreach ($row as $value): ?><td><?=$value?></td><?php endforeach; ?>
    </tr>
<?php endforeach; ?>
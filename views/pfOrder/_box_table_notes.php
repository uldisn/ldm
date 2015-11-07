<?php
foreach ($notes as $note) {
    ?>
    <tr>
        <td><?=$note->created?></td>
        <td><?=pfOrder::$lists['pprs'][$note->from_pprs_id]?></td>
        <td><?=pfOrder::$lists['pprs'][$note->to_pprs_id]?></td>
        <td><?=$note->message?></td>
        <td><?=$note->readed?></td>
    </tr>
    <?php
}

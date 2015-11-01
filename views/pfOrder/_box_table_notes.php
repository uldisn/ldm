<?php
foreach ($notes as $note) {
    ?>
    <tr>
        <td><?=$note->created?></td>
        <td><?=$note->fromPprs->getItemLabel()?></td>
        <td><?=$note->toPprs->getItemLabel()?></td>
        <td><?=$note->message?></td>
        <td><?=$note->readed?></td>
    </tr>
    <?php
}

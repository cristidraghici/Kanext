<tr class="board-swimlane-columns-empty">
    <?php foreach ($swimlane['columns'] as $column): ?>
    <th class="board-column-header-empty board-column-header-<?= $column['id'] ?>" data-column-id="<?= $column['id'] ?>"></th>
    <?php endforeach ?>
</tr>

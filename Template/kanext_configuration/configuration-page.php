<div class="page-header">
    <h2><?= t('Kanext settings', 'kanext') ?></h2>
</div>

<form method="post" action="<?= $this->url->href('KanextConfigController', 'save', array('plugin' => 'Kanext')) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <?php foreach ($groups as $group): ?>
    <fieldset>
        <legend><?= $group['title'] ?></legend>

        <?php if ($group['description'] && strlen($group['description']) > 0): ?>
            <p><?= $group['description'] ?></p>
        <?php endif; ?>

        <?php foreach ($options as $option_name => $option): if ($option['group'] !== $group['slug']) { continue; } ?>
            <?php if ($option['type'] === 'checkbox'): ?>
                <?= $this->form->checkbox($option_name, $option['title'], 1, $option['value'] == 1); ?>
            <?php endif; ?>

            <?php if ($option['type'] === 'textarea'): ?>
                <?= $this->form->label($option['title'], $option_name) ?>
                <?= $this->form->textarea($option_name, $values, $errors); ?>
            <?php endif; ?>

            <?php if ($option['type'] === 'textEditor'): ?>
                <?= $this->form->label($option['title'], $option_name) ?>
                <?= $this->form->textEditor($option_name, $values, $errors); ?>
            <?php endif; ?>

            <?php if ($option['type'] === 'number'): ?>
                <?= $this->form->label($option['title'], $option_name) ?>
                <?= $this->form->number($option_name, $values, $errors); ?>
            <?php endif; ?>

            <?php if ($option['description'] && strlen($option['description']) > 0): ?>
                <p class="form-help"><?= $option['description'] ?></p>
            <?php endif; ?>
        <?php endforeach; ?>
    </fieldset>
    <?php endforeach; ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?= t('Save'); ?></button>
    </div>
</form>

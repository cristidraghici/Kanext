<div class="page-header">
    <h2><?php echo t('Kanext settings', 'kanext'); ?></h2>
</div>

<form method="post" action="<?php echo $this->url->href('KanextConfigController', 'save', ['plugin' => 'Kanext']); ?>" autocomplete="off">
    <?php echo $this->form->csrf(); ?>

    <?php foreach ($groups as $group) { ?>
    <fieldset>
        <legend><?php echo $group['title']; ?></legend>

        <?php if ($group['description'] && strlen($group['description']) > 0) { ?>
            <p><?php echo $group['description']; ?></p>
        <?php } ?>

        <?php foreach ($options as $option_name => $option) {
            if ($option['group'] !== $group['slug']) {
                continue;
            } ?>
            <?php if ('checkbox' === $option['type']) { ?>
                <?php echo $this->form->checkbox($option_name, $option['title'], 1, 1 == $option['value']); ?>
            <?php } ?>

            <?php if ('textarea' === $option['type']) { ?>
                <?php echo $this->form->label($option['title'], $option_name); ?>
                <?php echo $this->form->textarea($option_name, $values, $errors); ?>
            <?php } ?>

            <?php if ('textEditor' === $option['type']) { ?>
                <?php echo $this->form->label($option['title'], $option_name); ?>
                <?php echo $this->form->textEditor($option_name, $values, $errors); ?>
            <?php } ?>

            <?php if ('number' === $option['type']) { ?>
                <?php echo $this->form->label($option['title'], $option_name); ?>
                <?php echo $this->form->number($option_name, $values, $errors); ?>
            <?php } ?>

            <?php if ('select' === $option['type']) { ?>
                <?php echo $this->form->label($option['title'], $option_name); ?>
                <?php echo $this->form->select($option_name, $option['options'], $values, $errors); ?>
            <?php } ?>

            <?php if ($option['description'] && strlen($option['description']) > 0) { ?>
                <p class="form-help"><?php echo $option['description']; ?></p>
            <?php } ?>
        <?php } ?>
    </fieldset>
    <?php } ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?php echo t('Save'); ?></button>
    </div>
</form>

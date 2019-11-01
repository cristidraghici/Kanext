<div class="page-header">
    <h2><?= t('Kanext settings', 'kanext') ?></h2>
</div>

<form method="post" action="<?= $this->url->href('KanextConfigController', 'save', array('plugin' => 'Kanext')) ?>" autocomplete="off">
    <?= $this->form->csrf() ?>

    <fieldset>
        <legend><?= t('Activity on dashboard', 'kanext') ?></legend>
        <?= $this->form->radios('kanext_dashboard_activity_type', array(
                'kanext_dashboard_activity_disabled' => t('Do not show activity', 'kanext'),
                'kanext_dashboard_activity_general' => t('Show general activity', 'kanext'),
            ),
            $values,
            $errors
        ) ?>
    </fieldset>

    <fieldset>
        <legend><?= t('Styling', 'kanext') ?></legend>
        <?= $this->form->checkbox('kanext_use_css_fixes', t('CSS fixes', 'kanext'), 1, $values['kanext_use_css_fixes'] == 1); ?>
        <p class="form-help"><?= t('Applies predefined general CSS fixes to the Kanboard (e.g. on the length of the search field in the dashboard)', 'kanext'); ?></p>

        <?= $this->form->checkbox('kanext_use_js_fixes', t('Javascript fixes', 'kanext'), 1, $values['kanext_use_js_fixes'] == 1); ?>
        <p class="form-help"><?= t('Applies predefined general javascript fixes to the Kanboard (e.g. changes the click behaviour)', 'kanext'); ?></p>

        <?= $this->form->label(t('Theme from submodules'), 'kanext'); ?>
        <?= $this->form->select('kanext_theme_from_submodules', array(), $values, $errors); ?>

        <?= $this->form->label(t('Custom CSS'), 'kanext'); ?>
        <?= $this->form->textarea('kanext_custom_css', $values, $errors); ?>
    </fieldset>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?= t('Save'); ?></button>
    </div>
</form>

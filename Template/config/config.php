<div class="page-header">
    <h2><?= t('Kanext settings') ?></h2>
</div>
<form method="post" action="<?= $this->url->href('KanextConfigController', 'save', array('plugin' => 'Kanext')) ?>" autocomplete="off">

    <?= $this->form->csrf() ?>

    <strong>Configuration options will be added</strong>

    <div class="form-actions">
        <button type="submit" class="btn btn-blue"><?= t('Save') ?></button>
    </div>
</form>

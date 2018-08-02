<!-- kanext: favicons and touch-icons -->
<?php if (!$this->app->configHelper->get('favicon')) : ?>
    <link rel="icon" type="image/png" href="<?php echo $this->url->dir() ?>assets/img/favicon.png">
<?php else: ?>
    <link rel="icon" type="image/png" href="<?php echo $this->url->dir() ?>plugins/Kanext/Img/<?php echo $this->app->configHelper->get('favicon') ?>">
<?php endif; ?>

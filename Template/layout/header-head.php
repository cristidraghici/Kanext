<!-- kanext: favicons and touch-icons -->
<?php if (!$this->app->configHelper->get('favicon')) : ?>
    <link rel="icon" type="image/png" href="<?php echo $this->url->dir() ?>assets/img/favicon.png">
<?php else: ?>
    <link rel="icon" type="image/png" href="<?php echo $this->url->dir() ?>plugins/Kanext/Img/<?php echo $this->app->configHelper->get('favicon') ?>">
<?php endif; ?>

<?php if (!$this->app->configHelper->get('apple-touch-icon')) : ?>
    <link rel="apple-touch-icon" href="<?php echo $this->url->dir() ?>assets/img/touch-icon-iphone.png">
<?php else: ?>
    <link rel="apple-touch-icon" href="<?php echo $this->url->dir() ?>plugins/Kanext/Img/<?php echo $this->app->configHelper->get('apple-touch-icon') ?>">
<?php endif; ?>

<?php if (!$this->app->configHelper->get('apple-touch-icon72x72')) : ?>
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $this->url->dir() ?>assets/img/touch-icon-ipad.png">
<?php else: ?>
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $this->url->dir() ?>plugins/Kanext/Img/<?php echo $this->app->configHelper->get('apple-touch-icon72x72') ?>">
<?php endif; ?>

<?php if (!$this->app->configHelper->get('apple-touch-icon114x114')) : ?>
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $this->url->dir() ?>assets/img/touch-icon-iphone-retina.png">
<?php else: ?>
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $this->url->dir() ?>plugins/Kanext/Img/<?php echo $this->app->configHelper->get('apple-touch-icon114x114') ?>">
<?php endif; ?>

<?php if (!$this->app->configHelper->get('apple-touch-icon144x144')) : ?>
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $this->url->dir() ?>assets/img/touch-icon-ipad-retina.png">
<?php else: ?>
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $this->url->dir() ?>plugins/Kanext/Img/<?php echo $this->app->configHelper->get('apple-touch-icon144x144') ?>">
<?php endif; ?>

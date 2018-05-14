<div id="login-top">
	<?php if ($this->app->configHelper->get('login-logo-link')): ?>
		<a href="<?php echo $this->app->configHelper->get('login-logo-link'); ?>" target="_blank">
	<?php endif; ?>
			<img src="<?= $this->url->dir(); ?>plugins/Kanext/Img/<?php echo $this->app->configHelper->get('login-logo') ?>" />
	<?php if ($this->app->configHelper->get('login-logo-link')): ?>
		</a>
	<?php endif; ?>
</div>

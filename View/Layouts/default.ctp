<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $title_for_layout; ?></title>
    <meta name="robots" content="noindex">
	<?php echo $this->Html->meta( 'description', $metaDescription ); ?>
	<?php echo $this->Html->meta( 'keywords', $metaKeywords ); ?>
	<?php echo $this->Html->meta( 'charset', 'utf-8' ); ?>
	<?php echo $this->Html->meta( 'favicon.png', '/favicon.png', array( 'type' => 'icon' ) ); ?>
	<?php echo $this->Html->css( 'fonts/sensation' ); ?>
	<?php echo $this->Html->css( 'style' ); ?>
	<?php echo $this->Html->css( 'flash_messages' ); ?>
	<?php echo $this->Html->script( 'jquery' ); ?>
	<?php echo $this->Html->script( 'jquery-ui' ); ?>
	<?php echo $this->Html->script( 'apprise-1.5.min' ); ?>
	<?php echo $this->Html->script( 'script' ); ?>
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-5V87PH8');</script>
</head>
<body>
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5V87PH8"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<div id="wrapper">
    <div id="topbar">
		<?php
		echo $this->Html->image( 'typerlogo.png', array(
			'title' => Configure::read( 'Application.Name' ),
			'alt'   => Configure::read( 'Application.Name' ),
			'url'   => '/',
			'class' => 'logo'
		) );
		?>
        <div class="koko">
			<?php
			echo $this->Html->image( 'competition_logo.png', array(
				'title' => Configure::read( 'Application.WorldCupName' ),
				'alt'   => Configure::read( 'Application.WorldCupName' ),
			) );
			?>
        </div>
    </div>
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->element( 'Layout/menu' ); ?>
    <div id="content">
		<?php if ( ! empty( $loggedUser ) ): ?>
            <div id="admin_links">
                <ul>
                    <li>
						<?php
						echo $this->Html->link( __( 'My bets', true ), array(
							'controller' => 'users',
							'action'     => 'my_bets',
							'admin'      => false
						) );
						?>
                    </li>
                    <li>
						<?php
						echo $this->Html->link( __( 'Logout', true ), array(
							'controller' => 'users',
							'action'     => 'logout',
							'admin'      => false
						) );
						?>
                    </li>
                </ul>

            </div>
		<?php endif; ?>
		<?php echo $content_for_layout; ?>
        <div style="clear: both;"></div>
    </div>
    <div style="clear: both;">&nbsp;</div>
</div>
<?php echo $this->element( 'Layout/footer' ); ?>
<?php echo $this->element( 'Layout/analytics' ); ?>
<?php echo $this->element( 'sql_dump' ); ?>
</body>
</html>

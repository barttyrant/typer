<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php echo $title_for_layout; ?></title>
        <meta name="robots" content="noindex">
        <?php echo $this->Html->meta('description', $metaDescription); ?>
        <?php echo $this->Html->meta('keywords', $metaKeywords); ?>
        <?php echo $this->Html->meta('charset', 'utf-8'); ?>
        <?php echo $this->Html->meta('favicon.png', '/favicon.png', array('type' => 'icon')); ?>
        <?php echo $this->Html->css('fonts/sensation'); ?>
        <?php echo $this->Html->css('style'); ?>
        <?php echo $this->Html->css('flash_messages'); ?>
        <?php echo $this->Html->script('jquery'); ?>
        <?php echo $this->Html->script('jquery-ui'); ?>
        <?php echo $this->Html->script('apprise-1.5.min'); ?>
        <?php echo $this->Html->script('script'); ?>
    </head>
    <body>        
        <div id="wrapper">
            <div id="topbar">
                <?php
                echo $this->Html->image('typerlogo.png', array(
                    'title' => 'Typer biurowy', 'alt' => 'Typer biurowy',
                    'url' => '/', 'class' => 'logo'
                ));
                ?>
                <div class="koko">
                    <?php
                    echo $this->Html->image('brazil.png', array(
                        'title' => 'World Cup 2014 Brazil', 'alt' => 'World Cup 2014 Brazil',
                    ));
                    ?>                                        
                </div>
            </div>
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->element('Layout/menu'); ?>            
            <div id="content">
                <?php if (!empty($loggedUser)): ?>
                    <div id="admin_links">
                        <ul>
                            <li>
                                <?php
                                echo $this->Html->link(__('My bets', true), array(
                                    'controller' => 'users', 'action' => 'my_bets', 'admin' => false
                                ));
                                ?>
                            </li>                       
                            <li>
                                <?php
                                echo $this->Html->link(__('Logout', true), array(
                                    'controller' => 'users', 'action' => 'logout', 'admin' => false
                                ));
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
        <?php echo $this->element('Layout/footer'); ?>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>

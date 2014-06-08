<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->meta('description', $metaDescription); ?>
        <?php echo $this->Html->meta('keywords', $metaKeywords); ?>
        <?php echo $this->Html->meta('charset', 'utf-8'); ?>
        <?php echo $this->Html->meta('favicon.png', '/favicon.png', array('type' => 'icon')); ?>
        <?php echo $title_for_layout; ?>
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
                    echo $this->Html->image('chicken.png', array(
                        'title' => 'Koko Euro 2012', 'alt' => 'Koko Euro 2012',
                    ));
                    ?>                    
                    <?php
                    echo $this->Html->image('uefa_euro_2012_logo.png', array(
                        'title' => 'Koko Euro 2012', 'alt' => 'Koko Euro 2012',
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

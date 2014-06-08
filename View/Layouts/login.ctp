<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->meta('description', $metaDescription);?>
        <?php echo $this->Html->meta('keywords', $metaKeywords);?>
        <?php echo $this->Html->meta('charset', 'utf-8');?>
        <?php echo $this->title_for_layout;?>
        <?php echo $this->Html->css('fonts/sensation/sensation'); ?>
        <?php echo $this->Html->css('style'); ?>
        <?php echo $this->Html->script('jquery-1.7.1.min.js'); ?>
        <?php echo $this->Html->script('jquery.slidertron-1.0.js'); ?>
    </head>
    <body>
        <div id="wrapper">
            <?php echo $this->element('Layout/menu');?>            
            <div id="content">
                <?php echo $content_for_layout; ?>
            </div>
            <div style="clear: both;">&nbsp;</div>
        </div>
        <?php echo $this->element('Layout/footer');?>
    </body>
</html>

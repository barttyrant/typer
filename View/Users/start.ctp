<div id="main_news">
    <h2><?php echo __('IC Typer news', true);?>:</h2>
    <br/>
    
    <?php echo $this->element('Layout/news', compact('news'));?>    
</div>

<?php echo $this->element('stats');?>

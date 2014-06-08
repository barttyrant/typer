<div id="menu">
    <div style="float:right;">
        <ul>
            <?php foreach($pageLinks as $pageLink):?>
                <?php $class = (!empty($activePageLink) && $activePageLink == $pageLink['name']) ? ' class="current"' : '';?>
                <?php $params = !empty($pageLink['class']) ? array('class' => $pageLink['class']) : array();?>
                <li<?php echo $class;?>>
                    <?php echo $this->Html->link($pageLink['name'], $pageLink['url'], $params);?>
                </li>
            <?php endforeach;?>            
        </ul>
    </div>
</div>
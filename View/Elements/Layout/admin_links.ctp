<div id="admin_links">

    <ul>
        <li>
            <?php echo $this->Html->link(__('Dashboard', true), array(
            'controller' => 'users', 'action' => 'dashboard', 'admin' => true
            ));?>
        </li>
        <li>
            <?php echo $this->Html->link(__('Users', true), array(
            'controller' => 'users', 'action' => 'index', 'admin' => true
            ));?>
        </li>
        <li>
            <?php echo $this->Html->link(__('Events', true), array(
            'controller' => 'events', 'action' => 'index', 'admin' => true
            ));?>
        </li>        
    </ul>

</div>
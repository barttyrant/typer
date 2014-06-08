<div class="typerform loginform">    
    
<?php echo $this->Form->create('User', array('controller' => 'users', 'action' => 'login', 'admin' => false));?>	
    
    <h1>Login and take a bet :)</h1>
    
    <table>
                
        <tr>
            <th><?php echo $this->Form->label('login', __('login:', true));?></th>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('login', array('div' => false, 'label' => false, 'autocomplete' => 'off'));?></td>
        </tr>
        <tr>
            <th><?php echo $this->Form->label('password', __('password:', true));?></th>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('password', array('div' => false, 'label' => false, 'autocomplete' => 'off'));?></td>
        </tr>        
        <tr>
            <td class="submit">
                <?php echo $this->Form->submit(__('Go', true), array('div' => false));?>
            </td>
        </tr>
        
    </table>	
<?php echo $this->Form->end();?>
    <p>
        <?php echo __('No account yet?', true);?> 
        <?php echo $this->Html->link('Create one now !', array('controller' => 'users', 'action' => 'register'));?>
    </p>
</div>
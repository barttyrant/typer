<div class="typerform register">    
    
<?php echo $this->Form->create('User', array('url' => array(
    'controller' => 'users', 'action' => 'register'
)));?>	
    
    <h1><?php echo __('Create new account');?></h1>
    
    <table>
                
        <tr>
            <th><?php echo $this->Form->label('login', __('login:', true));?></th>
        </tr>
        <tr>
            <td>
                <?php echo $this->Form->input('login', array('div' => false, 'label' => false));?>
            </td>
        </tr>
        
        <tr>
            <th><?php echo $this->Form->label('first_name', __('first name:', true));?></th>
        </tr>
        <tr>
            <td>
                <?php echo $this->Form->input('first_name', array('div' => false, 'label' => false));?>
            </td>
        </tr>
        
        <tr>
            <th><?php echo $this->Form->label('last_name', __('last name:', true));?></th>
        </tr>
        <tr>
            <td>
                <?php echo $this->Form->input('last_name', array('div' => false, 'label' => false));?>
            </td>
        </tr>
        
        <tr>
            <th><?php echo $this->Form->label('password_', __('password:', true));?></th>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('password_', array('div' => false, 'label' => false, 'type' => 'password'));?></td>
        </tr>        
        
        <tr>
            <th><?php echo $this->Form->label('password_repeat', __('repeat password:', true));?></th>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('password_repeat', array('div' => false, 'label' => false, 'type' => 'password'));?></td>
        </tr>        
        
        <tr>
            <th><?php echo $this->Form->label('gender', __('gender:', true));?></th>
        </tr>
        <tr>
            <?php $genderValue = !empty($this->data['User']['gender']) ? $this->data['User']['gender'] : null;?>
            <td><?php echo $this->Form->input('gender', array('div' => false, 'label' => false, 'options' => $genders, 'value' => $genderValue));?></td>
        </tr>
        
        <tr>
            <th style="color:#f00;"><?php echo $this->Form->label('captcha', 'Calculate this: '.$captcha);?></th>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('captcha', array('label' => false));?></td>
        </tr>
        
        <tr>
            <td class="submit">
                <br/>
                <?php echo $this->Form->submit(__('Go', true), array('div' => false));?>
            </td>
        </tr>
        
        
        
    </table>	
<?php echo $this->Form->end();?>    
    
</div>
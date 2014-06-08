<h2>Event: <strong><?php echo $event['Event']['title'];?></strong></h2>

<br/><br/>
<h3>
        <?php echo __('Set result', true);?>: 
</h3>

<div class="typerform">    
    
<?php echo $this->Form->create('Event', array('url' => array(
    'controller' => 'events', 'action' => 'edit', 'admin' => true
)));?>	        
    <?php echo $this->Form->input('id');?>
    <table>

        <tr>
            <th><?php echo $this->Form->label('outcome_home', __('home goals:', true));?></th>
            <th><?php echo $this->Form->label('outcome_home', __('away goals:', true));?></th>
        </tr>
        <tr>
            <td style="width: 50%;">
                <?php echo $this->Form->input('outcome_home', array(
                    'div' => false, 'label' => false, 'style' => 'width: 90%; text-align:center;'
                ));?>
            </td>
            <td style="width: 50%;">
                <?php echo $this->Form->input('outcome_away', array(
                    'div' => false, 'label' => false, 'style' => 'width: 90%; text-align:center;'
                ));?>
            </td>
        </tr>
        <tr>
            <td class="submit" colspan="2">
                <div style="text-align:center;">
                    <?php echo $this->Form->submit(__('Go', true), array('div' => false));?>
                </div>
            </td>
        </tr>
        
        
        
    </table>	
<?php echo $this->Form->end();?>    
    
</div>


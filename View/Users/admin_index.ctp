<div class="admin_index">
	<h2><?php echo __('Users');?></h2>
	<table>
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('login');?></th>
			<th><?php echo $this->Paginator->sort('first_name');?></th>
			<th><?php echo $this->Paginator->sort('last_name');?></th>			
			<th><?php echo $this->Paginator->sort('role');?></th>
            <th><?php echo $this->Paginator->sort('status');?></th>
			<th><?php echo $this->Paginator->sort('last_active');?></th>
			<th><?php echo $this->Paginator->sort('gender');?></th>
            <th><?php echo $this->Paginator->sort('points');?></th>
			<th class="actions">&nbsp;</th>
	</tr>
	<?php
	$i = 0;
	foreach ($users as $user): 
        $oddEvenClass = ($i % 2) ? 'odd' : 'even';
        $i++;
    ?>    
	<tr class="<?php echo $oddEvenClass;?>">
		<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['login']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['first_name']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['last_name']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['role']); ?>&nbsp;</td>        
        <td>
            <?php echo h($user['User']['status']); ?>&nbsp;
            <?php if($user['User']['status'] == User::STATUS_NEW):?>
            (<?php echo $this->Form->postLink('accept', array('admin' => true, 'action' => 'accept', $user['User']['id']), null, __('Are you sure you want to accept # %s?', $user['User']['login']));?>)
            <?php endif;?>
        </td>
		<td><?php echo h($user['User']['last_active']); ?>&nbsp;</td>
        <td><?php echo $this->Html->image('icons/' . strtolower(h($genders[$user['User']['gender']])) . '.png', array(
            'title' => strtolower(h($genders[$user['User']['gender']])), 'alt' => strtolower(h($genders[$user['User']['gender']]))
        )); ?>&nbsp;</td>
        <td><?php echo $this->Number->precision($user['User']['points'], 2); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id']), array('class' => 'viewLink')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id']), array('class' => 'editLink')); ?>			
		</td>
	</tr>
<?php endforeach; ?>
	</table>	

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ' | '));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

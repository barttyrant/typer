<div class="users view admin_view">
    <h2>
        <?php echo h($user['User']['login']); ?>
        <?php
        echo $this->Html->image('icons/' . strtolower(h($genders[$user['User']['gender']])) . '.png', array(
            'title' => strtolower(h($genders[$user['User']['gender']])), 'alt' => strtolower(h($genders[$user['User']['gender']]))
        ));
        ?>
    </h2>
    <dl>
        <dt><?php echo __('Full name', true); ?>
        <dd><?php echo h($user['User']['first_name']); ?> <?php echo h($user['User']['last_name']); ?></dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php echo h($user['User']['created']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php echo h($user['User']['modified']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Last Active'); ?></dt>
        <dd>
            <?php echo h($user['User']['last_active']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Role'); ?></dt>
        <dd>
            <?php echo h($user['User']['role']); ?>
            &nbsp;
        </dd>		
        <dt><?php echo __('Status'); ?></dt>
        <dd>
            <?php echo h($user['User']['status']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Points'); ?></dt>
        <dd>
            <?php echo h($user['User']['points']); ?>
            &nbsp;
        </dd>
    </dl>
    <div class="actions">
        <h3><?php echo __('Actions'); ?></h3>
        <ul>
            <li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>				
        </ul>
    </div>
</div>

<div class="related">
    <?php /*
      <h3><?php echo __('Related Groups');?></h3>
      <?php if (!empty($user['Bet'])):?>
      <table cellpadding = "0" cellspacing = "0">
      <tr>
      <th><?php echo __('Id'); ?></th>
      <th><?php echo __('Name'); ?></th>
      <th><?php echo __('Slug'); ?></th>
      <th><?php echo __('Created'); ?></th>
      <th><?php echo __('Modified'); ?></th>
      <th class="actions"><?php echo __('Actions');?></th>
      </tr>
      <?php
      $i = 0;
      foreach ($user['Group'] as $group): ?>
      <tr>
      <td><?php echo $group['id'];?></td>
      <td><?php echo $group['name'];?></td>
      <td><?php echo $group['slug'];?></td>
      <td><?php echo $group['created'];?></td>
      <td><?php echo $group['modified'];?></td>
      <td class="actions">
      <?php echo $this->Html->link(__('View'), array('controller' => 'groups', 'action' => 'view', $group['id'])); ?>
      <?php echo $this->Html->link(__('Edit'), array('controller' => 'groups', 'action' => 'edit', $group['id'])); ?>
      <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'groups', 'action' => 'delete', $group['id']), null, __('Are you sure you want to delete # %s?', $group['id'])); ?>
      </td>
      </tr>
      <?php endforeach; ?>
      </table>
      <?php endif; ?>

      <div class="actions">
      <ul>
      <li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add'));?> </li>
      </ul>
      </div>
     * */ ?>
</div>

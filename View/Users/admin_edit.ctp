<div class="users form typerform">
    <?php echo $this->Form->create('User'); ?>
    <h1><?php echo __('Edit user: ') . $user['User']['login']; ?></h1>
    <?php echo $this->Form->input('id'); ?>
    <table>

        <tr>
            <th><?php echo $this->Form->label('login', __('login:', true)); ?></th>
        </tr>
        <tr>
            <td>
                <?php echo $this->Form->input('login', array('div' => false, 'label' => false)); ?>
            </td>
        </tr>

        <tr>
            <th><?php echo $this->Form->label('first_name', __('first name:', true)); ?></th>
        </tr>
        <tr>
            <td>
                <?php echo $this->Form->input('first_name', array('div' => false, 'label' => false)); ?>
            </td>
        </tr>

        <tr>
            <th><?php echo $this->Form->label('last_name', __('last name:', true)); ?></th>
        </tr>
        <tr>
            <td>
                <?php echo $this->Form->input('last_name', array('div' => false, 'label' => false)); ?>
            </td>
        </tr>

        <tr>
            <th><?php echo $this->Form->label('gender', __('gender:', true)); ?></th>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('gender', array('div' => false, 'label' => false, 'options' => $genders)); ?></td>
        </tr>

        <tr>
            <th><?php echo $this->Form->label('status', __('status:', true)); ?></th>
        </tr>
        <tr>
            <td><?php echo $this->Form->input('status', array('div' => false, 'label' => false, 'options' => $statuses)); ?></td>
        </tr>

        <tr>
            <td class="submit">
                <br/>
                <?php echo $this->Form->submit(__('Go', true), array('div' => false)); ?>
            </td>
        </tr>

    </table>	

    <?php echo $this->Form->end(); ?>


</div>
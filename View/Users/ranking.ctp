<h2><?php echo __('Ranking', true);?>:</h2>

    <table class="index bet_table ranking">
        <tr>
            <th><?php echo __('Player', true);?></th>
            <th><?php echo __('Player', true);?></th>
            <th><?php echo __('Total bets', true);?></th>
            <th><?php echo __('Correct / Incorrect / Pending', true);?></th>
            <th><?php echo __('Points', true);?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($users as $user):
            $class = ($i % 2) ? 'odd' : 'even';            
            $i++;
            $top = $i <= 3 ? ' top' : '';
            $class .= $top;
            $last = $i == count($users) ? ' last' : '';
            $class .= $last;
            ?>    
            <tr class="<?php echo $class; ?>">                
                <td class="lp">
                    <?php echo $i;?>
                </td>
                <td>
                    <?php echo h($user['User']['login']);?>
                    (<?php echo h($user['User']['first_name']);?> <?php echo h($user['User']['last_name']);?>)
                    <?php echo $this->Html->image('icons/stats_icon.png', array(
                        'alt' => __('Bets taken by %s', $user['User']['login']), 'title' => __('Bets taken by %s', $user['User']['login']), 'class' => 'stats_icon',
                        'url' => array('controller' => 'users', 'action' => 'by_user', $user['User']['login'])
                    )); ?>
                </td>
                <td>
                    <?php echo h($user['User']['total_bets']);?>
                </td>
                <td>                    
                    <?php echo h($user['User']['correct_bets']);?> / 
                    <?php echo h($user['User']['incorrect_bets']);?> / 
                    <?php echo h($user['User']['pending_bets']);?>
                </td>     
                <td>                    
                    <?php echo h($user['User']['balance']);?>
                </td>                
            </tr>
        <?php endforeach; ?>
    </table>	
<br/>
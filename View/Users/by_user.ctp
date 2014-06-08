<h3><?php echo __('Bets taken by %s:', $user['User']['login'] . ' (' . $user['User']['first_name'] . ' ' . $user['User']['last_name'] . ')'); ?></h3>
    <table class="index bet_table my_bet_table">
        <tr>
            <th><?php echo __('Event', true);?></th>
            <th><?php echo __('Bet', true);?></th>
            <th><?php echo __('Odd', true);?></th>
            <th><?php echo __('Result', true);?></th>
            <th><?php echo __('Outcome', true);?></th>
            <th><?php echo __('Balance change', true);?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($userBets as $bet):
            $oddEvenClass = ($i % 2) ? 'odd' : 'even';
            $i++;
            ?>    
            <tr class="<?php echo $oddEvenClass; ?>">                	                
                <td>
                    <?php echo h($bet['Event']['title']);?>                    
                </td>
                <td>
                    <?php echo h($bet['Odd']['name']);?>                    
                </td>
                <td>                    
                    <?php echo h($bet['Bet']['odd']);?>
                </td>     
                <td>            
                    <?php $labelCallback = 'getRandom' . ucfirst(strtolower($bet['Bet']['result'])) . 'Label';?>
                    <?php $iconLabel = Bet::$labelCallback();?>
                        <?php echo $this->Html->image('icons/bet_' . strtolower($bet['Bet']['result']) . '.png', array(
                            'alt' => $iconLabel, 'title' => $iconLabel, 'class' => 'bet_result_icon'
                        )); ?>
                </td>
                <td class="result_<?php echo strtolower($bet['Bet']['result']);?>">                    
                    <?php echo h($bet['Event']['outcome']);?>
                </td>     
                <td class="result_<?php echo strtolower($bet['Bet']['result']);?>">
                    <?php if($bet['Bet']['result'] == Bet::RESULT_CORRECT):?>
                    <span>+ <?php echo ((User::DEFAULT_POINTS_AMMOUNT * $bet['Bet']['odd']) - User::DEFAULT_POINTS_AMMOUNT);?></span>
                    <?php elseif($bet['Bet']['result'] == Bet::RESULT_INCORRECT):?>
                        <?php echo '- ' . User::DEFAULT_POINTS_AMMOUNT;?>
                    <?php endif;?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>	
<br/>
<br/>
<hr/>
<h3><?php echo __('Balance', true);?>:</h3>

<div class="balance_total <?php echo $balance>0 ? 'positive' : 'negative';?>"><strong><?php echo $balance;?></strong> <?php echo __('points', true);?></div> 
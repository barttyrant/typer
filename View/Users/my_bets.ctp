<h3><?php echo __('My bets:'); ?></h3>
    <table class="index bet_table my_bet_table">
        <tr>
            <th><?php echo __('Taken date', true);?></th>
            <th><?php echo __('Event', true);?></th>
            <th><?php echo __('Bet', true);?></th>
            <th><?php echo __('Odd', true);?></th>
            <th><?php echo __('Status', true);?></th>
            <th><?php echo __('Outcome', true);?></th>
            <th><?php echo __('Balance change', true);?></th>
        </tr>
        <?php
        $i = 0;
        foreach ($myBets as $bet):
            $oddEvenClass = ($i % 2) ? 'odd' : 'even';
            $i++;
            ?>    
            <tr class="<?php echo $oddEvenClass; ?>">
                <td>
                    <span class="event_date">
                        <?php echo h($bet['Bet']['created']); ?>&nbsp;
                    </span>
                </td>		                
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
                    <?php echo h($bet['Bet']['status']);?>
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
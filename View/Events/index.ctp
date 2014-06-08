<h3><?php echo __('Upcoming Events:'); ?></h3>
    <table class="index bet_table">
        
        <?php
        $i = 0;
        foreach ($events as $event):           
            $oddEvenClass = ($i % 2) ? 'odd' : 'even';            
            $i++;
            ?>    
            <tr class="<?php echo $oddEvenClass; ?>">
                <td>
                    <div class="event_title">
                        <?php 
                            list($home, $away) = explode(' - ', $event['Event']['title']);
                            $home = strtolower(str_replace('ł', 'l', $home));
                            $away = strtolower(str_replace('ł', 'l', $away));
                        ?>
                        <div class="home">
                            <?php echo $this->Html->image('icons/flags/'.$home.'.png');?><br/>
                            <?php echo ucfirst($home);?><br/><br/>
                        </div>
                        <div class="versus">
                            v
                        </div>
                        <div class="away">
                            <?php echo $this->Html->image('icons/flags/'.$away.'.png');?><br/>
                            <?php echo ucfirst($away);?><br/><br/>
                        </div>
                    </div>                    
                </td>
                <td><span class="event_date"><?php echo h($event['Event']['start_date']); ?>&nbsp;</span></td>		                
                <td>
                    <?php $taken = (array_key_exists($event['Event']['id'], $alreadyTakenEvents));?>
                        
                    <?php if(!$taken):?>
                    
                    <?php echo $this->Form->create('Bet', array('url' => array(
                        'controller' => 'bets', 'action' => 'create', 
                    ), 'class' => 'betform', 'id' => 'form_' . $event['Event']['id']));?>
                    <?php if (!empty($event['Odd'])): ?>
                        <table class="admin_table_odds">
                            <tr>
                                <?php foreach ($event['Odd'] as $odd): ?>
                                    <th>
                                        <?php echo $odd['name']; ?>
                                    </th>
                                <?php endforeach; ?>    
                            </tr>
                            <tr>
                                <?php $i=0;?>
                                <?php foreach ($event['Odd'] as $odd): ?>
                                    <td>
                                        <?php echo $odd['value']; ?><br/>
                                        <?php echo $this->Form->input('odd_id_' . $odd['id'], array(
                                            'type' => 'checkbox', 'value' => $odd['id'], 'label' => '', 'id' => 
                                            'BettOddId_' . $odd['id'], 'class' => 'bet_odd_checkbox', 
                                        ));?>                                        
                                    </td>
                                    <?php $i++;?>
                                <?php endforeach; ?>    
                            </tr>                            
                        </table>                    
                    <?php endif; ?>
                    <?php else:?>
                    <div style="text-align:center; font-size:20px;">
                        <?php echo __('Your bet', true);?>: <strong><?php echo $alreadyTakenEvents[$event['Event']['id']]['Odd']['name'];?></strong>
                    </div>
                    <?php endif;?>
                </td>     
                <td class="submitDeal">
                    <?php if(!$taken):?>
                    <?php echo $this->Form->submit(' ', array('class' => 'deal', 'div' => array(
                        'style' => 'text-align: center; margin:0;'
                    ))); ?>                    
                    <?php echo $this->Form->end(); ?>
                    <?php endif;?>
                </td>

            </tr>
        <?php endforeach; ?>
    </table>	

<br/><br/>

<script>
    $(function(){
        $('input.deal').click(function(){
            $row = $(this).parents('tr');
            chosenOptionsAmmount = $row.find('input[type=checkbox]:checked').length;
            
            if(chosenOptionsAmmount != 1){
                alert('<?php echo __('Please pick the right ammount of options (actualy... 1 allowed :) )', true);?>');
                return false;
            }
            else{
                var ret = confirm("<?php echo __('Are You sure about this bet? This cannot be undone :)', true);?>");
                return ret;
            };        
        });
    });
</script>
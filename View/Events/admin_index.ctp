<div class="admin_index">
    <h2>
        <?php echo __('Events'); ?> <?php echo $this->Html->image('icons/refresh.png', array(
            'title' => __('refresh from BetClick', true), 'alt' => __('refresh from BetClick', true),
            'url' => array('controller' => 'events', 'action' => 'fetch_events', 'admin' => true)
        ));?>
    </h2>
    <table>
        <tr>
            <th><?php echo $this->Paginator->sort('id'); ?></th>
            <th><?php echo $this->Paginator->sort('title'); ?></th>
            <th><?php echo $this->Paginator->sort('start_date'); ?></th>
            <th><?php echo __('odds', true);?></th>
            <th class="actions">&nbsp;</th>
        </tr>
        <?php
        $i = 0;
        foreach ($events as $event):
            $oddEvenClass = ($i % 2) ? 'odd' : 'even';
            $i++;
            ?>    
            <tr class="<?php echo $oddEvenClass; ?>">
                <td><span class="event_id"><?php echo h($event['Event']['id']); ?>&nbsp;</span></td>
                <td><span class="event_title"><?php echo h($event['Event']['title']); ?>&nbsp;</span></td>
                <td><span class="event_date"><?php echo h($event['Event']['start_date']); ?>&nbsp;</span></td>		                
                <td>
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
                                <?php foreach ($event['Odd'] as $odd): ?>
                                    <td>
                                        <?php echo $odd['value']; ?>
                                    </td>
                                <?php endforeach; ?>    
                            </tr>
                        </table>
                    <?php endif; ?>
                </td>
                <td class="actions">                    
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $event['Event']['id']), array('class' => 'viewLink')); ?>			
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
    <br/><br/>
</div>

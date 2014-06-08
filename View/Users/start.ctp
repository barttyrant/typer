<div id="main_news">
    <h2><?php echo __('Typer news', true);?>:</h2>
    <br/>
    
    <?php echo $this->element('Layout/news', compact('news'));?>    
</div>

<div id="stats">
    <h3><?php echo __('Stats', true);?>:</h3>
    
    <div class="dashboard_view static">
        <dl>
            <dt><?php echo __('Total users:', true);?></dt>
            <dd><?php echo $totalUsers;?></dd>
            
            <dt><?php echo __('Total Bets pending:', true);?></dt>
            <dd><?php echo $totalBetsPending;?></dd>
            
            <dt><?php echo __('Total Bets finished:', true);?></dt>
            <dd><?php echo $totalBetsFinished;?></dd>
                        
            <dt><?php echo __('Bets correct/incorrect:', true);?></dt>
            <dd><?php echo $totalBetsCorrect;?> / <?php echo $totalBetsIncorrect;?></dd>
            
        </dl>
    </div>
</div>


<div id="info">
    <h3><?php echo __('Info', true);?>:</h3>
    
    <div class="dashboard_view static">
        <dt><?php echo __('Stake:', true);?></dt>
        <dd style="color: #32800f;"><strong><?php echo $stake + 380;?>zl.</strong></dd>
        
        <dt><?php echo __('Tournament progress:', true);?></dt>
        <dd><?php echo $tournamentProgress;?></dd>
            
    </div>
    
</div>

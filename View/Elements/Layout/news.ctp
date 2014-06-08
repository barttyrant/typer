<?php $news = isset($news) ? $news : array(); ?>

<div style="width:90%;">

    <?php if (!empty($news)): ?>
        <?php foreach ($news as $n): ?>
            <table class="news" style="width: 100%;">        
                <tr>
                    <th class="title"><?php echo $n['News']['title']; ?></th>
                    <th class="date"><?php echo $n['News']['created']; ?></th>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php echo $n['News']['content']; ?>
                    </td>
                </tr>
                <tr>
                    <th class="author" colspan="2"><?php echo $n['News']['author']; ?></th>
                </tr>
            </table>
            <hr class="news_space">
        <?php endforeach; ?>        
    <?php endif; ?>
    <div class="news-paging">
        <?php echo $this->Paginator->numbers(); ?>
    </div>
</div>
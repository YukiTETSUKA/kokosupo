<?php // スポット検索フォーム
    echo $this->Form->create('kokosupo', array('action' => 'index'));
        echo $this->Form->input('keyword', array('label' => '検索キーワード'));
        echo $this->Form->input('order',
            array(
                'type' => 'select',
                'options' => array(
                    'create_desc' => '投稿が新しい順',
                    'create_asc'  => '投稿が古い順',
                ),
                'label' => 'ソート基準'
            )
        );
    echo $this->Form->end('検索');
?>

<?php if(isset($keyword)): ?>
    検索ワード: <?php echo $keyword; ?><br />
    検索結果: <?php echo count($spots); ?> 件<br /><br />
<?php else: ?>
    <br /><br /><br />
<?php endif; ?>

<?php //debug($spots); // デバッグ ?>

<?php foreach($spots as $spot): ?>
    <?php //debug($spot); ?>
    スポット名: <?php echo $this->Html->link($spot['Spot']['spot_name'], array('action' => 'detail/' . $spot['Spot']['id'])); ?><br />
    投稿者: <?php echo $spot['User']['name']; ?><br />
    説明: <?php echo $spot['Spot']['explanation']; ?><br /><br />
<?php endforeach; ?>

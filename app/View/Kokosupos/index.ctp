<div class="register_spot">
    <?php echo $this->Html->link('スポットを登録する', array('action' => 'register_spot'), array('class' => 'btn btn-primary')); ?>
</div>

<div class="search">
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
</div>

<div class="float_clear">
</div>

<?php if(isset($keyword)): ?>
    検索ワード: <?php echo htmlspecialchars($keyword); ?><br />
    検索結果: <?php echo count($spots); ?> 件<br /><br />
<?php else: ?>
    <br /><br /><br />
<?php endif; ?>

<?php //debug($spots); // デバッグ ?>

<?php foreach($spots as $spot): ?>
    <?php //debug($spot); ?>
    <div class="spot_thumbnail">
        <?php $file_name = count($spot['Image']) == 0? 'no_image.gif': $spot['Image'][rand(0, count($spot['Image']) - 1)]['path']; ?>
        <?php $alt       = count($spot['Image']) == 0? 'no_image'    : 'image'; ?>

        <?php echo $this->Html->link($this->Html->image($file_name, array('alt' => $alt, 'class' => 'thumbnail')), array('action' => 'detail/' . $spot['Spot']['id']), array('escape' => false)); ?>
    </div>

    <div class="spots_info">
        スポット名: <?php echo $this->Html->link($spot['Spot']['spot_name'], array('action' => 'detail/' . $spot['Spot']['id'])); ?><br />
        投稿者: <?php echo $spot['User']['name']; ?><br />
        説明: <?php echo $spot['Spot']['explanation']; ?><br /><br />
    </div>

    <div class="float_clear">
    </div>
<?php endforeach; ?>

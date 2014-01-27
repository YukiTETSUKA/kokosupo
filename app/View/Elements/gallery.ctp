<?php
    echo $this->Form->create('kokosupo', array('type' => 'file', 'action' => 'detail/' . $spot['Spot']['id'] . '/gallery'));
        echo $this->Form->input('image', array('type' => 'file'));
    echo $this->Form->end('投稿');
?>

<?php foreach($spot['Image'] as $image): ?>
    <?php echo $this->Html->image($image['path'], array('alt' => 'image', 'class' => 'images')); ?>
<?php endforeach ?>

<?php //debug($spot); ?>

<h2><?php echo $spot['Spot']['spot_name']; ?></h2>


<?php if($spot['User']['id'] == $user['User']['id']): ?>
    <?php echo $this->Html->link('編集', array('action' => 'edit/' . $spot['Spot']['id']  ), array('class' => 'btn btn-success')); ?>
    <?php echo $this->Html->link('削除', array('action' => 'delete/' . $spot['Spot']['id']), array('class' => 'btn btn-danger')); ?>
<?php endif; ?>

<div class="spot">
    <div class="spot_image">
        <?php $file_name = count($spot['Image']) == 0? 'no_image.gif': $spot['Image'][rand(0, count($spot['Image']) - 1)]['path']; ?>
        <?php $alt       = count($spot['Image']) == 0? 'no_image'    : 'image'; ?>

        <?php echo $this->Html->image($file_name, array('alt' => $alt, 'class' => 'image')); ?>
    </div>
    <div class="spot_info">
        説明: <?php echo $spot['Spot']['explanation']; ?><br />
        投稿者: <?php echo $spot['User']['name']; ?><br />
    </div>
</div>
<br />

<div class="float_clear">
</div>

<div class="spot_various">
    <ul class="nav nav-pills">
        <p class="spot_comment">
            <?php if($various == 'comment'): ?>
                <li class="comment active"><?php echo $this->Html->link('コメント'  , array('action' => 'detail/' . $spot['Spot']['id'] . '/comment')); ?></li>
            <?php else: ?>
                <li class="comment"><?php echo $this->Html->link('コメント'  , array('action' => 'detail/' . $spot['Spot']['id'] . '/comment')); ?></li>
            <?php endif ?>
        </p>

        <p class="supobijo">
            <?php if($various == 'supobijo'): ?>
                <li class="supobijo active" ><?php echo $this->Html->link('すぽびじょ'  , array('action' => 'detail/' . $spot['Spot']['id'] . '/supobijo' )); ?></li>
            <?php else: ?>
                <li class="supobijo" ><?php echo $this->Html->link('すぽびじょ'  , array('action' => 'detail/' . $spot['Spot']['id'] . '/supobijo' )); ?></li>
            <?php endif ?>
        </p>

        <p class="spot_gallery">
            <?php if($various == 'gallery'): ?>
                <li class="gallery active"><?php echo $this->Html->link('ギャラリー', array('action' => 'detail/' . $spot['Spot']['id'] . '/gallery')); ?></li>
            <?php else: ?>
                <li class="gallery"><?php echo $this->Html->link('ギャラリー', array('action' => 'detail/' . $spot['Spot']['id'] . '/gallery')); ?></li>
            <?php endif ?>
        </p>
    </ul>

    <div class="contents">
        <?php
            switch($various){
                case 'comment':
                    echo $this->element('comment');
                    break;
                case 'supobijo':
                    echo $this->element('supobijo');
                    break;
                case 'gallery':
                    echo $this->element('gallery');
                    break;
            }
        ?>
    </div>

    <div class="float_clear">
    </div>
    <?php echo $this->Html->link('戻る', array('action' => 'index'), array('class' => 'btn btn-primary')); ?>
</div>

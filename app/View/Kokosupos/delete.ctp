本当に削除しますか?<br />
<?php echo $this->Html->link('やっぱり戻る', array('action' => 'detail/' . $spot_id), array('class' => 'btn btn-default')); ?>
<?php
    echo $this->Form->create('kokosupo', array('action' => 'delete/' . $spot_id));
        echo $this->Form->hidden('delete', array('value' => true));
    echo $this->Form->end('はい，削除します');

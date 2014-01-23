<?php
    echo $this->Form->create('kokosupo', array('action', 'register_spot'));
        echo $this->Form->input('spot_name'  , array('label' => 'スポット名'));
        echo $this->Form->input('explanation', array('label' => '説明文', 'type' => 'textarea'));
        //echo $this->Form->input('in_or_out'  , array('type'  => 'radio', 'options' => array('0' => '屋内', '1' => '屋外')));

        echo $this->Form->hidden('user_id', array('value' => $user['User']['id']));
    echo $this->Form->end('登録');
?>
<br />
<br />
<?php echo $this->html->link('戻る', array('action' => 'index'), array('class' => 'btn btn-primary')); ?>

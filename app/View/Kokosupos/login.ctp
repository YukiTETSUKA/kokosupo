<?php
    echo $this->Form->create('Kokosupo', array('action' => 'login'));
        echo $this->Form->input('name'    , array('label' => 'ユーザ名'));
        echo $this->Form->input('password', array('label' => 'パスワード'));
    echo $this->Form->end('ログイン');
?>
<div class="twitter_login"><?php echo $this->Html->link($this->Html->image('background/twitter_01.png') , array('action' => 'twitter_login' ), array('escape' => false)); ?><br /></div>
<div class="facebook_login"><?php echo $this->Html->link($this->Html->image('background/facebook_01.jpg'), array('action' => 'facebook_login'), array('escape' => false)); ?><br /></div>

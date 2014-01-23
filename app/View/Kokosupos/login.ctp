<?php echo $this->Session->flash('auth'); ?><br />
<?php
    echo $this->Form->create('Kokosupo', array('action' => 'login'));
        echo $this->Form->input('name'    , array('label' => 'ユーザ名'));
        echo $this->Form->input('password', array('label' => 'パスワード'));
    echo $this->Form->end('ログイン');
?>
<?php echo $this->Html->link('Twitter でログイン', array('action' => 'twitter_login' )); ?><br />
<?php echo $this->html->link('Facebookでログイン',array('controller'=>'Fbconnects','action'=>'facebook')); ?><br />
<?php echo $this->Html->link('新規登録', array('action' => 'sign_up' )); ?><br />
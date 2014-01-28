<?php
    echo $this->Form->create('Kokosupo', array('action' => 'login'));
        echo $this->Form->input('name'    , array('label' => 'ユーザ名'));
        echo $this->Form->input('password', array('label' => 'パスワード'));
    echo $this->Form->end('ログイン');
?>
<<<<<<< HEAD
<div class="twitter_login"><?php echo $this->Html->link(/*$this->Html->image('background/twitter_01.png')*/'twitterでログイン' , array('action' => 'twitter_login' ), array('escape' => false)); ?><br /></div>
<div class="facebook_login"><?php echo $this->Html->link(/*$this->Html->image('background/facebook_01.jpg')*/'facebookでログイン', array('action' => 'facebook_login'), array('escape' => false)); ?><br /></div>
=======
<?php echo $this->Html->link('新規登録', array('action' => 'sign_up')); ?>
<div class="twitter_login"><?php echo $this->Html->link(/*$this->Html->image('background/twitter_01.png')*/'twitterでログイン' , array('action' => 'twitter_login' ), array('escape' => false)); ?><br /></div>
<div class="facebook_login"><?php echo $this->Html->link(/*$this->Html->image('background/facebook_01.jpg')*/'facebookでログイン', array('controller' => 'Fbconnects', 'action' => 'facebook'), array('escape' => false)); ?><br /></div>
<br /><br />
岩手のイベントから自分のスポットを見つけてはどうですか？<br />
<?php
foreach($api['Items'] as $event){
    echo $this->Html->link($event['Title'], $event['Url']) . '<br />';
}
?>
>>>>>>> fae3a585d79acfdd4bacde184cd2ed0fee9bbfd5

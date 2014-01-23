<div id="hero-unit">
    <?php echo "<h2>新規ユーザー登録</h2>";?>
    <?php echo $this->Session->flash('Auth'); ?>
    <?php echo $this->Form->create('kokosupo', array('action' => 'sign_up')); ?>
    <?php echo $this->Form->input('name',array('label'=>'ユーザ名')); ?>
    <?php //$option = array(0 => '男', 1 => '女'); ?>
	<?php //$option2 = array('legend' => false, 'value' => 1);?>
	<?php //echo $this->Form->label('User.sex','性別'); ?>
	<?php //echo $this->Form->radio('User.sex',$option,$option2); ?>
	<?php //echo $this->Form->error('User.sex'); ?>
    <?php //echo $this->Form->input('User.email',array('label'=>'メールアドレス'));?>
    <?php echo $this->Form->input('password',array('label'=>'パスワード','value'=>'')); ?>
    <?php echo $this->Form->input('pass_check',array('label'=>'パスワード確認','type'=>"password",'value'=>'')); ?>
    <?php echo $this->Form->end('新規ユーザを作成する'); ?>
    <a href="login" id="switch2" class="label btn-primary">ログインへ</a>
</div>
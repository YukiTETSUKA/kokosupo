<?php if(isset($user['User'])): ?>
    <div class="user_info">
        <?php echo $user['User']['name'] . '　　　　　'; ?>
        <?php echo $this->Html->link('ログアウト', array('action' => 'logout'), array('class' => 'btn btn-danger')); ?>
    </div>
<?php endif; ?>

<div class="float_clear">
</div>

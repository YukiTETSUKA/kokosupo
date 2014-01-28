<?php
echo $this->Form->create('kokosupo', array('action' => 'sign_up'));
    echo $this->Form->input('name', array('label' => '名前', 'value' => ''));
    echo $this->Form->input('password', array('label' => 'パスワード', 'value' => ''));
    echo $this->Form->input('pass_check', array('label' => 'パスワード確認', 'value' => '', 'type' => 'password'));
echo $this->Form->end('新規作成');

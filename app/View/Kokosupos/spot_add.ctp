<?php
echo $this->Html->link("戻る","index/")."<br>";
echo $this->Form->create("kokosupo",array("action"=>"index"));
echo $this->Form->textbox('spot_name');
echo $this->Form->file('aa');
echo $this->Form->textbox('com',array('style'=>'height:100px;'));
echo $this->Form->submit("スポット投稿");
echo $this->Form->end();
?>
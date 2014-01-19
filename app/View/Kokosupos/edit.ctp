<?php
    //debug($spot);

    echo $this->Form->create('kokosupo', array('action' => 'edit/' . $spot['Spot']['id']));
        echo $this->Form->input('spot_name',   array('label' => 'スポット名', 'value' => $spot['Spot']['spot_name']));
        echo $this->Form->input('explanation', array('label' => '説明文'    , 'value' => $spot['Spot']['explanation'], 'type' => 'textarea'));

        echo $this->Form->hidden('id', array('value' => $spot['Spot']['id']));
    echo $this->Form->end('更新');

    $this->Html->link('戻る', array('action' => 'detail/' . $spot['Spot']['id']), array('class' => 'btn btn-primary'));

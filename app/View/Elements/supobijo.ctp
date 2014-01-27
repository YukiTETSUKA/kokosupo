<div class="supobijos col-md-4">
    <?php foreach($spot['Supobijo'] as $supobijo): ?>
        <div class="supobijo">
            名前：<?php echo htmlspecialchars($supobijo['name']); ?>
            年齢：<?php echo $supobijo['age']; ?>代<br />
            髪型：<?php echo htmlspecialchars($supobijo['hair']);            ?><br />
            体型：<?php echo htmlspecialchars($supobijo['body']);            ?><br />
            声音：<?php echo htmlspecialchars($supobijo['voice']);           ?><br />
            <?php $bust = array('貧乳', '微乳', '豊乳', '巨乳', '爆乳');     ?>
            胸囲：<?php echo htmlspecialchars($bust[$supobijo['bust'] - 1]); ?><br />
            備考：<?php echo htmlspecialchars($supobijo['note']);     ?><br />
        </div><br /><br />
    <?php endforeach; ?>
</div>

<div class="post_supobijo col-md-4">
    <?php
    echo $this->Form->create('kokosupo', array('action' => 'detail/' . $spot['Spot']['id'] . '/supobijo'));
        echo $this->Form->hidden('spot_id', array('value' => $spot['Spot']['id']));
        echo $this->Form->input('name', array('label' => '名前', 'value' => ''));
        echo $this->Form->input('age' , array(
            'type'    => 'select',
            'label'   => '年齢',
            'options' => array(
                '10' => '10代',
                '20' => '20代',
                '30' => '30代',
            ),
            'value'   => '10',
        ));
        echo $this->Form->input('hair' , array('type' => 'text', 'label' => '髪'  , 'value' => ''));
        echo $this->Form->input('body' , array('type' => 'text', 'label' => '体型', 'value' => ''));
        echo $this->Form->input('voice', array('type' => 'text', 'label' => '声'  , 'value' => ''));
        echo $this->Form->input('bust' , array(
            'type'    => 'select',
            'label'   => 'バスト',
            'options' => array(
                '1' => '貧乳',
                '2' => '微乳',
                '3' => '豊乳',
                '4' => '巨乳',
                '5' => '爆乳',
            ),
            'value'   => '3',
        ));
        echo $this->Form->input('note', array('type' => 'textarea', 'label' => '備考・その他', 'value' => ''));
    echo $this->Form->end('投稿');
    ?>
</div>

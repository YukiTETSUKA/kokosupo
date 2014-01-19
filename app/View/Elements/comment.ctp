<div class="comment col-md-4">
    <?php foreach($spot['Comment'] as $comment): ?>
        <?php echo htmlspecialchars($comment['comment']); ?><br /><br />
    <?php endforeach; ?>
</div>

<div class="post_comment col-md-4">
    <?php
        echo $this->Form->create('kokosupo', array('action' => 'detail/' . $spot['Spot']['id']));
            echo $this->Form->input('comment', array('type' => 'textarea', 'label' => 'コメント', 'value' => ''));

            echo $this->Form->hidden('user_id', array('value' => $user['User']['id']));
            echo $this->Form->hidden('spot_id', array('value' => $spot['Spot']['id']));
        echo $this->Form->end('投稿');
    ?>
</div>

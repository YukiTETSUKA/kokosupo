<?php
    class Comment extends Model{
        public $name = 'Comment';
        public $belongsTo = array(
            'User' => array(
                'className' => 'User',
                'conditions' => array('User.id' => 'Comment.user_id'),
            ),
            'Spot' => array(
                'className'  => 'Spot',
                'conditions' => array('Spot.id' => 'Comment.spot_id'),
            ),
        );

        public function post($data){
            $this->save($data);
        }
    }

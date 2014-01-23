<?php
    class Spot extends Model{
        public $name = 'Spot';
        public $belongsTo = array(
            'User' => array(
                'className'  => 'User',
                'conditinos' => array('User.id' => 'user_id')
            )
        );
        public $hasMany = array(
            'Image' => array(
                'className'  => 'Image',
                'conditions' => array('Image.spot_id' => 'id'),
                'order'      => array('Image.id'      => 'desc'),
            ),
            'Comment' => array(
                'className'  => 'Comment',
                'conditions' => array('Comment.spot_id' => 'id'),
                'order'      => array('Comment.id'      => 'desc'),
            )
        );

        public function search($data){
            $keyword = $data['keyword'];
            $order   = ($data['order'] == 'create_desc' ? 'desc' : 'asc');
            $spots   = $this->find('all', array('conditions' => array('explanation LIKE' => "%$keyword%"), 'order' => array('Spot.id' => $order)));
            return $spots;
        }
    }

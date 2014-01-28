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
            ),
            'Supobijo' => array(
                'className'  => 'Supobijo',
                'conditions' => array('Supobijo.spot_id' => 'id'),
                'order'      => array('Supobijo.id'      => 'desc')
            )
        );

        public function register($data){
            if(isset($data['spot_name'], $data['explanation'])){
                $data['spot_name']   = htmlspecialchars($data['spot_name']);
                $data['explanation'] = htmlspecialchars($data['explanation']);

                $this->save($data);

                return 1;
            }

            return 0;
        }

        public function search($data){
            $keyword = htmlspecialchars($data['keyword']);
            $order   = ($data['order'] == 'create_desc' ? 'desc' : 'asc');
            $spots   = $this->find('all', array(
                'conditions' => array(
                    'or' => array(
                        'spot_name LIKE'   => "%$keyword%",
                        'explanation LIKE' => "%$keyword%"
                    ),
                ),
                'order' => array('Spot.id' => $order)
            ));

            return $spots;
        }
    }

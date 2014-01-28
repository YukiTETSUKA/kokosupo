<?php
class Supobijo extends Model{
    public $name = 'Supobijo';
    public $belongsTo = array(
        'Spot' => array(
            'className' => 'Spot',
            'conditions' => array('Spot.id' => 'Supobijo.spot_id'),
        )
    );

    public function register($data){
<<<<<<< HEAD
        debug($data);
=======
        //debug($data);
>>>>>>> fae3a585d79acfdd4bacde184cd2ed0fee9bbfd5
        $this->save($data);
    }
}

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
        //debug($data);
        $this->save($data);
    }
}

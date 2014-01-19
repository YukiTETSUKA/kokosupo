<?php
    class Image extends Model{
        public $name = 'Image';

        public function upload($data, $spot_id){ // 1:成功 2:失敗
            if($data['type'] == 'image/jpeg' || $data['type'] == 'image/gif'){
                if($data['size'] <= 500000){
                    $number = $this->find('count');
                    $path   = $spot_id . '_' . ($number + 1) . '_' . $data['name'];
                    if(move_uploaded_file($data['tmp_name'], 'img/' . $path)){
                        $image['spot_id'] = $spot_id;
                        $image['path']    = $path;

                        $this->save($image);
                        debug($image);
                        return 1;
                    }
                }
            }

            return 0;
        }
    }

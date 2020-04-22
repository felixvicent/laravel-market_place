<?php
    namespace App\Traits;

    trait UploadTrait {
        
        private function imageUpload($images, $imageColumn = null){
    
            $uploadesImages = [];
    
            if(is_array($images)) {
                foreach($images as $image){
                    $uploadesImages[] = [$imageColumn => $image->store('products', 'public')];
                }
            }
            else{
                $uploadesImages = $images->store('logo', 'public');
            }
    
            return $uploadesImages;
        }
    }
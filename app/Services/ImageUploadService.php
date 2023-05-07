<?php

namespace App\Services;

class ImageUploadService{

  public $image;
  public $path;
  public $obj;
  
    function __construct(object $obj,$image,$path) //accepts object as a parameter
    {    
        $this->obj = $obj; 
        $this->image = $image; 
        $this->path = $path; 
    }


    public function uploadImage()
    {

        if($this->image && $this->image !== null){

            $this->image->store('public/'. $this->path . '/'); 
            
            return $this;
        }           

        return $this;
    }


    public function storeImageDB($fieldName)
    {

        if($fieldName && $this->image){
                                    
            $this->obj->{$fieldName} = $this->path . '/' . $this->image->hashName();

            //result: $this->obj->avatar = '/product_images/0Dq4n3h0frEhi8AQCJULdtz.png/'
            
            return $this->obj;
        }

        return $this;
    }

    public function deleteImage($fieldName)
    {
        $storePath = public_path('storage/'. $this->obj->{$fieldName}); 

        if($this->obj->{$fieldName} && file_exists($storePath)){

            //unlink method will delete the image from the folder
            unlink(public_path('storage/'.$this->obj->{$fieldName}));
        
            return $this;
        }

        return $this;
        
    }
}
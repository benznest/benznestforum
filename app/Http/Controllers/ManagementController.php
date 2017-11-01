<?php namespace App\Http\Controllers;
use Input; 
use Image;

class ManagementController extends Controller {

	public function uploadImage(){
		if(Input::file())
        {
            $extension = Input::file('file')->getClientOriginalExtension();;
            $image = Image::make(Input::file('file'));
            $filename  = time() . '.' . $extension;
            $path = 'resources/assets/img/comment/' . $filename;

            if($image->width() > 500){

                // resize the image to a width of 300 and constrain aspect ratio (auto height)
                $image->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            if($image->height() > 500){

                // resize the image to a height of 200 and constrain aspect ratio (auto width)
                $image->resize(null, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });

            }
            $image->save($path);
            //Image::make($image)->save($path);
            //$user->image = $filename;
            //$user->save();
            return  $path;
        }
    }

    public function getImage($name){
        return url('resources/assets/img/comment/'.$name);
    }
}

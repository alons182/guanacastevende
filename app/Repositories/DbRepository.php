<?php namespace App\Repositories;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class DbRepository {

    protected $model;

    function __construct($model)
    {
        $this->model = $model;
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function destroy($id)
    {
        $model = $this->model->findOrFail($id);
        $model->delete();

        return $model;
    }

    public function getTotal()
    {
        return $this->model->count();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update_state($id, $state)
    {

        $model = $this->findById($id);
        $model->published = $state;
        $model->save();

        return $model;
    }

    public function update_active($id, $state)
    {

        $model = $this->findById($id);
        $model->active = $state;
        $model->save();

        return $model;
    }

    public function update_feat($id, $feat)
    {
        $model = $this->findById($id);
        $model->featured = $feat;
        $model->save();

        return $model;
    }

    public function storeImage($file, $name, $directory, $width = null, $height = null, $thumbWidth, $thumbHeight = null, $watermark = null )
    {

        $filename = Str::slug($name) . '.' . $file->getClientOriginalExtension();
        $path = dir_photos_path($directory);
        $image = Image::make($file->getRealPath());

        File::exists($path) or File::makeDirectory($path, 0775, true);

        $image->interlace();

        // IF THE FILE SIZE IS BIGGER(1MB+) RESIZE
        if($image->filesize() >= 1048576)
        {
            if($width)
            {
                if($image->width() > $image->height())
                {
                    if($image->width() >= $width )
                    {
                        $image->resize($width, $height, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                    }else{
                        $image->resize($image->width(), $height, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                    }

                }else{
                    if($image->height() >= $width )
                    {
                        $image->resize($height, $width, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                    }else{
                        $image->resize($image->height(), $width, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                    }
                }
            }
        }
        if($watermark) $image->insert('img/logo.png','center');

        $image->save($path . $filename, 60)
            ->resize($thumbWidth, $thumbHeight, function ($constraint)
            {
                $constraint->aspectRatio();
            })
            ->interlace()

            ->save($path . 'thumb_' . $filename, 60);

        return $filename;
    }


}
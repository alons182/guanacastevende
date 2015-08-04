<?php namespace App\Repositories;


use App\Photo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PhotoRepository extends DbRepository {


    /**
     * @param Photo $model
     */
    function __construct(Photo $model)
    {
        $this->model = $model;
    }

    /**
     * Save a photo in the DB
     * @param $data
     * @return mixed
     */
    public function store($data)
    {
        $cant = count($this->getPhotos($data['product_id']));
        $data['url'] = ($data['photo']) ? $this->storeImage($data['photo'], 'photo_' . ++ $cant, 'products/' . $data['product_id'], null, null, 150, null, true) : '';
        $data['url_thumb'] = 'thumb_' . $data['url'];

        $photo = $this->model->create($data);

        return $photo;
    }


    /**
     * Get the photos from one product
     * @param $id
     * @return mixed
     */
    public function getPhotos($id)
    {
        return $this->model->where('product_id', '=', $id)->get();
    }

    /**
     * Save the photo in the server
     * @param $file
     * @param $name
     * @param $directory
     * @param null $width
     * @param null $height
     * @param $thumbWidth
     * @param null $thumbHeight
     * @param null $watermark
     * @return string
     */
    public function storeImage($file, $name, $directory, $width = null, $height = null, $thumbWidth, $thumbHeight = null, $watermark = null )
    {
        $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        $filename = Str::slug($name) . '.' . $extension;
        $path = dir_photos_path($directory);
        $image = Image::make($file["tmp_name"]);

        File::exists($path) or File::makeDirectory($path, 0775, true);

        $image->interlace();

        // IF THE FILE SIZE IS BIGGER(1MB+) RESIZE
        if($image->filesize() >= 1048576)
        {
            if ($width)
            {
                if ($image->width() > $image->height())
                {
                    if ($image->width() >= $width)
                    {
                        $image->resize($width, $height, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                    } else
                    {
                        $image->resize($image->width(), $height, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                    }

                } else
                {
                    if ($image->height() >= $width)
                    {
                        $image->resize($height, $width, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                    } else
                    {
                        $image->resize($image->height(), $width, function ($constraint)
                        {
                            $constraint->aspectRatio();
                        });
                    }
                }
            }
        }
        if($watermark) $image->insert('img/logo.png','center');
        $image->save($path . $filename, 60)->resize($thumbWidth, $thumbHeight, function ($constraint)
        {
            $constraint->aspectRatio();
        })->interlace()->save($path . 'thumb_' . $filename, 60);

        return $filename;
    }
}
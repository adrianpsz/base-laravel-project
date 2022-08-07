<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * @param string $name
     *
     * @return Application|ResponseFactory|Response|void
     *
     * @throws FileNotFoundException
     */
    function show(string $name)
    {
        $image = Image::byName($name)->first();
        if (!is_null($image)) {
            if (Storage::disk('local')->exists(
                Image::IMAGE_PATH . $image->filename
            )) {
                $output = Storage::disk('local')->get(
                    Image::IMAGE_PATH . $image->filename
                );
                return response($output, 200)->header(
                    'Content-type', $image->mime
                );
            }

            return response();
        }

        abort(404);
    }
}

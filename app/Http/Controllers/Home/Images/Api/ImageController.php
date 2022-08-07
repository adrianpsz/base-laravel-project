<?php

namespace App\Http\Controllers\Home\Images\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\News;
use App\Traits\ApiUtils;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    use ApiUtils;

    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function news(News $news)
    {
        $this->authorize('view', $news);

        return ImageResource::collection($news->images);
    }

    /**
     * @param Image $from
     * @param Image $to
     *
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function reorder(Image $from, Image $to)
    {
        $this->authorize('update', $from);
        $this->authorize('update', $to);

        DB::beginTransaction();
        try {
            $temp = $from->order;
            $from->order = $to->order;
            $to->order = $temp;

            $from->save();
            $to->save();
            DB::commit();

            return $this->successMessageWithData(
                __('The image reorder was successful.'), [
                    'images' => $from->imageable->images
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
        }

        return $this->errorMessage(
            __('The image reorder was not successful.')
        );
    }

    /**
     * @param Image $image
     *
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Image $image)
    {
        $this->authorize('delete', $image);

        $news = $image->imageable;
        $file = Image::IMAGE_PATH . $image->filename;
        if (Storage::disk('local')->exists($file)) {
            Storage::disk('local')->delete($file);
        }
        $image->delete();

        return $this->successMessageWithData(
            __('The image was successful deleted.'),
            [
                'images' => $news->images
            ]
        );
    }
}

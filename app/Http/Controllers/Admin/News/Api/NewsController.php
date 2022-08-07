<?php

namespace App\Http\Controllers\Admin\News\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Traits\ApiUtils;
use Illuminate\Http\JsonResponse;
use function __;

class NewsController extends Controller
{
    use ApiUtils;

    /**
     * @param News $news
     *
     * @return JsonResponse
     */
    public function toggleActivation(News $news): JsonResponse
    {
        if ($news->is_active == 1) {
            $news->is_active = 0;
        } else {
            $news->is_active = 1;
        }
        $news->save();

        return $this->successMessageWithData(
            $news->is_active ?
                __('The news ":title" has been activated.', ['title' => $news->title]) :
                __('The news ":title" has been deactivated.', ['title' => $news->title])
            , [
                'active' => $news->is_active
            ]
        );
    }
}

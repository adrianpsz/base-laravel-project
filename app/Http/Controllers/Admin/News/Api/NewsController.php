<?php

namespace App\Http\Controllers\Admin\News\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use function __;
use function response;

class NewsController extends Controller
{
    /**
     * @param News $news
     *
     * @return JsonResponse
     */
    public function toggleActivation(News $news): JsonResponse
    {
        if ($news->is_active == 1)
            $news->is_active = 0;
        else
            $news->is_active = 1;
        $news->save();

        return response()->json([
            'message' => __('The news has been activated.'),
            'active' => $news->is_active,
        ]);
    }
}

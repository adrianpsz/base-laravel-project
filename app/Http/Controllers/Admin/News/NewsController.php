<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Traits\ApiUtils;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use function session;
use function view;

class NewsController extends Controller
{
    use ApiUtils;

    /**
     * @return Application|Factory|View|AnonymousResourceCollection
     */
    public function index()
    {
        $news = News::paginate(self::ITEMS_PER_PAGE);

        session(['previous_page' => url()->current()]);

        return $this->collectionWithView(
            NewsResource::collection($news),
            view('admin.news.index', [
                'news' => $news,
            ])
        );
    }
}

<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use function session;
use function view;

class NewsController extends Controller
{
    /**
     * @return Application|Factory|View|AnonymousResourceCollection
     */
    public function index()
    {
        $news = News::paginate(self::ITEMS_PER_PAGE);

        if (request()->wantsJson()) {
            return NewsResource::collection($news);
        }

        session(['previous_page' => url()->current()]);
        return view('admin.news.index', [
            'news' => $news,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use function view;

class PagesController extends Controller
{
    function index()
    {
        $news = News::active()->paginate(2);

        if (request()->wantsJson()) {
            return NewsResource::collection($news);
        }

        return view('pages.index', [
            'news' => $news,
        ]);
    }

    function privacy()
    {
        return view('pages.privacy');
    }

    function terms()
    {
        return view('pages.terms');
    }

    function contact()
    {
        return view('pages.contact');
    }

    function test()
    {
        return view('pages.test');
    }


    public function locale(Request $request, $locale)
    {

        $l = 'en';
        switch ($locale) {
            case 'pl':
                $l = 'pl';
                break;
            case 'de':
                $l = 'de';
                break;
            default:
        }

        app()->setLocale($l);
        session()->put('locale', $l);

        return redirect()->back();
    }
}

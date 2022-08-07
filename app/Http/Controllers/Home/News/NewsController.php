<?php

namespace App\Http\Controllers\Home\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\Image;
use App\Models\News;
use App\Traits\ApiUtils;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class NewsController extends Controller
{
    use ApiUtils;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|AnonymousResourceCollection|View
     */
    public function index()
    {
        $news = News::byUser(Auth::user())->paginate(self::ITEMS_PER_PAGE);

        if (\request()->wantsJson()) {
            return NewsResource::collection($news);
        }

        session(['previous_page' => url()->current()]);
        return view('home.news.index', [
            'news' => $news,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('home.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsRequest $request
     * @return Response
     */
    public function store(NewsRequest $request)
    {
        $request->validated();

        DB::beginTransaction();
        try {
            $news = News::create([
                'title' => clean($request->title),
                'message' => clean($request->message),
            ]);

            $this->uploadImages($news, $request);
            DB::commit();

            return $this->successMessageWithResponse(
                __('New news ":title" was successful created.', ['title' => $news->title]),
                redirect()->route('home.news.index')
            );
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $this->errorMessageWithResponse(
            __('There was an error. Please try again later.'),
            redirect()->route('home.news.index')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param News $news
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function show(News $news)
    {
        $this->authorize('view', $news);

        return $this->modelWithView(
            new NewsResource($news),
            view('home.news.show', [
                'news' => $news,
            ])
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param News $news
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function edit(News $news)
    {
        $this->authorize('update', $news);

        return view('home.news.edit', [
            'news' => $news,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NewsRequest $request
     * @param News $news
     *
     * @return Response
     *
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function update(NewsRequest $request, News $news)
    {
        $this->authorize('update', $news);

        $request->validated();

        DB::beginTransaction();
        try {
            $news->update([
                'title' => clean($request->title),
                'message' => clean($request->message),
            ]);

            $this->uploadImages($news, $request);
            DB::commit();

            return $this->successMessageWithResponse(
                __('The news ":title" was successful updated.', ['title' => $news->title]),
                redirect()->route('home.news.edit', ['news' => $news->id])
            );
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $this->errorMessageWithResponse(
            __('There was an error. Please try again later.'),
            redirect()->route('home.news.edit', ['news' => $news->id])
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News $news
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function destroy(News $news)
    {
        $this->authorize('delete', $news);
        $title = $news->title;

        DB::beginTransaction();
        try {
            foreach ($news->images as $image) {
                $file = Image::IMAGE_PATH . $image->filename;
                if (Storage::disk('local')->exists($file)) {
                    Storage::disk('local')->delete($file);
                }
                $image->delete();
            }

            $news->delete();

            DB::commit();

            return $this->successMessageWithResponse(
                __('The news ":title" was successful deleted.', ['title' => $title]),
                redirect()->back()
            );
        } catch (\Exception $e) {
            DB::rollBack();
        }

        return $this->errorMessageWithResponse(
            __('There was an error. Please try again later.'),
            redirect()->back()
        );
    }

    /**
     * @param News $news
     * @param Request $request
     *
     * @return void
     *
     * @throws ValidationException
     */
    protected function uploadImages(News $news, Request $request)
    {
        if ($request->files->has('images')) {
            // check amount of images
            $fileCount = $news->images()->count() + count($request->files->get('images'));
            if ($fileCount > Image::MAX_IMAGES) {
                throw ValidationException::withMessages([
                    'images' => [__('You can upload only :count images.', ['count' => Image::MAX_IMAGES])],
                ]);
            }

            // get max order
            $maxOrder = intval($news->images()->max('order')) + 1;

            /**
             * @var $image UploadedFile
             */
            foreach ($request->files->get('images') as $key => $image) {
                // extension and mime
                $imageExtension = $image->getClientOriginalExtension();
                $imageMime = $image->getClientMimeType();

                // uniq name
                $imageName = Str::slug($news->id . '-' . time() . '-' . $key
                        . '-' . basename($image->getClientOriginalName(), '.' . $imageExtension))
                    . '.' . $imageExtension;

                // resize image and encode
                $img = \Intervention\Image\Facades\Image::make($image->getPathname());
                $img->resize(600, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode($imageMime, 80);

                // save image to 'local' disk
                Storage::disk('local')->put(
                    Image::IMAGE_PATH . $imageName,
                    $img
                );

                // create a model for file
                $news->images()->create([
                    'filename' => $imageName,
                    'mime' => $imageMime,
                    'order' => $maxOrder + $key,
                ]);
            }
        }
    }

}

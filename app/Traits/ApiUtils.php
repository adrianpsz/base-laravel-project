<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\View\View;

trait ApiUtils
{
    /**
     * @param String $message
     * @return JsonResponse
     */
    function successMessage(string $message)
    {
        return response()->json([
            'message' => $message
        ]);
    }

    /**
     * @param String $message
     * @param array $data
     * @return JsonResponse
     */
    function successMessageWithData(string $message, array $data = [])
    {
        return response()->json(array_merge([
            'message' => $message
        ], $data));
    }

    /**
     * @param string $message
     * @param $response
     *
     * @return JsonResponse|mixed
     */
    function successMessageWithResponse(string $message, $response)
    {
        if (\request()->wantsJson()) {
            return $this->successMessage($message);
        }

        return $response->with('success', $message);
    }

    /**
     * @param String $message
     *
     * @return JsonResponse
     */
    function errorMessage(string $message)
    {
        return response()->json([
            'message' => $message
        ], 404);
    }

    /**
     * @param String $message
     * @param Response | RedirectResponse $response
     *
     * @return Response|JsonResponse
     */
    function errorMessageWithResponse(string $message, $response)
    {
        if (\request()->wantsJson()) {
            return $this->errorMessage($message);
        }

        return $response->with('error', $message);
    }

    /**
     * @param JsonResource $model
     * @param View $view
     *
     * @return JsonResource|View
     */
    function modelWithView(JsonResource $model, View $view)
    {
        if (\request()->wantsJson()) {
            return $model;
        }

        return $view;
    }

    /**
     * @param AnonymousResourceCollection $collection
     * @param View $view
     *
     * @return AnonymousResourceCollection|View
     */
    function collectionWithView(AnonymousResourceCollection $collection, View $view)
    {
        if (\request()->wantsJson()) {
            return $collection;
        }

        return $view;
    }
}

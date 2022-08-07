<?php

namespace App\Http\Controllers\Pages\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use function clean;
use function env;
use function request;
use function response;

class ApiController extends Controller
{
    /**
     * @param ContactRequest $request
     *
     * @return JsonResponse
     */
    function contact(ContactRequest $request)
    {
        $request->validated();

        $message = new ContactMessage();
        $message->name = clean($request->get('name'));
        $message->email = clean($request->get('email'));
        $message->subject = clean($request->get('subject'));
        $message->message = clean($request->get('message')) . "<br><br>" . clean($request->href);
        $message->ip = request()->ip();

        if ($message->save()) {
            Mail::to(env('MAIL_CONTACT_TO'))
                ->send(new ContactMessageMail($message));

            return response()->json([
                'status' => 'OK'
            ]);
        }

        return response()->json([
            'status' => 'ERROR'
        ], 404);
    }
}

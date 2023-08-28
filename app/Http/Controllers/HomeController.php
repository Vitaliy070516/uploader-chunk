<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Http\Requests\StoreAttachmentRequest;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function store(StoreAttachmentRequest $request)
    {
        $attachment = new Attachment;
        $attachment->name = $request->name;
        $attachment->path = $attachment->upload($request->attachment);

        $attachment->save();

        return response()->json([
            'message' => 'Attachment has been successfully uploaded.',
        ]);
    }
}
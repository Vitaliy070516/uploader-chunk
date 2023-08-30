<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploaderRequest;
use App\Services\UploaderService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UploaderController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('uploader');
    }

    /**
     * @param UploaderRequest $request
     * @param UploaderService $uploaderService
     * @return JsonResponse
     * @throws FileNotFoundException
     */
    public function store(UploaderRequest $request, UploaderService $uploaderService): JsonResponse
    {
        $fileParam = $request->file('file');
        $newFileName = $request->get('uid') . '_' . str_replace(' ', '_', $fileParam->getClientOriginalName());
        $chunkPath = Storage::disk('local')->path("chunks/{$newFileName}");
        Storage::append($chunkPath, $fileParam->get());

        if ($request->has('is_last') && $request->boolean('is_last')) {
            $newFileName = basename($newFileName, '.part');
            Storage::move($chunkPath, "/public/uploads/{$newFileName}");

            $result = $uploaderService->upload($fileParam, $newFileName);

            return response()->json([
                'uploaded' => true,
                'message' => [
                    'savingAllSuccessful' => true,
                    'fileName' => $result['fileName'],
                    'correctRecordCount' => $result['correctRecordCount'],
                    'incorrectRecordCount' => $result['incorrectRecordCount'],
                ]
            ]);
        }

        return response()->json(['uploaded' => true]);
    }
}

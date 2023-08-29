<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttachmentRequest;
use App\Models\CorrectRecord;
use App\Models\File;
use App\Models\IncorrectRecord;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function store(StoreAttachmentRequest $request)
    {
        $file = new File;
        $file->name = $request->attachment->getClientOriginalName();
        $file->path = $file->upload($request->attachment);
        $file->save();

        $fullPath = storage_path('app/public/' . $file->path);
        $fileResource = fopen($fullPath, 'r');

        $correctRecordCount = 0;
        $incorrectRecordCount = 0;
        while ($row = fgetcsv($fileResource)) {
            $isCorrect = true;
            foreach ($row as $cell) {
                if (!is_string($cell) || is_numeric($cell) || $cell === '') {
                    $isCorrect = false;
                    $incorrectRecord = new IncorrectRecord;
                    $incorrectRecord->a = $row[0];
                    $incorrectRecord->b = $row[1];
                    $incorrectRecord->c = $row[2];
                    $incorrectRecord->d = $row[3];
                    $incorrectRecord->e = $row[4];
                    $incorrectRecord->f = $row[5];
                    $incorrectRecord->g = $row[6];
                    $incorrectRecord->h = $row[7];
                    $incorrectRecord->file_id = $file->id;
                    $incorrectRecord->save();
                    $correctRecordCount++;
                    break;
                }
            }
            if ($isCorrect) {
                $correctRecord = new CorrectRecord;
                $correctRecord->a = $row[0];
                $correctRecord->b = $row[1];
                $correctRecord->c = $row[2];
                $correctRecord->d = $row[3];
                $correctRecord->e = $row[4];
                $correctRecord->f = $row[5];
                $correctRecord->g = $row[6];
                $correctRecord->h = $row[7];
                $correctRecord->file_id = $file->id;
                $correctRecord->save();
                $incorrectRecordCount++;
            }
        }

        fclose($fileResource);

        return response()->json([
            'message' => [
                'fileName' => $file->name,
                'correctRecordCount' => $correctRecordCount,
                'incorrectRecordCount' => $incorrectRecordCount,
            ]
        ]);
    }
}

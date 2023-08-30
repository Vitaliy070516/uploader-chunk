<?php

namespace App\Services;

use App\Models\CorrectRecord;
use App\Models\File;
use App\Models\IncorrectRecord;
use Illuminate\Http\UploadedFile;

class UploaderService
{
    /**
     * @param UploadedFile $fileParam
     * @param string $newFileName
     * @return array
     */
    public function upload(UploadedFile $fileParam, string $newFileName): array
    {
        $file = new File;
        $file->name = basename($fileParam->getClientOriginalName(), '.part');
        $file->path = "uploads/{$newFileName}";
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

        return [
            'fileName' => $file->name,
            'correctRecordCount' => $correctRecordCount,
            'incorrectRecordCount' => $incorrectRecordCount,
        ];
    }
}

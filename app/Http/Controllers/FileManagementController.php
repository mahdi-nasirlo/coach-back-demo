<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileManagementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');

        $time = time();
        $fileFolder = '/tmp/' . $time;
        $fileName = $file->getClientOriginalName();
        Storage::disk('public')->putFileAs($fileFolder, $file, $fileName);

        $tmp = TemporaryFile::query()->create([
            'folder' => $time,
            'filename' => $fileName,
            'file_type' => $file->getClientOriginalExtension()
        ]);

        return $this->respondWithSuccess(["key" => $time]);
    }

    public function fetch(Request $request, string $filename)
    {

        $file = Media::findByUuid($filename);

        if ($file) {
            $file_path = $file->getPath();
        } else {
            $tmp = TemporaryFile::query()->where("folder", $filename)->firstOrFail();

            $file_path = storage_path("app/public/tmp/" . $tmp->folder . "/" . $tmp->filename);
        }


        return response()->file($file_path);
    }
}

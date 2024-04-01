<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadChunkRequest;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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

    public function chunkStore()
    {
        $time = time();
        $folderPath = storage_path("app/public/tmp/" . $time);
        $tmpPath = storage_path("app/public/tmp");

        if (!File::exists($tmpPath)) mkdir($tmpPath);

        File::makeDirectory($folderPath);
        file_put_contents($folderPath . "/file.part", null);

        return $this->respondWithSuccess($time);
    }

    public function chunkUpdate(FileUploadChunkRequest $request)
    {
        $path = "/tmp/" . $request->input("patch");
        $filename = $request->input("upload_name");
        $folderFile = storage_path("/app/public/" . $path . "/");

        $targetFile = $folderFile . "file.part";
        $finalFile = $folderFile . $filename;

        File::append($targetFile, $request->file("chunk")->getContent());

        if ($finalChunk = filesize($targetFile) == $request->input("upload_length")) {

            File::move($targetFile, $finalFile);

            TemporaryFile::query()->create([
                'folder' => $filename,
                'filename' => $request->query("patch"),
                'file_type' => "png"
            ]);
        }

        return $this->respondWithSuccess([
            "key" => $request->input("patch"),
            "final" => $finalChunk
        ]);
    }
}

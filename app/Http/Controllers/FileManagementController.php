<?php

namespace App\Http\Controllers;

use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'filename' => $fileName
        ]);

        return $this->respondWithSuccess(["key" => $time]);
    }

    public function fetch(Request $request, string $filename)
    {
        $tmp = TemporaryFile::query()->where("folder", $filename)->firstOrFail();

        $file_path = storage_path("app/public/tmp/" . $tmp->folder . "/" . $tmp->filename);

        return response()->file($file_path);
    }
}

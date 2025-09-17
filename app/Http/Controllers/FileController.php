<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|max:2048',
        ]);
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName);
        File::create([
            'name' => $fileName,
            'path' => $filePath,
        ]);
        return redirect()->back()->with('message', 'File uploaded successfully.');
    }

    public function destroy(Request $request) {
        $filename = $request->get('filename');

        File::where('name', $filename)->delete();
        Storage::delete("uploads/{$filename}");

        return redirect()->back()->with('message', 'File deleted successfully.');
    }
}

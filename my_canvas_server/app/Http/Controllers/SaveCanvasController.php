<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaveCanvasController extends Controller
{
    public function save_canvas(Request $request) { // Saglabā bildi un to pāšu atrgriež
        Storage::put('dsa.png', $request->image);
        return response()->json(["image"=>Storage::get('dsa.png')], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Image\Image;
use App\Models\User;

class ImageCropperController extends Controller
{
  public function index(){
    return view('component');
  }

  public function show(Request $request){
    $data = User::find(1);
    if (empty($data)) {
      return response()->json(['error' => 'Data is Empty']);
    }
    return response()->json($data);
  }

  public function update(Request $request){
    //dd($request->file('photo_url'));
    $user = User::find(1);
    if ($request->file('photo_url')) {
      $renameFile = time()."-".$request->file('photo_url')->getClientOriginalName();
      $user->photo_url =  $renameFile;
      Image::load($request->file('photo_url'))->manualCrop($request->width, $request->height, $request->x, $request->y)->save(public_path($renameFile));
      $user->save();
    }
  }
}

<?php

namespace App\Http\Controllers\Admin;
use App\Image;
use App\Service;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    public function update(Request $request, Image $image)
    {
        $data=$image;
        $apartment = $image->apartment()->first();
        $images = $apartment->images()->get();
        $previousMainImage = $apartment->images()->where('main_image', '=', true)->get();
        if($previousMainImage->toArray()){
            $prevImage = $previousMainImage[0]->toArray();
            $prevImage['main_image']=false;
            $oldMainImage = Image::find($prevImage['id']);
            $oldMainImage->update($prevImage);
        }
        $data=$data->toArray();
        $data['main_image']=true;
        $image->update($data);
        $services = Service::all();
        return view('admin.apartments.edit',compact('apartment','services'));
    }

    public function destroy(Image $image)
    {
        dd($image);
        $apartment = $image->apartment()->first();
        $image->delete();
        $services = Service::all();
        return view('admin.apartments.edit',compact('apartment','services'));
    }
}

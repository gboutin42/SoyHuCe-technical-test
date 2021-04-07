<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;

class FileController extends Controller
{
	//
	function upload(Request $request)
	{
		$result = $request->file('image')
                    ->storePubliclyAs('public/images',
                                $request->file('image')
                                    ->getClientOriginalName());
		return ['result' => $result];
	}

	function filesList()
	{
		$result = Storage::allFiles('public/images');
		return ['result' => $result];
	}

    function updateName(Request $request)
    {
        if ($request->oldName && $request->newName)
        {
            $oldPath =  "public/images/" . $request->oldName;
            $newPath =  "public/images/" . $request->newName;
            $image = Storage::move($oldPath, $newPath);
            // $image = Image::load($oldPath)->save($newPath);

            return ['result' => $image];
        }
        else
        {
            return ['erreur' => 'Parameters oldName or newName missing'];
        }
    }

    function updateSize(Request $request)
    {
        $pathName = "public/images/" . $request->name;
        Image::load($pathName)
                ->width($request->width)
                ->height($request->height)
                ->save();
    }

    function updateCrop(Request $request)
    {
        $pathName = "public/images/" . $request->name;
        Image::load($pathName)
                ->manualCrop($request->width, $request->height,
                                $request->startX, $request->startY)
                ->save();
    }

    function updateFilter(Request $request)
    {
        $name = "punlic/images/" . $request->name;
        $image = Image::load($name);
        if ($request->filter == "sepia")
        {
            $image->sepia();
        }
        else if ($request->filter == "grayscale")
        {
            $image->greyscale();
        }
        $image->save();
    }

    function downloadFile(Request $request)
    {
        $name = $request->name;
        $path = storage_path() . '/app/public/images/coucou2.PNG' . $name;
        $headers = array(
            'Content-Type' => 'image/' . Storage::extension("public/images/coucou2.PNG"),
          );
        return response()->download($path, "coucou.png");
    }
}

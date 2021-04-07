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
            // $oldPath =  "public/images/" . $request->oldName;
            // $newPath =  "public/images/" . $request->newName;
            // $image = Storage::move($oldPath, $newPath);

            $oldPath = storage_path() . "/app/public/images/" . $request->oldName;
            $newPath = storage_path() . "/app/public/images/" . $request->newName;
            $image = Image::load($oldPath)->save($newPath);

            return ['result' => $image];
        }
        else
        {
            return ['erreur' => 'Parameters oldName or newName missing'];
        }
    }

    function updateSize(Request $request)
    {
        $pathName = storage_path() . "/app/public/images/" . $request->name;
        Image::load($pathName)
                ->width($request->width)
                ->height($request->height)
                ->save();
    }

    function updateCrop(Request $request)
    {
        $pathName = storage_path() . "/app/public/images/" . $request->name;
        Image::load($pathName)
                ->manualCrop($request->width, $request->height,
                                $request->startX, $request->startY)
                ->save();
    }

    function updateFilter(Request $request)
    {
        $name = storage_path() . "/app/public/images/" . $request->name;
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

        return ["result" => $image];
    }

    function downloadFile($fileName)
    {
        $path = storage_path() . '/app/public/images/' . $fileName;
        $headers = array(
            'Content-Type' => 'image/*'
          );
        return response()->download($path, $fileName, $headers);
    }
}

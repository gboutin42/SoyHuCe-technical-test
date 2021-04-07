<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    function updateName(Request $req)
    {
        if ($req->oldName && $req->newName)
        {
            // $oldPath =  "public/images/" . $req->oldName;
            // $newPath =  "public/images/" . $req->newName;
            // $image = Storage::move($oldPath, $newPath);

            $oldPath = storage_path() . "/app/public/images/" . $req->oldName;
            $newPath = storage_path() . "/app/public/images/" . $req->newName;
            Image::load($oldPath)->save($newPath);
        }
        else
        {
            return ["erreur" => "Une erreur est parvenu, vérifier l'ensemble
                                    des parametre fourni (oldName, newName)"];
        }
    }

    function updateSize(Request $req)
    {
        if ($req && $req->fileName && $req->width && $req->height)
        {
            $pathName = storage_path() . "/app/public/images/" . $req->fileName;
            Image::load($pathName)
                    ->width($req->width)
                    ->height($req->height)
                    ->save();
        }
        else
        {
            return ["erreur" => "Une erreur est parvenu, vérifier l'ensemble
                            des parametre fourni (fileName, width, height)"];
        }
    }

    function updateCrop(Request $req)
    {
        if ($req && $req->fileName && $req->width && $req->height
            && $req->startX && $req->startY)
        {
            $pathName = storage_path() . "/app/public/images/" . $req->fileName;
            Image::load($pathName)
                    ->manualCrop($req->width, $req->height,
                                    $req->startX, $req->startY)
                    ->save();
        }
        else
        {
            return ["erreur" => "Une erreur est parvenu, vérifier l'ensemble
                des parametre fourni (fileName, width, height, startX, startY)"];
        }
    }

    function updateFilter(Request $req)
    {
        if ($req && $req->fileName && $req->filter)
        {
            $path = storage_path() . "/app/public/images/" . $req->fileName;
            $image = Image::load($path);
            if ($req->filter == "sepia")
            {
                $image->sepia();
            }
            else if ($req->filter == "grayscale")
            {
                $image->greyscale();
            }
            $image->save();
        }
        else
        {
            return ["erreur" => "Une erreur est parvenu, vérifier l'ensemble
                                    des parametre fourni (fileName, filter)"];
        }
    }

    function downloadFile($fileName)
    {
        if ($fileName && $fileName != '')
        {
            $path = storage_path() . '/app/public/images/' . $fileName;
            $headers = array(
                'Content-Type' => 'image/*'
              );
            return response()->download($path, $fileName, $headers);
        }
        else
        {
            return ["erreur" => "Une erreur est parvenu, vérifier l'ensemble
                                            des parametre fourni (fileName)"];
        }
    }
}

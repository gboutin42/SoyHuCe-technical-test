<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;

class FileController extends Controller
{
	// For upload new file and store on the server
	function upload(Request $request)
	{
        // return ['result' => $request->name];
		try {
            $result = $request->file('image')
                        ->storePubliclyAs('public/images',
                            $request->file('image')->getClientOriginalName());
            return ['result' => $result, 'path' => storage_path()];
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
	}

    // Get all files Images on the server
	function filesList()
	{
        try {
            $result = Storage::allFiles('public/images');
            return ['result' => $result];
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
	}

    // Rename file
    function updateName(Request $req)
    {
        try
        {
            if ($req->oldName && $req->newName)
            {
                $oldPath =  "public/images/" . $req->oldName;
                $newPath =  "public/images/" . $req->newName;
                $image = Storage::move($oldPath, $newPath);

                /*
                 * The following method is not used because the save method with
                 * $newPath makes a copy of the image and renames it
                 * and this is not the expected behavior
                 * but we keep it until we know more
                 */
                // $oldPath = storage_path() . "/app/public/images/" . $req->oldName;
                // $newPath = storage_path() . "/app/public/images/" . $req->newName;
                // Image::load($oldPath)->save($newPath);
            }
            else
            {
                return ["erreur" => "Une erreur est parvenu, vérifier l'ensemble
                                        des parametre fourni (oldName, newName)"];
            }
        }
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }

    // Resize File
    function updateSize(Request $req)
    {
        try{
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
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }

    // Crop file size
    function updateCrop(Request $req)
    {
        try
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
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }

    // Add filter
    function updateFilter(Request $req)
    {
        try
        {
            if ($req && $req->fileName && $req->filter)
            {
                $path = storage_path() . "/app/public/images/" . $req->fileName;
                $image = Image::load($path);

                // check match filter
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
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }

    // Get file for download
    function downloadFile($fileName)
    {
        try
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
        catch (Exception $e)
        {
            return $e->getMessage();
        }
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: Nata
 * Date: 20.03.2023
 * Time: 23:25
 */

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    public function getImageFileName($extension)
    {
        return md5(uniqid(rand(), true)) . '-' . md5(microtime()) . '.' . $extension;
    }

    public function storeImageFile($fileRequest, $folderPath)
    {
        $imageParts = explode(';base64,', $fileRequest);
        $imageTypeAux = explode("image/", $imageParts[0]);
        $imageName = $this->getImageFileName($imageTypeAux[1]);
        $imageBase64 = base64_decode($imageParts[1]);
        Storage::disk('local')->put($folderPath.$imageName, $imageBase64);
        return $imageName;
    }

    public function deleteImageFile($imagePath)
    {
        if(Storage::exists($imagePath)) Storage::delete($imagePath);
        else return redirect()->back()->withErrors('Can\'t delete image');
    }
}
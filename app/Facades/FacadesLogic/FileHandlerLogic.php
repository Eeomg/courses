<?php

namespace App\Facades\FacadesLogic;

use http\Env;
use Illuminate\Support\Facades\Storage;

class FileHandlerLogic
{

    /**
     * @param $file
     * @return string
     */
    public function storeFile($file, $path, $extension, $name = null)
    {
        try{
            $newName = ($name ?? time()).".$extension";
            $path = Storage::putFileAs($path, $file, $newName);
            return $path;
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $file
     * @param string $oldname
     * @return string
     */
    public function updateFile($file, $oldname,$path, $extension, $name = null)
    {
        try{
            $this->deleteFile($oldname);
            return $this->storeFile($file,$path,$extension, $name);
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function deleteFile(...$names)
    {
        try {
            if(count($names) > 1){
                foreach ($names as $file) {
                    if($file && Storage::exists($file)){
                        Storage::delete($file);
                    }
                }
            }else{
                Storage::delete($names[0]);
            }
        } catch (\Exception $e) {
            return throw new \Exception($e->getMessage());
        }
    }


}

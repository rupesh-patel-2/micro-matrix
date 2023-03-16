<?php 

namespace Rupesh\MicroMatrix\Utilities;

class Models {

    public static function getAllModels()
    {
        $models = [];
        $modelsPath = app_path('Models');
        $modelFiles = \File::allFiles($modelsPath);
        foreach ($modelFiles as $modelFile) {
            $models[] = '\App\\Models\\' . $modelFile->getFilenameWithoutExtension();
        }
        return $models;
    }
}
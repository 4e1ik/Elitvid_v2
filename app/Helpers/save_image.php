<?php

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

function save_image($file, $image)
{
//            $name = $file->getClientOriginalName();
//
//            $tmp_name = explode('.', $name);
//
//            $img_names_arr = $image->pluck('image');
//
//            $img_names_arr_explode = [];
//            $i = 0;
//
//            foreach ($img_names_arr as $img_name_item) {
//
//                $img_names_arr_explode[] = explode('/', $img_name_item)[1];
//            }
//            foreach ($img_names_arr_explode as $img_names_arr_explode_item) {
//
//                if (str_contains($name, $img_names_arr_explode_item)) {
//
//                    $i++;
//                    $name = $tmp_name[0] . '(' . $i . ').' . $tmp_name[1];
//
//                    if (in_array($name, $img_names_arr_explode)) {
//
//                        while (in_array($name, $img_names_arr_explode)) {
//                            $i++;
//                            $name = $tmp_name[0] . '(' . $i . ').' . $tmp_name[1];
//                        }
//                    }
//                }
//            }
//
//            return $name;


    $name = $file->getClientOriginalName();
    $extension = $file->getClientOriginalExtension();

    // Хешируем имя файла
    $hashedName = hash('md5', $name). '.' . $extension;

//    dd($hashedName);

    // Проверяем наличие совпадений в базе данных
    $tmp_arr = [];
    $existingImages = $image->pluck('image')->toArray();
    foreach ($existingImages as $existingImage) {
        $tmp_name = explode('/', $existingImage);
        $tmp_arr[] = end($tmp_name);
    }

//    dd($tmp_arr);
    $i = 1;
    while (in_array($hashedName, $tmp_arr)) {
        $i++;
        $hashedName = hash('md5', $name . '(' . $i . ')') . '.' . $extension;
    }

    return $hashedName;
}

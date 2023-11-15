<?php

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

function save_image($request)
{
    if ($request->hasFile('image')) {
        foreach ($request->file('image') as $file) {

            $name = $file->getClientOriginalName();

            $tmp_name = explode('.', $name);

            $img_names_arr = Image::query()->pluck('image');

            $img_names_arr_explode = [];
            $i = 0;

            foreach ($img_names_arr as $img_name_item) {

                $img_names_arr_explode[] = explode('/', $img_name_item)[1];
            }
            foreach ($img_names_arr_explode as $img_names_arr_explode_item) {

                if (str_contains($name, $img_names_arr_explode_item)) {

                    $i++;
                    $name = $tmp_name[0] . '(' . $i . ').' . $tmp_name[1];

                    if (in_array($name, $img_names_arr_explode)) {

                        while (in_array($name, $img_names_arr_explode)) {
                            $i++;
                            $name = $tmp_name[0] . '(' . $i . ').' . $tmp_name[1];
                        }
                    }
                }
            }

            $path = Storage::putFileAs('images', $file, $name); // Даем путь к этому файлу
            $data['image'] = $path;
            Image::create($data);
        }
    }
}

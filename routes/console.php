<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('write', function () {
    sleep(5);
    $text = "\techo haha it\\can!";
    //$text = "PHPFile::in('database/migrations')";
    $text = file_get_contents('app/User_small.php');
    $text = str_replace('    ', '___TAB___', $text);

    $delimiter = 'super_unique_delimiter';

    $replacements = [
        "___TAB___" => '___TAB___' ,
        ' ' => '___SPACE___' ,
        '\\' => '___BACKSLASH___',
        "'" => '___SINGLE_QUOTE___',
        '"' => '___DOUBLE_QUOTE___',
        PHP_EOL => '___NEW_LINE___',
    ];
    
    $packed = collect($replacements)->map(function($item, $key) {
        return ['old' => $key, 'new' => $item];
    });

    // ['h','e','l','l','o','___SPACE___','w','o','r','l','d']
    $parts = $packed->reduce(function($carry, $item) use($delimiter) {
        return collect($carry)->map(function($string) use($item, $delimiter) {
            return explode($delimiter, 
                collect(explode($item['old'], $string))
                    ->join($delimiter . $item['new'] . $delimiter)
            );    
        })->flatten();
    }, [$text])->filter();

    // $parts = $parts->map(function($part) use($replacements) {
    //     return collect($replacements)->contains($part) ? $part : str_split($part);
    // })->flatten();

    $parts->each(function($keystroke) use($replacements) {
        if(collect($replacements)->contains($keystroke)) {
            //usleep(10);
            return exec("osascript scpt/$keystroke.scpt");
        }

        return exec("osascript scpt/___NON_SPECIAL_CHAR___.scpt '$keystroke'");
    });

})->describe('Write your code :)');

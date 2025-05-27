<?php

namespace App\Traits;

trait LoadsSeederData
{
    // 指定したJSONファイルからデータを読み込む
    protected function loadData(string $path): array
    {
        $fullPath = database_path("data/{$path}");

        if (!file_exists($fullPath)) {
            throw new \RuntimeException("Seeder data file not found: {$path}");
        }

        return json_decode(file_get_contents($fullPath), true);
    }

    // 指定ディレクトリ内のすべてのJSONファイルからデータを読み込む
    protected function loadAllDataFromDirectory(string $directory): array   
    {
        $data = [];
        $fullPath = database_path("data/{$directory}");

        if (!is_dir($fullPath)) {
            throw new \RuntimeException("Directory not found: {$directory}");
        }

        $files = glob("{$fullPath}/*.json");

        foreach ($files as $file) {
            $fileData = json_decode(file_get_contents($file), true);
            $data = array_merge($data, $fileData);
        }

        return $data;
    }
}

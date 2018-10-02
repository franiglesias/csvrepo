<?php

namespace TalkingBit\BddExample\FileReader;

use TalkingBit\BddExample\VO\FilePath;

class CSVFileReader implements FileReader
{
    public function readFrom(FilePath $filePath): array
    {
        $data = [];
        $csvFile = fopen($filePath->path(), 'r');
        $headers = fgetcsv($csvFile);
        while ($row = fgetcsv($csvFile)) {
            $data[] = array_combine($headers, $row);
        }
        if (empty($data) && $headers) {
            return [$headers];
        }
        return $data;
    }
}

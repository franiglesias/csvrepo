<?php

namespace spec\TalkingBit\BddExample\FileReader;

use PhpSpec\ObjectBehavior;
use TalkingBit\BddExample\FileReader\FileReader;
use TalkingBit\BddExample\VO\FilePath;

class CSVFileReaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FileReader::class);
    }

    public function it_should_read_a_file_with_one_line(FilePath $filePath)
    {
        $pathToFile = '/var/tmp/one_line_file.csv';
        $data = <<< EOD
101,10
EOD;

        touch('' . $pathToFile);
        file_put_contents($pathToFile, $data);
        $filePath->path()->willReturn($pathToFile);
        $this->readFrom($filePath)->shouldHaveCount(1);
        unlink($pathToFile);
    }

    public function it_should_read_csv_files_with_headers_and_data(FilePath $filePath)
    {
        $pathToFile = '/var/tmp/headers_and_data_file.csv';
        $data = <<< EOD
id,price
101,10
102,14
EOD;

        $expected = [
            [
                'id' => '101',
                'price' => '10'
            ],
            [
                'id' => '102',
                'price' => '14'
            ]
        ];

        touch($pathToFile);
        file_put_contents($pathToFile, $data);
        $filePath->path()->willReturn($pathToFile);
        $this->readFrom($filePath)->shouldHaveCount(2);
        $this->readFrom($filePath)->shouldBe($expected);
        unlink($pathToFile);
    }
}

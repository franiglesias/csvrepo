<?php

namespace spec\TalkingBit\BddExample\FileReader;

use TalkingBit\BddExample\FileReader\CSVFileReader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use TalkingBit\BddExample\FileReader\FileReader;

class CSVFileReaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FileReader::class);
    }
}

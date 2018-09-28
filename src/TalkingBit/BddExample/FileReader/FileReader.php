<?php

namespace TalkingBit\BddExample\FileReader;

use TalkingBit\BddExample\VO\FilePath;

interface FileReader
{
    public function readFrom(FilePath $filePath): array;
}

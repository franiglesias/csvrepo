<?php

namespace TalkingBit\BddExample\VO;

use RuntimeException;

class FilePath
{
    /** @var string */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function path(): string
    {
        if (! file_exists($this->path)) {
            throw new RuntimeException('File not found at ' . $this->path);
        }

        return $this->path;
    }
}

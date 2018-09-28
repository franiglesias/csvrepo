<?php

namespace TalkingBit\BddExample\VO;

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
        return $this->path;
    }
}

<?php

namespace spec\TalkingBit\BddExample\VO;

use TalkingBit\BddExample\VO\FilePath;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilePathSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FilePath::class);
    }
}

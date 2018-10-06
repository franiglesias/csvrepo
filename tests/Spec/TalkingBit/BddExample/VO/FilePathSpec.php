<?php

namespace Spec\TalkingBit\BddExample\VO;

use PhpSpec\ObjectBehavior;
use TalkingBit\BddExample\VO\FilePath;

class FilePathSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $path = '/var/tmp/file_with.data';
        touch($path);
        $this->beConstructedWith($path);
        $this->shouldHaveType(FilePath::class);
        $this->path()->shouldEqual($path);
    }

    public function it_should_fail_if_there_is_not_file_in_the_path()
    {
        $path = '/var/tmp/no_existent.data';
        touch($path);
        $this->beConstructedWith($path);
        unlink($path);
        $this->shouldThrow(\RuntimeException::class)->duringPath();
    }
}

<?php

namespace spec\App\Libraries;

use App\Libraries\HelpersLibrary;
use PhpSpec\ObjectBehavior;

class HelpersLibrarySpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(HelpersLibrary::class);
    }

    function it_formats_errors()
    {
        $this->showJsonError("Critical error")->shouldReturn('{"status":false,"error":"Server Error","message":"Critical error"}');
    }

    /*function it_sends_messages()
    {
        $this->sendQueueMessage("testkey-4","{data}",'testchannel')->shouldReturn(true);
    }*/

}

<?php

namespace spec\App\Libraries;

use App\Libraries\QuoteLibrary;
use PhpSpec\ObjectBehavior;

class QuoteLibrarySpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(QuoteLibrary::class);
    }

    function it_returns_clean_names()
    {
        $this->getCleanName("Steve Jobs")->shouldReturn("steve-jobs");
        $this->getCleanName("Steve-Jobs")->shouldReturn("steve-jobs");
        $this->getCleanName("NORMAN FOSTER")->shouldReturn("norman-foster");
    }

    function it_returns_a_valid_key()
    {
        $this->getKeyName("steve-jobs",4)->shouldReturn("steve-jobs-4");
        $this->getKeyName("norman-foster",14)->shouldReturn("norman-foster-14");
        $this->getKeyName("bob-marley",9,'rabbitmq')->shouldReturn("bob-marley*9");
    }

    function it_shouts_the_quote()
    {
        // Simulating that SHOUT_QUOTE is true
        $this->processQuote(
          "Life isn’t about getting and having, it’s about giving and being."
        )->shouldReturn(
          "LIFE ISN´T ABOUT GETTING AND HAVING, IT´S ABOUT GIVING AND BEING!"
        );
        $this->processQuote(
          "Your time is limited, so don’t waste it living someone else’s life!"
        )->shouldReturn(
          "YOUR TIME IS LIMITED, SO DON´T WASTE IT LIVING SOMEONE ELSE´S LIFE!"
        );
        $this->processQuote(
          "The best revenge is massive success", true, true
        )->shouldReturn(
          "THE BEST REVENGE IS MASSIVE SUCCESS!"
        );
    }

}

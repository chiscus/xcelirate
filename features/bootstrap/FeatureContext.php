<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    protected $author;
    protected $limit;
    protected $response;

    public function __construct()
    {
    }

    /**
     * @Given that the user didn't input an author
     */
    public function thatTheUserDidntInputAnAuthor()
    {
        $this->author = "";
        $this->limit = 1;
    }

    /**
     * @When the user requested the list from :arg1
     */
    public function theUserRequestedTheListFrom($arg1)
    {
        $client = new GuzzleHttp\Client(['base_uri' => $arg1]);

        $this->response = $client->get('/shout/'.$this->author.'?limit='.$this->limit);

        if($this->response->getStatusCode() != 200){
          throw new \Exception("Error Processing Request", 1);
        }
    }

    /**
     * @Then the result should be an error message
     */
    public function theResultShouldBeAnErrorMessage()
    {
        $responseBody = $this->response->getBody();

        if(!strpos($responseBody, 'Server Error')){
          throw new \Exception("Incorrect data", 1);
        }
    }

    /**
     * @Given that the user asked for more than :arg1 quotes from an author
     */
    public function thatTheUserAskedForMoreThanQuotesFromAnAuthor($arg1)
    {
        $this->author = "steve";
        $this->limit = 12;
    }

    /**
     * @When the user requested the data from :arg1
     */
    public function theUserRequestedTheDataFrom($arg1)
    {
        $client = new GuzzleHttp\Client(['base_uri' => $arg1]);

        $this->response = $client->get('/shout/'.$this->author.'?limit='.$this->limit);

        if($this->response->getStatusCode() != 200){
          throw new \Exception("Error Processing Request", 1);
        }
    }

    /**
     * @Then the result must be an error
     */
    public function theResultMustBeAnError()
    {
        $responseBody = $this->response->getBody();

        if(!strpos($responseBody, 'Server Error')){
          throw new \Exception("Incorrect data", 1);
        }
    }

    /**
     * @Given that the user asked for less than :arg1 quotes from an author
     */
    public function thatTheUserAskedForLessThanQuotesFromAnAuthor($arg1)
    {
        $this->limit = 4;
    }

    /**
     * @Given the user asked for a known author
     */
    public function theUserAskedForAKnownAuthor()
    {
        $this->author = "john lennon";
    }

    /**
     * @When the user requested the result from :arg1
     */
    public function theUserRequestedTheResultFrom($arg1)
    {
        $client = new GuzzleHttp\Client(['base_uri' => $arg1]);

        $this->response = $client->get('/shout/'.$this->author.'?limit='.$this->limit);

        if($this->response->getStatusCode() != 200){
          throw new \Exception("Error Processing Request", 1);
        }
    }

    /**
     * @Then the result should be a list of quotes from the database
     */
    public function theResultShouldBeAListOfQuotesFromTheDatabase()
    {
        $responseBody = $this->response->getBody();

        if(count(json_decode($responseBody)) < 1){
          throw new \Exception("Error Processing Request", 1);
        }
    }

    /**
     * @Then the quotes should be shouted with capital letters and exclamation marks
     */
    public function theQuotesShouldBeShoutedWithCapitalLettersAndExclamationMarks()
    {
        $responseBody = $this->response->getBody();

        $json = json_decode($responseBody);
        $string = $json[0]->quote;
        $string = preg_replace("/[^a-zA-Z0-9]+/", "", $string);

        if(!ctype_upper($string)){
          throw new \Exception("Error Processing Request", 1);
        }
    }

}

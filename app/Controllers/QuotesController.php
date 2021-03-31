<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\QuoteLibrary;
use App\Libraries\HelpersLibrary;

class QuotesController extends ResourceController
{

	// Referenced the QuotesModel to work with it
	protected $modelName = 'App\Models\QuotesModel';
	protected $format = 'json';

	public $maxLimit 			= 10;
	public $showMessages 	= false;

	public function index()
	{
		// Show all entries in Database
		//return $this->respond($this->model->findAll());
		$helpersLibrary = new HelpersLibrary();
		return $this->respond($helpersLibrary->showJsonError('An author must be given!'));
	}

	public function show($nameURI = null)
	{
		$quoteLibrary 	= new QuoteLibrary();
		$helpersLibrary = new HelpersLibrary();

		// Verify the limit of the query. Set to 10 if null
		$limit = $this->request->getVar('limit');
		if(!$limit) $limit = $this->maxLimit;
		if($limit > $this->maxLimit) return $this->respond($helpersLibrary->showJsonError('Limit cannot be more than ' . $this->maxLimit . '!'));

		// Get the curated version of the full name
		//$queryName = getCleanName($nameURI);
		$queryName = $quoteLibrary->getCleanName($nameURI);

		// Generate the key value for the cache
		$cacheKeyName = $quoteLibrary->getKeyName($queryName, $limit);

		// Check if there is a key on Redis for this author and number of quotes
		if (!$shoutedQuotes = cache($cacheKeyName)){
		    if($this->showMessages) echo 'Saving to the cache!';

				// Separate full name
			  $queryNameArray = explode('-', $queryName);

				// Search for the all the names with AND clause
				// With this method, the name and surname can be reversed
				foreach ($queryNameArray as $authorName) {
					$this->model->like('author', $authorName);
				}

				$foundQuotes = $this->model->findAll($limit);

				// Make capital letters and add !
				foreach ($foundQuotes as $key => $quote) {
					$foundQuotes[$key]['quote'] = $quoteLibrary->processQuote($quote['quote']);
				}

				// Send petition to the MessageController to cache this data
				$helpersLibrary->sendQueueMessage($cacheKeyName, $foundQuotes, 'redis_messages');
		}else{
				if($this->showMessages) echo 'Retrieving from the cache!';
				// Get data from Redis
				$foundQuotes = cache()->get($cacheKeyName);
		}

		return $this->respond($foundQuotes);
	}

	public function new()
	{
		//
	}

	public function create()
	{
		//
	}

	public function edit($id = null)
	{
		//
	}

	public function update($id = null)
	{
		//
	}

	public function delete($id = null)
	{
		//
	}

}

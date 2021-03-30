<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\QuoteLibrary;
use App\Libraries\HelpersLibrary;

class QuotesController extends ResourceController
{

	// Attached the QuotesModel to work with it
	protected $modelName = 'App\Models\QuotesModel';
	protected $format = 'json';

	public $maxLimit 		= 10;
	public $shouldShout = true;

	public function __construct()
	{
		// Created constructor to globally access our helpers
		helper(['json_error', 'quotes_processor', 'post_curl', 'message', 'query_limit']);
	}

	public function index()
	{
		// Sholl all entries in Database
		return $this->respond($this->model->findAll());
	}

	public function show($nameURI = null)
	{
		$quoteLibrary 	= new QuoteLibrary();
		$helpersLibrary = new HelpersLibrary();

		// Verify the limit of the query
		$limit = $this->request->getVar('limit');
		if($limit > $this->maxLimit) return $this->respond($helpersLibrary->showJsonError('Limit cannot be more than ' . $this->maxLimit . '!'));

		// Get the curated version of the full name
		//$queryName = getCleanName($nameURI);
		$queryName = $quoteLibrary->getCleanName($nameURI);

		// Generate the key value for the cache
		$cacheKeyName = $quoteLibrary->getKeyName($queryName, $limit);

		// Check if there is a key on Redis for this author and number of quotes
		if (!$shoutedQuotes = cache($cacheKeyName)){
		    if(SHOW_REDIS_MSGS) echo 'Saving to the cache!';

				// Separate full name
			  $queryNameArray = explode('-', $queryName);

				// Search for the all the names with AND clause
				// With this method, the name and surname can be reversed
				foreach ($queryNameArray as $authorName) {
					$this->model->like('author', $authorName);
				}

				$foundQuotes = $this->model->findAll($limit);

				// Make capital letters and add ! if SHOUT_QUOTE constant is true
				foreach ($foundQuotes as $key => $quote) {
					$foundQuotes[$key]['quote'] = $quoteLibrary->processQuote($quote['quote']);
				}

				// Send petition to the MessageController to cache this data
				$helpersLibrary->sendQueueMessage($cacheKeyName, $foundQuotes, 'redis_messages');
		}else{
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

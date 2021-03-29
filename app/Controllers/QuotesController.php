<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class QuotesController extends ResourceController
{
	/**
	 * Return an array of resource objects, themselves in array format
	 *
	 * @return mixed
	 */

	protected $modelName = 'App\Models\QuotesModel';
	protected $format = 'json';

	public function __construct()
	{
		// Created constructor to globally access the new helper
		helper('json_error');
		helper('quotes_processor');
		helper('clean_names');
	}

	public function index()
	{
		//
		return $this->respond($this->model->findAll());
	}

	/**
	 * Return the properties of a resource object
	 *
	 * @return mixed
	 */
	public function show($name = null)
	{
		// Verify that the limit is under 10
		$limit = $this->request->getVar('limit');
		if($limit > 10) return $this->respond(show_json_error('Limit cannot be more than 10!'));

		// Get the curated version of the full name
		$queryName = clean_names($name);

		// Search for the all the names with AND clause
		// With this method, the name and surname can be reversed
		foreach ($queryName as $authorName) {
			$this->model->like('author', $authorName);
		}

		$foundQuotes = $this->model->findAll($limit);

		$shoutedQuotes = process_quotes($foundQuotes);

		return $this->respond($shoutedQuotes);
	}

	/**
	 * Return a new resource object, with default properties
	 *
	 * @return mixed
	 */
	public function new()
	{
		//
	}

	/**
	 * Create a new resource object, from "posted" parameters
	 *
	 * @return mixed
	 */
	public function create()
	{
		//
	}

	/**
	 * Return the editable properties of a resource object
	 *
	 * @return mixed
	 */
	public function edit($id = null)
	{
		//
	}

	/**
	 * Add or update a model resource, from "posted" properties
	 *
	 * @return mixed
	 */
	public function update($id = null)
	{
		//
	}

	/**
	 * Delete the designated resource object from the model
	 *
	 * @return mixed
	 */
	public function delete($id = null)
	{
		//
	}
}

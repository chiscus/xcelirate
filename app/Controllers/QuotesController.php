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
		//

		// Verify that the name is separated by dashes
		$queryName = strpos($name, ' ') ? str_replace(' ', '-', $name) : $name;
		// Verify that the name is lower case
		$queryName = strtolower($queryName);
		// Separate full name
		$queryName = explode('-', $queryName);

		// Search for the all the names with AND clause
		// With this method, the name and surname can be reversed
		foreach ($queryName as $searchName) {
			$this->model->like('author', $searchName);
		}
		return $this->respond($this->model->findAll());
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

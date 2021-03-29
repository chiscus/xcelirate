<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class QuoteSeeder extends Seeder
{
	public function run()
	{
		//
		$model = model('QuotesModel');
		$json = file_get_contents('data/quotes.json');
		$json_data = json_decode($json);

		foreach ($json_data->quotes as $obj) {
			$model->insert([
				'quote' => $obj->quote,
				'author' => $obj->author
			]);
		}
	}
}

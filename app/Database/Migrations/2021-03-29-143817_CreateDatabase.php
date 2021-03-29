<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDatabase extends Migration
{
	public function up()
	{
		// Check if database exists before creating it
		if ($this->forge->createDatabase('awesomequotesapi', true))
		{
				echo 'Database created!';
		}
	}

	public function down()
	{
		//
		if ($this->forge->dropDatabase('awesomequotesapi'))
		{
				echo 'Database deleted!';
		}
	}
}

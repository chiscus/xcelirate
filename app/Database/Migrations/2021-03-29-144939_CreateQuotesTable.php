<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuotesTable extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'id'          => [
        'type'           => 'INT',
        'constraint'     => 5,
        'unsigned'       => true,
        'auto_increment' => true,
      ],
			'quote'          => [
				'type'       => 'TEXT',
        'null' 			 => false,
      ],
      'author'       => [
        'type'       => 'VARCHAR',
        'constraint' => '50',
      ],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('quotes');
	}

	public function down()
	{
		//
		if ($this->forge->dropTable('quotes', true))
		{
				echo 'Quotes table deleted!';
		}
	}
}

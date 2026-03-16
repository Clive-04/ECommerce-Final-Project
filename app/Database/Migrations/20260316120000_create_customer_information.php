<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomerInformation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => false,
            ],
            'phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'street_address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'state_province' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('customer_information', true);
    }

    public function down()
    {
        $this->forge->dropTable('customer_information', true);
    }
}

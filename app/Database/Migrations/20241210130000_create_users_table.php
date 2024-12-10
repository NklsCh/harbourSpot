<?php
namespace app\Database\Migrations;

use CodeIgniter\Database\Migration;

class create_users_table extends Migration {
    public function up() {
        // Set the collation and character set
        $this->forge->addField("id int(11) NOT NULL AUTO_INCREMENT");
        $this->forge->addField([
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ]
        ]);

        // Add primary key
        $this->forge->addKey('id', TRUE);
        
        // Add unique key for email
        $this->forge->addKey('email', FALSE, TRUE);

        // Create the table with specific attributes
        $attributes = [
            'ENGINE' => 'InnoDB',
            'CHARACTER SET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_unicode_ci'
        ];

        $this->forge->createTable('users', TRUE, $attributes);
    }

    public function down() {
        $this->forge->dropTable('users', TRUE);
    }
}
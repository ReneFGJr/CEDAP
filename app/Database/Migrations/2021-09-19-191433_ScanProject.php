<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ScanProject extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sp' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'sp_project_nome' => [
                'type' => 'VARCHAR',
                'constraint' => '200'
            ],
            'sp_image' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
			],	
            'sp_folder' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
			],            
            'sp_description' => [
                'type' => 'TEXT',
			],	 
            'sp_own' => [
                'type' => 'INT',
			],                       
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id_sp', true);
        $this->forge->createTable('scan_projects');
    }

    public function down()
    {
        //
    }
}

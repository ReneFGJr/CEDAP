<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ScanProjectFile extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_spf' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'spf_folder_nome' => [
                'type' => 'VARCHAR',
                'constraint' => '200'
            ],
            'spf_folder_logical' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
			],	
            'spf_project' => [
                'type' => 'INT',
			],      
            'spf_status' => [
                'type' => 'INT',
                'default' => 0
			],                              
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id_spf', true);
        $this->forge->createTable('scan_projects_files');
    }

    public function down()
    {
        //
    }
}

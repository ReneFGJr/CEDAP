<?php

namespace App\Models;

use CodeIgniter\Model;

class ScanProjectFolder extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'scan_projects_files';
    protected $primaryKey           = 'id_spf';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        'id_spf','spf_folder_nome','spf_folder_logical','spf_project'
    ];

	protected $typeFields        = [
		'index',
		'st:100*#',
        'st:100*#',
        'hidden',
	];     

    // Dates
    protected $useTimestamps        = false;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = [];
    protected $afterInsert          = [];
    protected $beforeUpdate         = [];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    //d:\Projeto\ImageMagick

    function folders($id)
        {
            $this->select('count(*) as total, spf_folder_logical, spf_status, min(id_spf) as idspf');
            $this->where('spf_project',$id);
            $this->groupBy('spf_folder_logical, spf_status');
            $this->orderBy('spf_status, spf_folder_logical');
            $dt = $this->FindAll();
            $tela = h(lang('cedap.folder_workspace'),2);
            $wk = '';
            $tpx = '';
            foreach($dt as $id=>$line)
                {
                    $tp = (string)trim($line['spf_status']);
                    $fn = $this->foldername($line['spf_folder_logical']);
                    if ($tp != $tpx)
                        {
                            $tpx = $tp;
                            $wk .= bsc(h(lang('cedap.folder_status_'.$tp),4),12);
                        }
                    $wk .= bsc(
                        '<a href="'.base_url(PATH.'project/folder/'.$line['spf_status'].'/'.$line['idspf']).'">'
                        . bsicone('folder-'.$line['spf_status'],64)
                        . '<br/>' 
                        . '<span class="fw-bold">'.$fn.'</span>'
                        . '<br/>' 
                        . $line['total'].' '.lang('cedap.files')
                        . '</a>'
                        ,2
                    );
                }
            $tela = $tela.$wk;
            return $tela;            
        }
    function foldername($name)
        {
            $name = str_replace(array('\\'),array('/'),$name);
            $loop = 0;
            while(($pos = strpos($name,'/')) and ($loop < 50))
                {                    
                    $name = substr($name,$pos+1,strlen($name));
                    $loop++;
                }
            return $name;
        }

    function scan($dt)
        {
            $ScanProjectFile = new \App\Models\ScanProjectFile();
            $tela = h(lang('cedap.scanning'),1);
            $fld = $dt['sp_folder'];
            if (is_dir($fld))
                {
                    $flda = scandir($fld);
                    $tela .= '<ul>';
                    foreach($flda as $id=>$fldb)
                        {
                            if (($fldb != '.') and ($fldb != '..'))
                                {
                                    if (is_dir($fld.$fldb))
                                        {
                                            $tela .= '<li>'.$fld.$fldb.' - ';
                                            $tela .= $ScanProjectFile->scan_files($fld.$fldb,$dt['id_sp']);
                                            $tela .= ' '.lang('cedap.files');
                                            $tela .= '</li>';
                                        }
                                }
                        }
                    $tela .= '</ul>';
                } else {
                    $tela .= bsmessage(lang('Folder not exist').' - '.'['.$fld.']',3);
                }


            
            
            $tela = bs($tela);

            return $tela;
        }
}

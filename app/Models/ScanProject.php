<?php
namespace App\Models;

use B;
use CodeIgniter\Model;

class ScanProject extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'scan_projects';
    protected $primaryKey           = 'id_sp';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = ['id_sp','sp_project_nome','sp_folder','sp_image','sp_description','sp_own'];

	protected $typeFields        = [
		'index',
		'st:100*#',
        'st:100*#',
        'hidden',
		'text',
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

    function index($d1='',$d2='',$d3='')
        {
            $ScanProjectFile = new \App\Models\ScanProjectFile();
            $tela = '';
            $this->path = PATH.'project/';
            $this->path_back = PATH.'project/';

            switch($d1)
                {
                    case 'convert_jpg':
                        $tela .= $ScanProjectFile->convert_to_jpg($d2);
                        break;

                    case 'file':
                        $tela = $ScanProjectFile->viewid($d2);
                        break;

                    case 'edit':
                        $this->id=$d2;
                        $tela = form($this);
                    break;

                    case 'folder':                        
                        $tela .= $ScanProjectFile->workspace($d3);
                        break;                      
                    break;

                    case 'viewid':
                        $tela .= $this->viewid($d2,$d3);
                        $tela .= $this->viewFolders($d2);
                        break;

                    case 'scan':
                        $dt = $this->find($d2);
                        $ScanProjectFolder = new \App\Models\ScanProjectFolder();
                        $tela .= $ScanProjectFolder->scan($dt);                    
                        break;

                    default:
                        $tela = h(lang('cedap.Projects'),1);
                        $tela .= $this->projects();
                        $tela .= $this->bt_new();
                        break;
                }
            return $tela;
        }
    function projects()
        {
            $idu = $_SESSION['id'];
            $tela = tableview($this);
            return($tela);
        }
    function bt_new()
        {
            $tela = '<a href="'.base_url(PATH.'project/edit/0').'" class="btn btn-outline-primary">'.lang('cedap.new_project').'</a>';
            return $tela;
        }
    function viewFolders($id)
        {
            $ScanProjectFolder = new \App\Models\ScanProjectFolder();
            $tela = $ScanProjectFolder->folders($id);
            return $tela;
        }
    function viewid($id)
        {
            $dt = $this->find($id);
            $tela = $this->header_project($dt);
            $tela .= $this->tool_bar($dt);
            return $tela;
        }
    function header_project($dt)
        {
            $tela = '';
            $tela .= bsc(
                    '<small>'.lang('cedap.sp_project_nome').'</small><br/>'.
                    h($dt['sp_project_nome'],1)
                    ,12);
            $txt = $dt['sp_description'];
            if (strlen($txt) == 0)
                {
                    $txt = lang('no_description');
                }
            $tela .= bsc(
                    '<small>'.lang('cedap.sp_description').'</small><br/>'.
                    $txt
                    ,12);
            return $tela;
        }
    function tool_bar($dt)
        {
            $tela = bsc(
                '<a href="'.base_url(PATH.'project/scan/'.$dt['id_sp']).'">'.
                bsicone('search',64).
                '<br/>'.
                lang('cedap.scan_dir').
                '</a>'
            ,12);
            return $tela;
        }
}

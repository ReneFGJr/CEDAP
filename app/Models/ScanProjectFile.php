<?php

namespace App\Models;

use CodeIgniter\Model;

class ScanProjectFile extends Model
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

    function workspace($idf)
        {
            $dt = $this->find($idf);
            
            $status = $dt['spf_status'];
            $folder = $dt['spf_folder_logical'];

            $this->where('spf_status',$status);
            $this->where('spf_folder_logical',$folder);
            $dt = $this->findAll();

            $tela = '';
            foreach($dt as $id=>$line)
                {
                    $link = '<a href="'.base_url(PATH.'project/file/'.$line['id_spf']).'">';
                    $linka = '</a>';
                    $tela .= bsc($link.$this->works($line).$linka,2);
                }
            return bs($tela);
        }
    function works($dt)
        {
            $tela = '<img src="'.$this->thumbnail($dt).'" class="img-thumbnail">';
            $name = $dt['spf_folder_nome'];
            $tela = bscard($tela,$name);
            return $tela;
        }
    function convert_to_jpg($id)
        {
            $tela = '';
            $line = $this->find($id);
            $file_name_in = $line['spf_folder_logical'].'/'.$line['spf_folder_nome'];
            $file_inf = pathinfo($file_name_in);
            $file_name_out = $file_inf['filename'].'.jpg';
            $file_name_out = $line['spf_folder_logical'].'/destinity/'.$file_name_out;

            if (($file_inf['extension'] == 'tiff') and (!file_exists($file_name_out)))
                {
                dircheck($line['spf_folder_logical'].'/destinity');
                $cmd = getenv('CONVERT').' '.$file_name_in.' ' .$file_name_out;
                $tela = shell_exec($cmd);
                }
            return $tela;
        }

    function is_thumbnail($dt)
        {
            $mini = $dt['spf_folder_logical'].'/thumbnail/';
            $mini .= $dt['spf_folder_nome'];
            $mini .= '.jpg';
            if (!file_exists($mini))
                { return false; }
            return true;
        }
    function is_destinity($dt)
        {
            $mini = $dt['spf_folder_logical']. '/'. $dt['spf_folder_nome'];
            if (!file_exists($mini))
                { 
                    $file_inf = pathinfo($mini);
                    $file = $file_inf['dirname'].'/'.'destinity/'.$file_inf['filename'].'.jpg';
                    echo $file.'<br>';
                    if (!file_exists($file))
                        {
                            return false;
                        } else {
                            return true;
                        }
                }
            return true;
        }        
    function image($id,$tp=0)
        {
            $dt = $this->find($id);            
            switch($tp)
                {
                    case '1':
                        $file = $dt['spf_folder_logical'].'/';
                        $file .= $dt['spf_folder_nome'];
                        
                        if (is_file($file))
                            {
                                $file_inf = pathinfo($file);
                                $file = $file_inf['dirname'].'/'.'destinity/'.$file_inf['filename'].'.jpg';
                            }
                        break;
                    default:
                        $file = $dt['spf_folder_logical'].'/thumbnail/';
                        $file .= $dt['spf_folder_nome'];
                        $file .= '.jpg';
                        break;

                }

            if (!file_exists($file))
                {
                    $file = 'img/no_image/thumbnail.jpg';
                }
            header("Content-Type: image/jpeg");
            header("Content-Length: " . filesize($file));
            readfile($file);
            exit;
        }
    function thumbnail($dt)
        {
            $tela = 'ni';
            $mini = $dt['spf_folder_logical'].'/thumbnail/';
            $name = trim($dt['spf_folder_nome']);
            $name = troca($name,'.tiff','.jpg');
            if (file_exists($mini))
                {
                    $tela = base_url(PATH.'image/'.$dt['id_spf'].'/0/mini.jpg');
                } else {
                    $tela = base_url(PATH.'image/'.$dt['id_spf'].'/0/mini.jpg');
                }
            return $tela;
        }

    function thumbnail_create($id)
        {
           $line = $this->find($id);
           $tela = '';
           $thumbnail = $line['spf_folder_logical'].'/thumbnail';
           dircheck($thumbnail);            
           $file_name_in = $line['spf_folder_logical'].'/'.$line['spf_folder_nome'];
           $file_name_out = $thumbnail.'/'.$line['spf_folder_nome'].'.jpg';
           $cmd = getenv('CONVERT').' -define jpeg:size=200x200 '.$file_name_in.' -thumbnail 200 '.$file_name_out;
           $tela .= 'CMD: '.$cmd.'<br>';
           $tela = shell_exec($cmd);      
           
           if (!file_exists($file_name_out))
            {
                $tela .= 'STATUS: <span style="color: red">'.'ERRO'.'</span>';
            } else {
            }
           return $tela;
        }   

    function viewImages($id)
        {
            $dt = $this->find($id);

            /*******************************************************************************/
            if ($this->is_destinity($dt))
                {
                    $file_name_in = $dt['spf_folder_logical'].'/'.$dt['spf_folder_nome'];
                    $file_inf = pathinfo($file_name_in);
                    $name = $file_inf['dirname'].'/destinity/'.$file_inf['filename'].'.jpg';
                    $tela = '<h1>'.$name.'</h1>';
                    if (file_exists($name))
                        {
                            $url = base_url(PATH.'image/'.$dt['id_spf'].'/1/mini.jpg');
                            $tela .= '<img src="'.$url.'" class="img-fluid">';
                        }
                    
                } else {
                    $tela = '';
                }            
            return $tela;            
        }

    function viewid($id)
        {
            /**************************************** ACOES */
            $act = get("act");
            $msg = '';
            if ($act != '') { $msg = bsc($this->actions($id,$act),12); }

            /******************************************************** NORMAL ****************/
            $tela = '';
            $dt = $this->find($id);           

            /***************************************** Verificar arquivo *********************/
            $file_name = $dt['spf_folder_logical'].'/'.$dt['spf_folder_nome'];
            $prop = pathinfo($file_name); 
            $ext = $prop['extension'];
            /******************************************************** Mostra na Tela *********/
            $tela .= h($prop['filename'],1);
            $tela .= '<div>'.lang('cedap.extension').': '.$ext.'</div>'.cr();
            $tela .= '<div>'.lang('cedap.dirname').': '.$prop['dirname'].'</div>'.cr();
            $tela .= '<div>'.lang('cedap.basename').': '.$prop['basename'].'</div>'.cr();
            $tela .= '<div>'.lang('cedap.filename').': '.$prop['filename'].'</div>'.cr();

            $img = '<img src="'.$this->thumbnail($dt).'" class="img-thumbnail">';

            $tela = bsc($tela,9).bsc($img,3);

            /***************************************************** ACtions *****************/
            $act = $msg;
            if (!$this->is_destinity($dt))
            {
                $act .= bsc('<a href="'.base_url(PATH.'project/file/'.$id.'?act=tiff_jpg').'" class="btn btn-outline-primary">'.lang('cedap.file_to_jpg').'</a>',2);                
            }
            if (!$this->is_thumbnail($dt))
            {
                $act .= bsc('<a href="'.base_url(PATH.'project/file/'.$id.'?act=thumbnail_create').'" class="btn btn-outline-primary">'.lang('cedap.thumbnail_create').'</a>',2);            
            }
            $tela .= bs($act);
            return bs($tela);
        }  

    function actions($id,$act)
        {
            switch($act)
                {
                    case 'tiff_jpg':
                        $tela = $this->convert_to_jpg($id);
                        $tela = $this->thumbnail_create($id);
                        break;
                    case 'thumbnail_create':
                        $tela = $this->thumbnail_create($id);
                        break;
                    default:
                    $tela = bsmessage('OPS - '.$act,3);
                }
            return $tela;
        }

    

    function scan_files($fld,$idp)
        {
            $flda = scandir($fld);
            $tot = 0;
            foreach($flda as $id=>$file_name)
                {
                    if (($file_name != '.') and ($file_name != '..'))
                        {                    
                        $file = $fld.'/'.$file_name;
                        if (file_exists($file) and (!is_dir($file)))
                            {
                                $tot++;
                                $this->where('spf_folder_nome',$file_name);
                                $this->where('spf_folder_logical',$fld);
                                $this->where('spf_project',$idp);
                                $dt = $this->FindAll();
                                
                                if (count($dt) == 0)
                                {
                                    $data['spf_folder_nome'] = $file_name;
                                    $data['spf_folder_logical'] = $fld;
                                    $data['spf_project'] = $idp;
                                    $this->insert($data);
                                }
                            }
                        }
                }
            return $tot;
        }    
}

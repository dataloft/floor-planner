<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Files extends CI_Controller {

    protected $start_folder = 'public';
    protected $path = '';

	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');
        $this->load->helper('file');
        $this->load->helper('url');
	}

	public function index() {
   		if(!$this->ion_auth->logged_in()) {
			redirect('admin', 'refresh');
		}
		$data['menu'] = array();
		$data['main_menu'] = 'files';
		$data['usermenu'] = array();
		$data['result'] = array();
        $data['message'] = array();
        $this->path = '';
        if (count($segments = $this->uri->segment_array()) > 2)
        {
            for ($i = 3; $i <= count($segments); $i++)
            {
                if ($segments[$i] === "." || $segments[$i] === ".." || $segments[$i] === "") continue;
                $this->path.= $segments[$i].DIRECTORY_SEPARATOR;
            }
        }

        $dir = $this->getCurrentDir($this->path);


        if (!is_dir($dir))
            $data['message'] = array(
                'msg_type' => 'danger',
                'text' => 'Каталог не найден'
            );
        try {
            $arr = $this->readdir($dir);
        } catch (Exception $e) {
            $arr = array();
            $data['message'] = array(
                'msg_type' => 'danger',
                'text' => 'Не удалось прочитать каталог'
            );
        }
        if (!empty($arr))
        foreach ($arr as $item) {

            if ($item === "." || $item === "..") continue;

            $label = basename($item);
            //echo $item;
            $path =  preg_replace("/".$this->start_folder."\//", '', (ltrim($item,'/')),1);
            $isLink = is_link($path);
            if (is_dir($item)) {
                $data['result'][] = array(
                    'type' => 'dir',
                    'isLink' => $isLink,
                    'path' => $path,
                    'label' => $label,
                    'extension' => '-',
                    'url' => '/admin/files/'.$path
                );
            } else {
                $size = @filesize($item);
                if ($size === false) {
                    $intsize = 0;
                    $size = 'N/A';
                } else if ($size < 0) {
                    $intsize = 0;
                    $size = '> 1Гb';
                } else {
                    $intsize = $size;
                    $size = number_format($size, 0, ' ', ' ');
                }
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                if (empty($extension)) $extension = '-';
                $data['result'][] = array(
                    'type' => 'file',
                    'isLink' => $isLink,
                    'path' => $path,
                    'label' => $label,
                    'size' => $size,
                    'intsize' => $intsize,
                    'extension' => $extension,
                );
            }
        }
        else
        {
            $data['result']=array();
            if(empty($data['message']))
                $data['message'] = array(
                'msg_type' => 'warning',
                'text' => 'Каталог пуст'
            );
        }
        $upDir = ltrim(ltrim(dirname($dir),$this->start_folder),"/");
        if ($upDir == '' || $upDir == '.')
            array_unshift($data['result'], array('type' => 'up', 'path' => '', 'label' => 'Вверх', 'url' => '/admin/files'));
        else
            array_unshift($data['result'], array('type' => 'up', 'path' => $upDir, 'label' => 'Вверх', 'url' => '/admin/files/'.$upDir));

        // Создаем путь (хлебные крошки)
        $currDir = preg_replace("/".$this->start_folder."/",'',rtrim($this->getCurrentDir($this->path), '\\/'),1);

        $currExplodedDir = preg_split('#\\\\|/#', $currDir);
        if (isset($currExplodedDir[0]) && $currExplodedDir[0] == '') $currExplodedDir[0] = DIRECTORY_SEPARATOR; //FIX для UNIX
        $data['path'] = array();
        $url = '';
        foreach ($currExplodedDir as $value) {
            if ($value != DIRECTORY_SEPARATOR) {
                $url .= ($value . DIRECTORY_SEPARATOR);
            } else {
                $url = DIRECTORY_SEPARATOR;
                $value = 'Files';
            }
            $data['path'][] = array('text' => $value, 'url' => ltrim($url,'/'));
        }

		$this->load->view('admin/header', $data);
		$this->load->view('admin/files/list', $data);
		$this->load->view('admin/footer', $data);
	}
	
	public function edit($id = '') {
		
		
	}

    protected function getCurrentDir($folder = '')
    {
       return ($this->uri->segment(3)) ? $this->start_folder.DIRECTORY_SEPARATOR.$folder : $this->start_folder;
    }

    public static function readdir($dir, $onlyDirs = false)
    {
        if (!is_dir($dir))
        {
             $data['message'] = array(
                'msg_type' => 'danger',
                'text' => 'Каталог не найден'
            );
            return false;

        } //TODO: Сообщение об ошибке.

        if (!preg_match('#[\\\\/]$#u', $dir)) {
            $dir .= DIRECTORY_SEPARATOR;
        }
        if ($handle = opendir($dir)) {
            $dirs = $files = array();
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    $file = $dir . $file;
                    if (is_dir($file)) {
                        $dirs[] = $file . DIRECTORY_SEPARATOR;
                    } else {
                        $files[] = $file;
                    }
                }
            }
            closedir($handle);
            sort($dirs);
            sort($files);
            if ($onlyDirs) {
                return $dirs;
            } else {
                return array_merge($dirs, $files);
            }
        } else {
         $data['message'] = array(
                'msg_type' => 'danger',
                'text' => 'Не удалось открыть каталог'
            ); //TODO: Сообщение об ошибке.
            return false;
        }
    }
	
}

/* End of file page.php */
/* Location: ./application/controllers/page.php */
<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    public $method;
    public $controller;
    public $csss = [];
    public $jss = [];
    public $frontVersion = 1;
    public $user;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        $this->db = \Config\Database::connect();

        $router = service('router');
        $this->controller  = preg_replace("#.App.Controllers.#", '', $router->controllerName());
        $this->method = $router->methodName();
        $session = session();
        $this->user = (object)[
            'id' => $session->get('user_id'),
            'name' => $session->get('user_name')
        ];

        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }


    //codeigniter 3
    public function validar($fields)
    {
        $data = array();
        foreach ($this->request->getPost() as $key => $val) {
            if (!isset($fields[$key])) continue;
            if ($fields[$key]->required == true) {
                if ($fields[$key]->type != 'bit' && strlen($val) <= 0) $this->dieMsg(false, "Campo requerido : " . $fields[$key]->label);
            }
            if (in_array($fields[$key]->type, array('text', 'varchar', 'url', 'email', 'fore', 'decimal', 'int', 'enum'))) {
                $data[$key] = $this->request->getPost($key);
                if ($fields[$key]->type == 'int' && empty($val)) $data[$key] = null;
            } else if ($fields[$key]->type == 'date') {
                $data[$key] = dateToMysql($val);
            } else if ($fields[$key]->type == 'bit') {
                $data[$key] = $this->request->getPost($key) == '1' ? 1 : 0;
            }
        }
        return $data;
    }

    //codeigniter 3
    public function guardar_imagen($folder, $name)
    {
        $config['upload_path']          = FCPATH . $folder;
        $config['allowed_types']        = 'jpg|png|jfif';
        $config['max_size']             = 100000;
        $this->load->library('upload', $config);
        $this->upload->initialize($config); ///esto esta medio raro
        $this->session->set_userdata('uniqueid', uniqid());

        if ($this->upload->do_upload('foto')) {
            $this->load->helper('Formulario');
            $this->resize_user('./' . $folder, $this->upload->data('full_path'), $name);
            unlink($this->upload->data('full_path'));
            return true;
        } else {
            if (empty($_FILES['foto']['name'])) {
                return false;
            }
            $this->output->set_status_header(500, 'Error : Posiblemente el tipo de archivo no sea permitido.' . $this->upload->display_errors());
            return false;
        }
    }

    function resize_user($folder, $full_path, $fname)
    {
        $result = true;
        $this->load->library('image_lib');
        $counter = 0;
        $sizes = array(
            'Pequeño' => (object) array(
                'ancho' => 64,
                'alto' => 64,
                'sufijo' => 'thumb',
            ),
            'Mediano' => (object) array(
                'ancho' => 250,
                'alto' => 350,
                'sufijo' => 'small',
            ),
        );
        foreach ($sizes as $size) {
            $counter++;
            $config['image_library'] = 'gd2';
            $config['source_image'] = $full_path;
            $config['maintain_ratio'] = TRUE;
            $config['width']         = $size->ancho;
            $config['height']       = $size->alto;
            $config['new_image'] = $folder . '/' . str_replace('small', $size->sufijo, $fname);
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
        }
        return $result;
    }

    public function dieAjax()
    {
        if (
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strcasecmp($_SERVER['HTTP_X_REQUESTED_WITH'], 'xmlhttprequest') == 0
        ) {
            return true;
        }
        $this->dieMsg(false, "No es ajax.");
    }

    public function isAjax()
    {
        if (
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strcasecmp($_SERVER['HTTP_X_REQUESTED_WITH'], 'xmlhttprequest') == 0
        ) {
            return true;
        }
        return false;
    }

    public function addJs($jss)
    {
        if (is_array($jss)) $this->jss = $jss;
        else $this->jss[] = $jss;
    }
    public function addCss($csss)
    {
        if (is_array($csss)) $this->csss = $csss;
        else $this->csss[] = $csss;
    }

    public function showHeader($menu = true)
    {
        $strcss = '';
        $strjs = '';

        $datos['menu'] = [];

        //if ($this->user->id) {
            $datos['menu'] = [
                ['url' => 'Portada/acerca', 'base' => 'acerca', 'name' => 'Acerca'],
            ];
       // }

        foreach ($this->csss as $css) {
            $strcss .= '<link href="' . ((preg_match('#^htt#', $css) == TRUE) ? '' : base_url('sys/assets') . '/') . $css . '?v=' . $this->frontVersion . '" rel="stylesheet" type="text/css" media="all" />';
        }
        foreach ($this->jss as $js) {
            $strjs .= '<script type="text/javascript" src="' . ((preg_match('#^htt#', $js) == TRUE) ? '' : base_url('sys/assets') . '/') . $js . '?v=' . $this->frontVersion . '"></script>';
        }

        $this->mc_scripts['js'] = $strjs;
        $this->mc_scripts['css'] = $strcss;
        echo view('templates/header', $this->mc_scripts);
        if ($menu) echo view('templates/menu', $datos);
    }


    public function showContent($path, $response = [])
    {
        echo view(strtolower($this->controller) . '/' . $path, $response);
    }
    public function showFooter()
    {
        echo view('templates/footer');
    }
    public function dieMsg($ret = true, $msg = "", $redirect = "")
    {
        if ($ret == false) {
            $this->response->setStatusCode(500, $msg);
            $this->response->send();
            exit(0);
        }
        $resp = ['exito' => $ret, 'mensaje' => $msg, 'redirect' => $redirect];
        $this->response->setJSON($resp);
        $this->response->send();
        exit(0);
    }
}

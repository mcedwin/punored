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
                ['url' => 'Test/mis_tests', 'base' => 'mis_tests', 'name' => 'Acerca', 'ico' => 'fas fa-file-alt'],
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

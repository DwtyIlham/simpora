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
abstract class BaseController extends Controller
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
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;
    protected $md5key;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->session = \Config\Services::session();

        function encode_id($id)
        {
            $b64 = base64_encode("x-$id-x");
            return strtr($b64, [
                '+' => 'e07fe2007cf',
                '/' => '4709c0abfa1',
                '=' => 'b2e606c9be'
            ]);
        }

        function decode_id($hash)
        {
            $b64 = strtr($hash, [
                'e07fe2007cf'   => '+',
                '4709c0abfa1'   => '/',
                'b2e606c9be'    => '='
            ]);

            $decoded = base64_decode($b64);

            if (preg_match('/x-(.*)-x/', $decoded, $m)) {
                return $m[1];
            }
            return false;
        }



        if (!function_exists('format_tgl')) {
            function format_tgl($date, $format = 'd/m/Y')
            {
                if (!$date) return null;
                $dt = new \DateTime($date);
                return $dt->format($format);
            }
        }

        if (!function_exists('isAdmin')) {
            function isAdmin()
            {
                if (session('user')['role_id'] === '1') {
                    return true;
                }
                return false;
            }
        }
    }
}

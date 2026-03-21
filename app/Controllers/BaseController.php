<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var RequestInterface
     */
    protected $request;

    /**
     * Session instance
     */
    protected $session;

    /**
     * Automatically loaded helpers
     */
    protected $helpers = ['url', 'form'];

    /**
     * Constructor.
     */
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    )
    {

        parent::initController($request, $response, $logger);

        /**
         * Load session service
         */
        $this->session = service('session');

    }
}

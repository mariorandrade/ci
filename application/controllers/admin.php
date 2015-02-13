<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Administration panel
 *
 * @package Kyuubi SRM
 * @Author: Mario Andrade
 * @link: twitter.com/mariorandrade/
 * @license	http://opensource.org/licenses/MIT	MIT License
 *
 */


class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('admin/master');
    }

    public function dashboard() {
        $this->load->view('admin/dashboard');
    }
} //endclass
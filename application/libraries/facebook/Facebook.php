<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(APPPATH . 'libraries/facebook/Facebook/autoload.php');
require_once(APPPATH . 'libraries/facebook/Facebook/FacebookSession.php');
require_once(APPPATH . 'libraries/facebook/Facebook/FacebookRedirectLoginHelper.php');
require_once(APPPATH . 'libraries/facebook/Facebook/FacebookRequest.php');



use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\FacebookRedirectLoginHelper;


class Facebook extends CI_Controller {
    protected $ci;
    protected $conf;
    protected $domain;
    protected $helper;
    protected $session;
    protected $permissions;

    public $config_id;

    public function __construct() {

        $this->ci =& get_instance();


        $this->ci->load->config('facebook');

        $this->permissions = $this->ci->config->item('permissions', $this->conf); //load cond

        FacebookSession::setDefaultApplication( $this->ci->config->item('api_id', 'facebook'), $this->ci->config->item('app_secret', 'facebook') );

        /*
         * FB Login helper
         * Use same domain as defined in "App domains" when Facebook App was created
         *
         * */

        $this->helper = new FacebookRedirectLoginHelper( $this->ci->config->item('redirect_url', 'facebook') );

        if ( $this->ci->session->userdata('fb_token') ) {
            $this->session = new FacebookSession( $this->ci->session->userdata('fb_token') );


            /*
             * Validate Facebook access_token
             * */

            try {
                if( ! $this->session->validate() ) {
                    $this->session = null;
                }
            } catch ( Exception $e ) {
                $this->session = null;
            }
        }
        else {
            //No session

            try {
              $this->session = $this->helper->getSessionFromRedirect();
            } catch( FacebookRequestException $ex ) {
                //Facebook returned error
            } catch ( Exception $ex ) {
                //Validation fails
            }
        }

        if ( $this->session ) {
            $this->ci->session->set_userdata( 'fb_token', $this->session->getToken() );

            $this->session = new FacebookSession( $this->session->getToken() );
        }
    }


    /*
     * Return the FB Login URL
     * */

    public function get_login_url() {
        return $this->helper->getLoginUrl( $this->permissions );
    }

    /*
     * Return user info
     *
     * @return array
     * */
    public function get_user() {
        if ( $this->session ) {

            $request = ( new FacebookRequest( $this->session, 'GET', '/me' ) )->execute();

            $user = $request->getGraphObject();

            return $user;
        }

        return false;
    }

    public function validateAccessToken ($redirect_url = '')
    {


        $redirect_url = ($redirect_url=='')?'/':$redirect_url;
        /*
         * Get configuration key
         * config_id is the array KEY value defined in application/config/{ENVIRONMENT}/config.php for the app.
         * $this->conf will store the values in the $config[ {config_ig} ] key
         *
         * */
        $this->conf = $this->ci->config->item ( $this->config_id );


        /*
         * Check if URL returns code
         *
         * */

        $code =  ( empty( $this->ci->input->get( 'code'  ) ) )? '' : $this->ci->input->get('code') ;

        if(empty($code)) {
            //if url does not return code, request code from facebook.

            $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
            $dialog_url = "https://www.facebook.com/dialog/oauth?client_id="
                . $this->ci->config->item('api_id', 'facebook') . "&redirect_uri=" . urlencode($this->ci->config->item('redirect_url', 'facebook')) . "&state="
                . $_SESSION['state'];

            echo("<script> top.location.href='" . $dialog_url . "'</script>");
        }

        if( isset($_REQUEST['state']) && isset($_SESSION['state']) && ( $_REQUEST['state'] == $_SESSION['state']) && !empty($code) ) {
            //if has url code
            // get access_token here
            $token_uri = "https://www.facebook.com/dialog/oauth?client_id=". $this->ci->config->item('api_id', 'facebook') ."&redirect_uri=".$redirect_url."&client_secret=".$this->ci->config->item('app_secret', 'facebook')."&code=".$code;

            echo $token_uri;
        }
        else {
            echo("The state does not match. You may be a victim of CSRF.");
        }



    }

}
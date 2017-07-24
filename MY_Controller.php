<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**

 * @author Erick Daniel Rico Martinez
 */
class Functioncode extends CI_Controller
{

  private $_session= false;

  /**
   * [private description]
   * @var [type]
   */
  private $_post;


  function __construct()
  {
    parent::__construct();
    $this->session->restrictedAcces = $this->_get_session();
  }
  /** @$session [boolean] [Valor falso : veradero] */
  public function _set_session($session)
  {
    $this->_session = $session;
  }
  public function _get_session()
  {
    return $this->_session;
  }
  public function _get_data_form($fields,$post)
  {
    $this->_fields = $fields;
    $this->_post = $post;
    if (isset($_fields) && isset($_post))
    {
      if (!empty($_fields) && !empty($_post))
      {
        foreach ($_fields as $key )
        {
            $post[$key] = $this->input->post($key);
        }
        return $post;
      }
      return [];
    }
    return [];
  }
  /**
   * [login description]
   * @param  [type] $fields [description]
   * @return [type]         [description]
   */
  public function login($fields) {
    if (isset($fields))
    {
        if (!empty($fields))
        {
            $_fileds = $this->security->xss_clean($fields);
            $_where = array('userName' => $_fileds['userName'],
                'status' =>1);
            $query = $this->models->select('idUser,userName,password,typeUser','user',$_where);
            if (count($query)>0)
            {
              foreach ($query as $consult)
              {
                  if ($this->encryption->decrypt($consult['password']) === $_fields['password'])
                  {
                    $this->session->idBranchOffice= 1;
                    $this->_set_session(true);
                    return true;
                  }
              }
              return false;
            }
            return false;
        }
      return false;
    }
      return false;
  }
  public function loadView($settings) {
      $this->load->view('themplate/head',$settings);
      if ($this->session->restrictedAcces) {
        $this->load->view('themplate/menu');
      }
      $this->load->view($settings['view'],$settings);
      if ($this->session->restrictedAcces) {
        $this->load->view('themplate/script');
      }
  }

}

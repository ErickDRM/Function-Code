<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Functioncode extends CI_Controller
{

  protected $_session;
  function __construct()
  {
    parent::__construct();
    $this->session->restrictedAcces = _get_session();
  }

  public _set_session($session)
  {
    $this->_session = $session;
  }
  public _get_session()
  {
    return $this->_session;
  }
  public function _get_data_form($fields,$post)
  {
    $_fields = array();
    $_post = array();
    if (isset($_fields) && isset($_post))
    {
      if (!empty(_$fields) && !empty($_post))
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

  public function login($fields) {
    private  $query;
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
                    this->_set_session(true);
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

}

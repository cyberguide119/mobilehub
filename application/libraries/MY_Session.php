<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Session
 *
 * @author DRX
 */

class MY_Session extends CI_Session 
{

/**
* Update an existing session
*
* @access    public
* @return    void
*/
    function sess_update()
    {
       // skip the session update if this is an AJAX call!
       if ( !IS_AJAX )
       {
           parent::sess_update();
       }
    } 

}

/* End of file MY_Session.php */
/* Location: ./application/libraries/MY_Session.php */ 

?>

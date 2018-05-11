<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Smarty Class
 *
 * @package    CodeIgniter
 * @subpackage  Libraries
 * @category  Smarty
 * @author    Kepler Gelotte
 * @link    http://www.coolphptools.com/codeigniter-smarty
 */


class mysmarty {

    public $mySmarty;

    public function __construct()
    {
        require_once(APPPATH.'libs'.DIRECTORY_SEPARATOR.'smarty/Smarty.class.php' );
        $this->mySmarty = new Smarty();
        $this->mySmarty->setTemplateDir(APPPATH.'views'.DIRECTORY_SEPARATOR);
        $this->mySmarty->setCompileDir(APPPATH.'views'.DIRECTORY_SEPARATOR.'views_c'.DIRECTORY_SEPARATOR);
        $this->mySmarty->setConfigDir(APPPATH.'config'.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR);
        $this->mySmarty->setCacheDir(APPPATH.'cache'.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR);
        $this->mySmarty->force_compile = true;
        $this->mySmarty->left_delimiter = '<{';
        $this->mySmarty->right_delimiter = '}>';
    }
    public function getSmarty()
    {
        return $this->mySmarty;
    }
}
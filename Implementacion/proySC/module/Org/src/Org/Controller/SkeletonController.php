<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Org\Controller;

//use Zend\View\Helper\ViewModel;
use EnterpriseSolutions\Controller\BaseController;
use Zend\View\Model\ViewModel;
//use Zend\Mvc\Controller\AbstractActionController;
use Zend\Db\Adapter\Adapter;
use EnterpriseSolutions\Db\Select;
use Org\Db\SelectPerReligion;

class SkeletonController extends BaseController
{
	protected $_adapter;
	
    public function indexAction()
    {
    	/*$sql = "select * from per_religion";
        $adapter = $this->_getAdapter();
        $rs = $adapter->query($sql,Adapter::QUERY_MODE_EXECUTE);
        
        //$rs = $stmt->execute();
        //return new ViewModel(array('rs' => 'hola'));
        return array('rs' => $rs->toArray());*/
    	/*$acceptCriteria = array(
    			'Zend\View\Model\ViewModel' => array(
    					'text/html',
    			),
    			'Zend\View\Model\JsonModel' => array(
    					'application/json',
    			));*/
    	//$viewModel = $this->acceptableViewModelSelector($acceptCriteria);
    	$rs = $this->SubmitParams()->getParam('param1');
    	//$rs = $this->params()->fromQuery('param1');
    	//$select = new SelectPerReligion($this->_getAdapter());
    	//$rs = $select->execute()->toArray();
    	//return array('rs' => $rs);
    	$viewModel = $this->_seleccionarViewModelSegunContexto();
    	//$viewModel = $this->acceptableViewModelSelector();
    	//$viewModel = $this->acceptableViewModelSelector($acceptCriteria);
    	 $viewModel->setVariables(array('rs' => $rs));
    	//$viewModel = new ViewModel(array('rs' => $rs));
    	//$viewModel->setTerminal(true);
    	return $viewModel;
    	//return array('rs' => $rs);
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /module-specific-root/skeleton/foo
        return array();
    }
    
    /**
     * @return Zend\Db\Adapter\Adapter
     */
    public function _getAdapter()
    {
    	if(!$this->_adapter){
    		$sm = $this->getServiceLocator();
    		$this->_adapter = $sm->get('Zend\Db\Adapter\Adapter');
    	}
    	return $this->_adapter;
    	
        
    }
}

<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Annotation\AnnotationBuilder;
use Application\Authentication\Credenciales;
use EnterpriseSolutions\Controller\BaseController;
use EnterpriseSolutions\Db\Dao\Dto;

class LoginController extends BaseController
{
	protected $_authService;
	protected $_form;
	protected $_credenciales;
	
	public function indexAction()
	{
		$authService = $this->_getAuthService();
		if ( $authService->hasIdentity() ) {
			return $this->redirect()->toRoute('home');
		}

		$vm = new ViewModel(array(
	        'form' => $this->_getForm(),
			'messages'  => $this->flashmessenger()->getMessages()
	    ));
		$this->flashMessenger()->clearCurrentMessages();
		$vm->setTerminal(true);
		return $vm;
	}
	
	public function tryAction()
	{
		$form       = $this->_getForm();
        $redirect = 'login';
        $request = $this->getRequest();
        if ($request->isPost()){
        	$post = $this->SubmitParams()->getParam('Credenciales');
        	$form->bind($this->_credenciales);
        	$form->setData($post);
            //$form->setData($request->getPost());
            if ($form->isValid()){
                //check authentication...
                //$credenciales = $form->getData();
                //$form->bind($this->_credenciales);
                $this->_getAuthService()->getAdapter()->setCredenciales($this->_credenciales);
                /*$this->_getAuthService()->getAdapter()
                                       ->setIdentity($request->getPost('cedula'))
                                       ->setCredential($request->getPost('contrasenha'));*/
                                        
                $result = $this->_getAuthService()->authenticate();
                foreach($result->getMessages() as $message)
                {
                    //save message temporary into flashmessenger
                    $this->flashmessenger()->addMessage($message);
                }
                 
                if ($result->isValid()) {
                    $redirect = 'home';
                    //check if it has rememberMe :
                    /*if ($request->getPost('rememberme') == 1 ) {
                        $this->getSessionStorage()
                             ->setRememberMe(1);
                        //set storage again 
                        $this->getAuthService()->setStorage($this->getSessionStorage());
                    }*/
                    //$this->getAuthService()->getStorage()->write($request->getPost('username'));
                }
            }else{
            	foreach($form->getMessages() as $message){
            		$this->flashmessenger()->addMessage($message);
            	}
            }
        }
        
        return $this->redirect()->toRoute($redirect);
		
	}

	public function leaveAction()
	{
		$this->_getAuthService()->clearIdentity(); 
		$this->flashmessenger()->addMessage("Sesion terminada");
		return $this->redirect()->toRoute('login');
	}
	
	public function dirPaisAction()
	{
		$dao = $this->getServiceLocator()->get('DirPaisDao');
		$params = $this->SubmitParams()->getParams();
		$rs = $dao->find(new Dto($params));
		$viewModel = $this->_seleccionarViewModelSegunContexto();
		$viewModel->setVariables($rs);
		return $viewModel;
	}
	
	public function perDocTipoAction()
	{
		$dao = $this->getServiceLocator()->get('PerDocTipoDao');
		$params = $this->SubmitParams()->getParams();
		$rs = $dao->find(new Dto($params));
		$viewModel = $this->_seleccionarViewModelSegunContexto();
		$viewModel->setVariables($rs);
		return $viewModel;
	}
	
	/**
	 * @return \Zend\Form\Form
	 */
	public function _getForm()
	{
		if(!$this->_form){
		    $this->_credenciales = new Credenciales();
		    $builder = new AnnotationBuilder();
		    $this->_form = $builder->createForm($this->_credenciales);
		    //$this->_form->bind($this->_credenciales);
		}
		return $this->_form;
	}
	
	public function _getAuthService()
	{
		if(!$this->_authService){
			$this->_authService  = $this->getServiceLocator()->get('AuthService');
		}
		return $this->_authService;
	}
}

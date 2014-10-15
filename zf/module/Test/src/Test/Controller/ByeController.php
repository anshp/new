<?php
namespace Test\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ByeController extends AbstractActionController
{
    public function worldAction()
    {
        $message = $this->params()->fromQuery('message', 'Bye');
        $this -> setVariable('ll','pp');
        return new ViewModel(array('message' => $message));
    }
}
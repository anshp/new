<?php
namespace Test\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HelloController extends AbstractActionController
{
    public function worldAction()
    {
        $message = $this->params()->fromQuery('message', 'hello');
        return new ViewModel(array('message' => $message));
    }
}
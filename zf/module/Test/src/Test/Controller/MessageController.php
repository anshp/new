<?php
namespace Test\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MessageController extends AbstractActionController
{
    public function byeAction()
    {
        $message = $this->params()->fromQuery('message', 'Bye');
        return new ViewModel(array('message' => $message));
    }
    public function helloAction()
    {
        $message = $this->params()->fromQuery('message', 'Hello');
        return new ViewModel(array('message' => $message));
    }
    public function otherAction()
    {
        $message = $this->params()->fromQuery('message', 'foo');
        return new ViewModel(array('message' => $message));
    }
}
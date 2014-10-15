<?php
namespace Test\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OtherController extends AbstractActionController
{
    public function worldAction()
    {
        $message = $this->params()->fromQuery('message', 'foo');
        return new ViewModel(array('message' => $message));
    }
}
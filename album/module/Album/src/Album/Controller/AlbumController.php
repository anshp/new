<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\Album;     
use Album\Form\AlbumForm;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;
use Zend\Authentication\AuthenticationService;

class AlbumController extends AbstractActionController
 {
     protected $albumTable;
     protected $authadapter;
     
     public function getAuthAdapter() {
         if (!$this->authadapter) {
             $sm = $this->getServiceLocator();
             $dbadapter = $sm->get('Zend\Db\Adapter\Adapter');
             $this->authadapter = new AuthAdapter($dbadapter, 'login', 'username', 'password');
         }
         return $this->authadapter;
     }
     
     public function loginAction() {
        $adapter = $this->getAuthAdapter();
        $credentials = $this->getRequest();
        $auth = new AuthenticationService();
        $message = "";
        if ($credentials->isPost()){
             $adapter->setIdentity($credentials->getPost('username'));
             $adapter->setCredential($credentials->getPost('password'));
             $result = $auth->authenticate($adapter);
             if (!$result->isValid()){
                 $message = "Authentication failed";
             }
             else{
                 return $this->redirect()->toRoute('album');
             }
         }
         
                 
        $form = new AlbumForm();
        
        return array(
            'form'  => $form,
            'message' => $message
        );
    }
        
    public function logoutAction()
    {
        $auth = new AuthenticationService();
        $auth -> clearIdentity();
        return $this->redirect()->toRoute('album',array('action'=>'login'));
    }
    
     public function getAlbumTable()
     {
         if (!$this->albumTable) {
             $sm = $this->getServiceLocator();
             $this->albumTable = $sm->get('Album\Model\AlbumTable');
         }
         return $this->albumTable;
     }
     
     public function indexAction()
     {
         $auth = new AuthenticationService();
         if (!$auth->hasIdentity()) {
             return $this->redirect()->toRoute('album',array('action'=>'login'));
         }
         // Manage page number, sort column and order
         $request = $this->params()->fromQuery();
         if (!$request['sort']){
             $request['sort'] = 'id';
             $request['ord'] = array($request['sort'] => 1);
         } else {
             $request['ord'][$request['sort']] = $request['order']%2;
         }
         if ($request['ord'][$request['sort']] == 1 or $request['order'] == 'ASC'){
             $request['order'] = 'ASC';
         } else {
             $request['order'] = 'DESC';
         }
         
         // Get search term
         $srequest = $this->getRequest();
         if ($srequest->isPost()) {
             $request['search'] = $srequest->getPost('search');
         }
         
         // Search form
         $form = new AlbumForm();
         $form->get('submit')->setValue('Search Title');
         $form->get('search')->setValue($request['search']);
        
         // Get data from table into paginator and conigure the paginator
         $paginator = $this->getAlbumTable()->fetchAll($request, true);
         $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
         $paginator->setItemCountPerPage(10);
         
         // Return necessary variables
         return new ViewModel(array('paginator' => $paginator,
             'request' => $request,
             'form' => $form));
         }

     public function addAction()
     {
         $auth = new AuthenticationService();
         if (!$auth->hasIdentity()) {
             return $this->redirect()->toRoute('album',array('action'=>'login'));
         }
         $form = new AlbumForm();
         $form->get('submit')->setValue('Add');
         $request = $this->getRequest();
         
         // If form submitted
         if ($request->isPost()) {
             
             // Back to view
             if ($request->getPost('submit2')){
                return $this->redirect()->toRoute('album');
             }
             
             // Add new album
             $album = new Album();
             $form->setInputFilter($album->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $album->exchangeArray($form->getData());
                 $this->getAlbumTable()->saveAlbum($album);
                 $notification = $form->getData();
                 $form->get('title')->setValue('');
                 $form->get('artist')->setValue('');
             }
         }
         return array('form' => $form,
             'notification' => $notification
                 );
     }

     public function editAction()
     {
         $auth = new AuthenticationService();
         if (!$auth->hasIdentity()) {
             return $this->redirect()->toRoute('album',array('action'=>'login'));
         }
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('album', array(
                 'action' => 'add'
             ));
         }

         // Get the Album with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $album = $this->getAlbumTable()->getAlbum($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('album', array(
                 'action' => 'index'
             ));
         }

         $form  = new AlbumForm();
         $form->bind($album);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             if ($request->getPost('submit2')){
                return $this->redirect()->toRoute('album');
             }
             $form->setInputFilter($album->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getAlbumTable()->saveAlbum($album);
                 $form->get('title')->setAttribute('value', $request->getPost('title'));
                 $form->get('artist')->setAttribute('value', $request->getPost('artist'));
                 $notification = array(
                     'title' => $request->getPost('title'),
                     'artist' => $request->getPost('artist')
                     );

                 // Redirect to list of albums
                 // return $this->redirect()->toRoute('album');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
             'notification' => $notification
         );
     }

     public function deleteAction()
     {
         $auth = new AuthenticationService();
         if (!$auth->hasIdentity()) {
             return $this->redirect()->toRoute('album',array('action'=>'login'));
         }
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('album');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $name = $this->getAlbumTable()->getAlbum($id)->title;
                 $this->getAlbumTable()->deleteAlbum($id);
                 return $this->redirect()->toUrl('/album?del='.$name);
             }

             // Redirect to list of albums
             return $this->redirect()->toRoute('album');
         }

         return array(
             'id'    => $id,
             'album' => $this->getAlbumTable()->getAlbum($id)
         );
     }
     
 }
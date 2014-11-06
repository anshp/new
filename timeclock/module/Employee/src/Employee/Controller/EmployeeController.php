<?php
namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Db\Sql\Sql;
use Employee\Form\EmployeeForm;
use Zend\View\Model\ViewModel;

class EmployeeController extends AbstractRestfulController
{
    protected $dbAdapter;
    
    public function getDbAdapter() {
         if (!$this->dbAdapter) {
             $sm = $this->getServiceLocator();
             $this->dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
             }
         return $this->dbAdapter;
    }
    public function verifyUser($username, $password) {
         $adapter = $this->getDbAdapter();
         $sql = new Sql($adapter);
         $select = $sql->select('employee');         //table name = employee
         $select->where(array('username' => $username, 'password' => $password));
         $selectString = $sql->getSqlStringForSqlObject($select);
         $result = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
         foreach ($result as $row) {
             $emp =  $row->username;
         }
         return $emp;   
    }
    public function getLastLogin($username){
         $adapter = $this->getDbAdapter();
         $sql = new Sql($adapter);
         $select = $sql->select('timetable'); //table name = timetable
         $select->where(array('username' => $username));
         $selectString = $sql->getSqlStringForSqlObject($select);
         $result = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
         foreach ($result as $row) {
             $last =  $row;
         }
         return $last;
    }
     
     public function adminAction()
    {
         $request = $this->params()->fromQuery();
         if ($request['search']){
             $search = $request['search'];
         }
         $prequest = $this->getRequest();
         if ($prequest->isPost()){
             $search =  $prequest->getPost('search');
         }
         if (!$request['page']){
             $page = 1;
         } else {
             $page = $request['page'];
         }
         $username = $this->params()->fromRoute('emp', 0);
         
         //Get Records from table
         $limit = 5;  //
         $adapter = $this->getDbAdapter();
         $sql = new Sql($adapter);
         $select = $sql->select('timetable'); //table name = timetable
         if ($search){
             $where = new \Zend\Db\Sql\Where();
             $where->like('username', $search."%");
             $select->where($where);
         }
         if ($username){
             $select->where(array('username' => $username));
         }
         $selectString = $sql->getSqlStringForSqlObject($select);
         $result = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
         $count = count($result);
         $select -> limit($limit);
         $select -> offset(($page-1)*$limit);
         $selectString = $sql->getSqlStringForSqlObject($select);
         $result = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
         //Pagination
         $pages = ceil($count/$limit);
         $paginator = array('page'=>$page, 'pages' => $pages);
         $form = new EmployeeForm();
         //Return results
         return array(
             'result' => $result,
             'paginator' => $paginator,
             'form'  => $form,
             'search' => $search,
             'username' => $username,
             );
    }
    public function indexAction()
    {
    }

    public function loginAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()){
             $username = $request->getPost('username');
             $password = $request->getPost('password');
             $emp = $this->verifyUser($username, $password);
             if($emp){
                 $location = $request->getPost('location');
                 if (!$location){
                     $location = "Not Provided";
                     }
                 $last = $this->getLastLogin($emp);
                 $intime =  $last->intime;
                 if($intime){
                     $date = date_create($intime);
                 } else {
                     $date = date_create('01/01/2001');
                 }
                 if($date->format('Y-m-d') === date('Y-m-d')) {
                     $message = "You are already logged in for today";
                 } else {
                     $adapter = $this->getDbAdapter();
                     $sql = new Sql($adapter);
                     $insert = $sql->insert('timetable'); //table name = timetable
                     $insert->values(array(
                         'username' => $emp,
                         'intime' => date('Y-m-d H:i:s'),
                         'outtime'=> "nill",
                         'inlocation' => $location,
                         'outlocation' => "nill",
                     ));
                     $insertString = $sql->getSqlStringForSqlObject($insert);
                     $adapter->query($insertString, $adapter::QUERY_MODE_EXECUTE);
                     $message = "You have successfully logged in.";
                 }
             } else {
                 $message = "Wrong username or password";
             }
        } 
        $form = new EmployeeForm();
        return array(
           'form'  => $form,
           'message' => $message,
        );
    }
    public function logoutAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()){
             $username = $request->getPost('username');
             $password = $request->getPost('password');
             
             
             $emp = $this->verifyUser($username, $password);
             
             if($emp){
                 $last = $this->getLastLogin($emp);
                 $intime =  $last->intime;
                 $outtime =  $last->outtime;
                 if($intime){
                     $date = date_create($intime);
                 } else {
                     $date = date_create('01/01/2001');
                 }
                 if($date->format('Y-m-d') === date('Y-m-d') and $outtime === "nill") {
                     $adapter = $this->getDbAdapter();
                     $sql = new Sql($adapter);
                     $location = $request->getPost('location');
                     if (!$location){
                         $location = "Not Provided";
                     }
                    $update = $sql->update('timetable'); //table name = timetable
                    $update->where(array('username' => $emp, 'outtime' => "nill"));
                    $update->set(array(
                        'outtime' => date('Y-m-d H:i:s'),
                        'outlocation' => $location,
                       ));
                    $updateString = $sql->getSqlStringForSqlObject($update);
                    $adapter->query($updateString, $adapter::QUERY_MODE_EXECUTE);
                    $message = "You have successfully logged out.";
                 } elseif ($date->format('Y-m-d') === date('Y-m-d') and $outtime != "nill") {
                     $message = "You have already logged out today.";
                 } else {
                     $message = "You have not logged in today.";
                 }
             } else{
                 $message = "Wrong username or password";
             }
        }
        $form = new EmployeeForm();
        echo date('');
        return array(
            'form'  => $form,
            'message' => $message,
        );
        
    }

}

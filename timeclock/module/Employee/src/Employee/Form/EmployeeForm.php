<?php
 namespace Employee\Form;
 
 use Zend\Form\Form;
 use Zend\Form\Element;

 class EmployeeForm extends Form
 {
     public function __construct()
     {
         parent::__construct('employee');
         
         // login button
         $this->add(array(
             'name' => 'login',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Login',
                 'id' => 'loginbutton',
                 'class' =>'btn btn-success'
             ),
         ));
         
         // logout button
         $this->add(array(
             'name' => 'logout',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Logout',
                 'id' => 'logoutbutton',
                 'class' =>'btn btn-success'
             ),
         ));
         // Search button
         $this->add(array(
             'name' => 'searchbutton',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Search',
                 'id' => 'searchbutton',
                 'class' =>'btn btn-success'
             ),
         ));
         
          // Username
         $this->add(array(
             'name' => 'username',
             'type' => 'text',
             'options' => array(
                 'label' => 'Username: ',
             ),
             'attributes' => array(
                 'class' => "form-control",
             ),
         ));
         
         // Password
         $this->add(array(
             'name' => 'password',
             'type' => 'text',
             'options' => array(
                 'label' => 'Password: ',
             ),
             'attributes' => array(
                 'class' => "form-control",
             ),
         ));
         
         // Search
         $this->add(array(
             'name' => 'search',
             'type' => 'text',
             'options' => array(
                 'label' => 'Search: ',
             ),
             'attributes' => array(
                 'class' => "form-control",
                 'placeholder' => "Enter Search Text",
             ),
         ));
         
     }
 }
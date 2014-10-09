<?php
 namespace Album\Form;

 use Zend\Form\Form;

 class AlbumForm extends Form
 {
     public function __construct($name = null)
     {
         parent::__construct('album');
         
         // Id
         $this->add(array(
             'name' => 'id',
             'type' => 'text',
             'options' => array(
                 'label' => 'Id: ',
             ),
         ));
         
         // Title
         $this->add(array(
             'name' => 'title',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Title: ',
             ),
             'attributes' => array(
                 'class' => "form-control",
             ),
         ));
         
         // Artist
         $this->add(array(
             'name' => 'artist',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Artist: ',
             ),
             'attributes' => array(
                 'class' => "form-control",
             ),
         ));
         
         // Search text
         $this->add(array(
             'name' => 'search',
             'type' => 'Text',
             'attributes' => array(
                 'label' => 'Search',
                 'class' => "form-control",
                 'id' => 'x',
                 
             ),
         ));
         
         // Submit button
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Login',
                 'id' => 'submitbutton',
             ),
         ));
         
         // Back button
         $this->add(array(
             'name' => 'submit2',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Back to View',
                 'id' => 'submit2',
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
                 'value' => 'a',
             ),
         ));
         
         // Password
         $this->add(array(
             'name' => 'password',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Password: ',
             ),
             'attributes' => array(
                 'value' => 'a',
                 'class' => "form-control",
             ),
         ));
         
     }
 }
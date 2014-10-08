<?php
namespace Album\Form;

 use Zend\Form\Form;

 class AlbumForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('album');

         $this->add(array(
             'name' => 'id',
             'type' => 'text',
         ));
         $this->add(array(
             'name' => 'title',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Title: ',
             ),
         ));
         $this->add(array(
             'name' => 'artist',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Artist: ',
             ),
         ));
         
         $this->add(array(
             'name' => 'search',
             'type' => 'Text',
             'attributes' => array(
                 'label' => 'Search',
                 
             ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
         $this->add(array(
             'name' => 'submit2',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Cancel',
                 'id' => 'submit2',
             ),
         ));
     }
 }
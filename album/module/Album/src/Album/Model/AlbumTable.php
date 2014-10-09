<?php
 namespace Album\Model;

 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Select;
 use Zend\Paginator\Adapter\DbSelect;
 use Zend\Paginator\Paginator;
 class AlbumTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll($request, $paginated=false)
     {
         if ($paginated) {
             
             // create a new Select object for the table album
             $select = new Select('album');
             $select->order($request['sort']." ".$request['order']);
             
             // Search
             if ($request['search']){
                 $x = $request['search'].'%';
                 $where = new \Zend\Db\Sql\Where();
                 $where->like('title', $x);
                 $select->where($where);
             }
             
             // New result set based on the Album entity
             $resultSetPrototype = new ResultSet();
             $resultSetPrototype->setArrayObjectPrototype(new Album());
             
             // New pagination adapter object
             $paginatorAdapter = new DbSelect($select, $this->tableGateway->getAdapter(), $resultSetPrototype);
             $paginator = new Paginator($paginatorAdapter);
             return $paginator;
         }
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getAlbum($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveAlbum(Album $album)
     {
         $data = array(
             'artist' => $album->artist,
             'title'  => $album->title,
         );
         $id = (int) $album->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getAlbum($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Album id does not exist');
             }
         }
     }

     public function deleteAlbum($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }
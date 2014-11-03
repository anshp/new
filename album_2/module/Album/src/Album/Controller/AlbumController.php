<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Album\Model\Album;
use Swagger\Annotations as SWG;
/**
 * @SWG\Resource(
 *      basePath="http://192.168.10.235/album_2/public",
 *      @SWG\Api(
 *          path="/album",
 *          @SWG\Operation(
 *              nickname="getall",
 *              method="GET",
 *              summary="Get all albums"
 *          )
 *      )
 * )
 * @SWG\Resource(
 *      basePath="http://192.168.10.235/album_2/public",
 *      @SWG\Api(
 *          path="/album",
 *          @SWG\Operation(
 *              nickname="addalbum",
 *              method="POST",
 *              summary="Add New Album",
 *              @SWG\Parameter(
 *                   name="title",
 *                   description="Album Title",
 *                   required=true,
 *                   type="album",
 *                   paramType="form",
 *                   allowMultiple=true
 *             ),
 *             @SWG\Parameter(
 *                   name="artist",
 *                   description="Album Artist",
 *                   required=true,
 *                   type="artist",
 *                   paramType="form",
 *                   allowMultiple=true
 *             ),
 *          )
 *      )
 * )
 * @SWG\Resource(
 *      basePath="http://192.168.10.235/album_2/public",
 *      @SWG\Api(
 *          path="/album/{albumId}",
 *          @SWG\Operation(
 *              nickname="addalbum",
 *              method="GET",
 *              summary="Get Album By Id",
 *              @SWG\Parameter(
 *                   name="albumId",
 *                   description="Id of the required album",
 *                   required=true,
 *                   type="album",
 *                   paramType="path",
 *                   allowMultiple=true
 *             ),
 *          )
 *      )
 * )
 * @SWG\Resource(
 *      basePath="http://192.168.10.235/album_2/public",
 *      @SWG\Api(
 *          path="/album/{albumId}",
 *          @SWG\Operation(
 *              nickname="addalbum",
 *              method="DELETE",
 *              summary="Delete Album",
 *              @SWG\Parameter(
 *                   name="albumId",
 *                   description="Id of the album to be deleted",
 *                   required=true,
 *                   type="album",
 *                   paramType="path",
 *                   allowMultiple=true
 *             ),
 *          )
 *      )
 * )
 * @SWG\Resource(
 *      basePath="http://192.168.10.235/album_2/public",
 *      @SWG\Api(
 *          path="/album/{albumId}",
 *          @SWG\Operation(
 *              nickname="addalbum",
 *              method="PUT",
 *              summary="Edit an Album / Add New Album",
 *              @SWG\Parameter(
 *                   name="albumId",
 *                   description="Id of the album to be edited (If album is not found, new album will be added)",
 *                   required=true,
 *                   type="int",
 *                   paramType="path",
 *                   allowMultiple=true
 *             ),
 *             @SWG\Parameter(
 *                   name="title",
 *                   description="Album Title",
 *                   required=true,
 *                   type="string",
 *                   paramType="form",
 *                   allowMultiple=true
 *             ),
 *             @SWG\Parameter(
 *                   name="artist",
 *                   description="Album Artist",
 *                   required=true,
 *                   type="string",
 *                   paramType="form",
 *                   allowMultiple=true
 *             ),
 *          )
 *      )
 * )
 *  

 */
class AlbumController extends AbstractRestfulController
 { 
     protected $albumTable;
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
         $request = $this->getRequest();
         $id = (int) $this->params()->fromRoute('id', 0);
         if(!$id){
             if ($request->isPost()){
                 $album = new Album();
                 $album->exchangeArray(array('title' => explode('=',explode('&',$request->getContent())[0])[1],
                     'artist' => explode('=',explode('&',$request->getContent())[1])[1] ));
                 $this->getAlbumTable()->saveAlbum($album);
                 
                 return new JsonModel(array(
                     'album' => $album,
                     ));
             }
             // Get data from table into paginator and conigure the paginator
             $paginator = $this->getAlbumTable()->fetchAll(true);
             $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
             $paginator->setItemCountPerPage(10);
            
            // Return necessary variables
            
            return new ViewModel(array(
                 'paginator' => $paginator,
                 ));
         }
         else {
             try {
                 $album = $this->getAlbumTable()->getAlbum($id);
                 $x = 1;
                 }
             catch (\Exception $ex) {
                 $x = 0;
                 $album = new Album();
                 if ($request->isPut()){
                     $album->exchangeArray(array('title' => explode('=',explode('&',$request->getContent())[0])[1],
                         'artist' => explode('=',explode('&',$request->getContent())[1])[1]
                         ));
                     $this->getAlbumTable()->saveAlbum($album);
                 }
                 return new JsonModel(array(
                     'album' => $album,
                     ));
             }
             
             if($x){
                 if ($request->isDelete()){
                    $this->getAlbumTable()->getAlbum($id)->title;
                    $this->getAlbumTable()->deleteAlbum($id);
                }
                if ($request->isPut()){
                     $album->exchangeArray(array('id' => $album->id,'title' => explode('=',explode('&',$request->getContent())[0])[1],
                         'artist' => explode('=',explode('&',$request->getContent())[1])[1]
                         ));
                     $this->getAlbumTable()->saveAlbum($album);
                 }
                return new JsonModel(array(
                     'album' => $album,
                     ));
             }
         }
     }
 }
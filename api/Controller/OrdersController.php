<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\InternalErrorException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Utility\Hash;
use Cake\Filesystem\File;
use Cake\I18n\Number;
use Cake\Mailer\Email;
use Cake\View\View;
use Symfony\Component\Config\Definition\Exception\Exception;
use Imagick;


class OrdersController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->loadModel('Users');
        $this->loadModel('Orders');
        $this->loadModel('Operations');
        $this->loadModel('Accessories');
        $this->loadModel('Statuses');
        $this->loadModel('Images');
        $this->loadModel('Files');


    }


    /**
     * View single order
     * @param $id
     */
    public function view($id)
    {
        $row = $this->Orders->findById($id)
            ->contain(["Users", "Statuses", "Operations", "Accessories", "Images", "Files"])
            ->first();

        if(!$row) {
            throw new InternalErrorException("Chyba pri nacitani objednavky",500);
        }

        $this->set('row',$row);
        $this->set('_serialize',['row']);
    }


    /**
     * View orders by user
     * @param $id
     */
    public function byUser()
    {
        $row = $this->Orders->find()
            ->contain(["Users", "Statuses", "Operations", "Accessories", "Images", "Files"])
            ->where(['user_id'=>$this->getUserId()])
            ->order("Users.id DESC")
            ->limit(5);
        if(!$row) {
            throw new InternalErrorException("Chyba pri nacitani",500);
        }

        $this->set('rows',$row);
        $this->set('_serialize',['rows']);
    }

    /**
     * View single order
     * @param $id
     */
    public function email($id)
    {
        $row = $this->Orders->findById($id)
            ->contain(["Users", "Statuses", "Operations", "Accessories", "Images", "Files"])
            ->first();

        if(!$row) {
            throw new InternalErrorException("Chyba pri nacitani objednavky",500);
        }

        $email = new Email();
        $email->emailFormat('html')
                ->template('order_client')
                ->transport('default')
                ->viewVars([
                    'message'=>$this->request->data('message'),
                    'row'=>$row,
                    'name'=>$row['user']['name'],
                    'username'=>$row['user']['username']
                ])
                ->to($this->request->data('email'))
                ->from($row['user']['username'])
                ->subject($this->request->data('subject') . ' -  taznezariadenia.sk')
                ->send();

        $this->set('row',$row);
        $this->set('_serialize',['row']);
    }

    /**
     * Orders
     */
    public function index() {



       $orders = $this->Orders->find('all')
        ->contain(["Users", "Statuses", "Operations"]);

        if(isset($this->request->query['global'])) {
            $search = $this->request->query['global'];
            $orders->where([
                "OR"=>[
                    'customer LIKE'=> '%'.$search.'%',
                    'street LIKE'=> '%'.$search.'%',
                    'email LIKE'=> '%'.$search.'%',
                    'phone LIKE'=> '%'.$search.'%',
                    'companny LIKE'=> '%'.$search.'%',
                    'typ LIKE'=> '%'.$search.'%',
                    'address LIKE'=> '%'.$search.'%',
                    'ico LIKE'=> '%'.$search.'%',
                    'description LIKE'=> '%'.$search.'%',
                    'internal_info LIKE'=> '%'.$search.'%',
                    'Operations.name LIKE'=> '%'.$search.'%',
                    'Statuses.name LIKE'=> '%'.$search.'%',
                    'Users.name LIKE'=> '%'.$search.'%'
                ]
            ]);
        }

        if(isset($this->request->query['operation'])) {
           $operations =  json_decode($this->request->query['operation']);
           $ids = [];
           foreach($operations as $k=>$val)
           {
               if($val == 1) {
                   $ids[] = $k;
               }
           }
           if($ids) {
               $orders->andWhere(['operation_id IN' => $ids]);
           }
        }


        if(isset($this->request->query['status'])) {
            $status =  json_decode($this->request->query['status']);
            $ids = [];
            foreach($status as $k=>$val)
            {
                if($val == 1) {
                    $ids[] = $k;
                }
            }
            if($ids) {
                $orders->andWhere(['status_id IN' => $ids]);
            }
        }

        // Date
        if(isset($this->request->query['date'])) {

           $dates =  json_decode($this->request->query['date']);
           foreach($dates as $key=>$date) {
               if(isset($date->from))
               $orders->andWhere(['Orders.'.$key . ' >=' => $date->from]);
               if(isset($date->to))
               $orders->andWhere(['Orders.'.$key . ' <=' => $date->to]);
           }

        }

        if(isset($this->request->query['limit'])) {
           $orders->limit($this->request->query['limit']);
        }

        if(isset($this->request->query['offset'])) {
           $orders->offset($this->request->query['offset']);
        }

        $orders->order("Orders.id DESC");

        $operations = $this->Operations->find('all');
        $statuses = $this->Statuses->find('all');

        $this->set('rows',$orders);
        $this->set('operations',$operations);
        $this->set('statuses',$statuses);
        $this->set('total',$orders->count());
        $this->set('_serialize',['rows', 'total', 'operations' , 'statuses']);
    }



    /**
     * Save
     */
    public function save()
    {
        $this->template = "ajax";

        $data = $this->request->data();

        if($this->request->data('date_delivery')) {
          $time = new \DateTime($this->request->data('date_delivery'));
          $data['date_delivery'] = $time;
        }

        if($this->request->data('date_deposit')) {
            $deposit_time = new \DateTime($this->request->data('date_deposit'));
            $data['date_deposit'] = $deposit_time;
        }

        try {

            $order = $this->Orders->newEntity($data);
            $order->user_id = $this->getUserId();
            if(!$this->Orders->save($order, ['associated' => ['Accessories', "Images"]])) {
                $message = [
                    'message'=>  "error saving data",
                    "data"=> $order->errors()
                ];
                throw new InternalErrorException(json_encode($message));
            }


        } catch(Exception $e) {
            throw new InternalErrorException($e->getMessage());
        }

        $data['row'] = $order;
        $this->set($data);
        $this->set('_serialize', ['row']);
    }



    /**
     * Save
     */
    public function edit($id = null)
    {

        $data = $this->request->data();

        if($this->request->data('date_delivery')) {
            $time = new \DateTime($this->request->data('date_delivery'));
            $data['date_delivery'] = $time;
        }


        if($this->request->data('date_deposit')) {
            $deposit_time = new \DateTime($this->request->data('date_deposit'));
            $data['date_deposit'] = $deposit_time;
        }

        try {
            $editOrder = $this->Orders->get($id);
            $this->Orders->patchEntity($editOrder,$data, ['associated' =>
                [
                'Accessories'=>['accessibleFields' => ['id' => true]],
                "Images"=>['accessibleFields' => ['id' => true]]
                ]
            ]);

            if(!$this->Orders->save($editOrder)) {
                $message = [
                    'message'=>  "error saving data",
                    "data"=> $editOrder->errors()
                ];
               throw new Exception(json_encode($message));
            }

            $order = $this->Orders->find()
                ->where(['id'=>$id])
                ->contain(['Accessories', 'Images','Files'])
                ->first();

        } catch(Exception $e) {

            return  $this->Header->setResponse(500,json_decode($e->getMessage()));
        }

        $data['row'] = $order;
        $this->set($data);
        $this->set('_serialize', ['row']);
    }

    /**
     * Get Statuses
     */
    public function statuses()
    {

        $statuses = $this->Statuses->find('all');
        $this->set('rows',$statuses);
        $this->set('_serialize',['rows']);
    }


    /**
     * GEt operations
     */
    public function operations()
    {

        $rows = $this->Operations->find('all');
        $this->set('rows',$rows);
        $this->set('_serialize',['rows']);
    }


    /**
     * Delete Accessory
     */
    public function deleteAccessory($id = null)
    {

        $accessory = $this->Accessories->get($id);
        if($accessory) {
           $order = $this->Orders->get( $accessory->order_id);
           $order->total_price =   $order->total_price - ($accessory->price*$accessory->amount);

           if($this->Accessories->delete($accessory)) {
               $this->Orders->save($order);
           }
        }
        $this->set('row',$accessory);
        $this->set('_serialize',['row']);
    }


    /**
     * Save Images
     * @param $order_id
     */
    public function images($order_id = null)
    {

        $files = $this->request->data();
        $images = array();
        foreach($files['files'] as $file)
        {   $file_name = new File($file['name']);
            $name = $order_id.'-'.md5($file_name->name).'.'.$file_name->ext();
           if(!move_uploaded_file($file['tmp_name'],'img/images/'.$name)){
               throw new InternalErrorException(json_encode($file));

           };

            $thumb = new \Imagick('img/images/'.$name);
            $thumb->resizeImage(600,400,Imagick::FILTER_LANCZOS,1);
            $thumb->writeImage('img/images/'.$name);
            $thumb->destroy();

            $image = $this->Images->newEntity([
                 'name'=>$name,
                 'order_id'=>$order_id
             ]);
             $images[] = $this->Images->save($image);
        }
        $this->set('row',$images);
        $this->set('_serialize',['row']);
    }


    /**
     * Save file
     * @param null $order_id
     */
    public function file($order_id = null)
    {
        $file_data = $this->request->data('file');

        $file_name = new File($file_data['name']);
        $name = preg_replace('/\s+/','_', $file_name->name()).'.'.$file_name->ext();
        if(!move_uploaded_file($file_data['tmp_name'],'files/'.$name)){
            throw new InternalErrorException(json_encode($file_data));
        };

        $fileObj = $this->Files->newEntity([
            'name'=>$name,
            'order_id'=>$order_id,
            'size'=>Number::toReadableSize($file_data['size'])
        ]);

        $file  = $this->Files->save($fileObj);

        $this->set('row',$file);
        $this->set('_serialize',['row']);
    }

    public function delete($order_id = null) {}
    /**
     * Delete File
     * @param null $file_id
     */
    public function deleteFile($file_id = null)
    {
        $file = $this->Files->get($file_id);
        $this->Files->delete($file);
        @unlink("files/".$file->name);
        $this->set('row',$file);
        $this->set('_serialize',['row']);
    }


    /**
     * Delete Image
     * @param null $image_id
     */
    public function deleteImage($image_id = null)
    {
        $file = $this->Images->get($image_id);
        $this->Images->delete($file);
        @unlink("img/images/".$file->name);
        $this->set('row',$file);
        $this->set('_serialize',['row']);
    }


    /**
     * Generuj Objednavku
     * @param $id
     */
    public function generate($id)
    {
        $this->viewBuilder()->layout('popup');

        $order = $this->Orders->get($id);
        $order->date_order = date("Y-m-d");
        $this->Orders->save($order);

        $row = $this->Orders->findById($id)
            ->contain(["Users", "Statuses", "Operations", "Accessories", "Images"])
            ->first();


        if(!$row) {
            throw new InternalErrorException("Chyba pri nacitani objednavky",500);
        }

        $this->set('row',$row);
    }



    /**
     * Print Objednavku
     * @param $id
     */
    public function printOrder($id)
    {
        $this->viewBuilder()->layout('popup');

        $row = $this->Orders->findById($id)
            ->contain(["Users", "Statuses", "Operations", "Accessories", "Images"])
            ->first();

        if(!$row) {
            throw new InternalErrorException("Chyba pri nacitani objednavky",500);
        }


        $this->set('row',$row);
        $this->render('generate');
    }


    /**
     * Delete Order
     * @param $id
     */
    public function deleteOrder($id)
    {
        $row = $this->Orders->get($id);
        $this->Orders->delete($row);

        $images = $this->Images->find()->where(['order_id'=>$id]);

        if($images) {
            foreach($images as $image) {
                $this->Images->delete($image);
                @unlink("img/images/".$image->name);
            }
        }

        $files = $this->Files->find()->where(['order_id'=>$id]);

        if($files) {
            foreach($files as $file) {
                $this->Files->delete($file);
                @unlink("files/".$file->name);
            }
        }

        $this->set('row', $row);
        $this->set('_serialize',['row']);
    }


    /**
     * Copy Objednavku
     * @param $id
     */
    public function copy($id)
    {

        $row = $this->Orders->findById($id)
            ->contain(["Accessories", "Images", "Files","Statuses", "Operations"])
            ->first();

        if(!$row) {
            throw new InternalErrorException("Chyba pri nacitani objednavky",500);
        }


        try {

            $data = $row->toArray();

            // Copy All Images
            if($data['images']) {
                foreach ($data['images'] as $key => $image) {
                    $file_name = new File($image['name']);
                    $new_file  = md5($file_name->name().time()).".".$file_name->ext();
                    if(copy('img/images/'.$file_name->name,'img/images/'.$new_file)) {
                        $data['images'][$key]['name'] = $new_file;
                    }
                }
            }

            // Copy all Files
            if($data['files']) {
                foreach ($data['files'] as $key => $file) {
                    $file_name = new File($file['name']);
                    $origin_file  = preg_replace("/-copy-\d{2}\.\d{2}\.\d{2}.\d{2}.\d{2}/","",$file_name->name());
                    $new_file  =  $origin_file."-copy-".date("d.m.y-H-i").".".$file_name->ext();

                    if(copy('files/'.$file_name->name,'files/'.$new_file)) {
                        $data['files'][$key]['name'] = $new_file;
                    }
                }
            }

            $order = $this->Orders->newEntity($data);
            $order->user_id = $this->getUserId();

            if(!$this->Orders->save($order)) {
                $message = [
                    'message'=>  "error saving data",
                    "data"=> $order->errors()
                ];
                throw new InternalErrorException(json_encode($message));
            }

        } catch(Exception $e) {
            throw new InternalErrorException($e->getMessage());
        }

        $this->set('row', $order);
        $this->set('_serialize',['row']);
    }

    /**
     * Generate PDF
     * @param $id
     */
    public function pdf($id = null) {


        $row = $this->Orders->findById($id)
            ->contain(["Users", "Statuses", "Operations", "Accessories", "Images"])
            ->first();

        if(!$row) {
            throw new InternalErrorException("Chyba pri nacitani objednavky",500);
        }


        $view = new View($this->request,$this->response,null);
        $view->layout = "ajax";
        $view->set("row",$row);
        $html = $view->render("Orders/pdf");


        $pdf = new \DOMPDF();

        $pdf->load_html(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        $pdf->set_paper('a4', 'portrait');
        $pdf->render();
        $pdf->stream("order-".$id.".pdf", array("Attachment"=>0));
    }

}

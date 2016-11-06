<?php

namespace app\controllers;

use Yii;
use app\models\RoomReservation;
use app\models\RoomReservationDetail;
use app\models\Customer;
use app\models\CustomerPhone;
use app\models\CustomerIdentification;
use app\models\RoomReservationSearch;
use app\models\ReservationDeposit;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RoomReservationController implements the CRUD actions for RoomReservation model.
 */
class RoomReservationController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        //'actions' => ['login', 'error'], // Define specific actions
                        'allow' => true, // Has access
                        'roles' => ['@'], // '@' All logged in users / or your access role e.g. 'admin', 'user'
                    ],
                    [
                        'allow' => false, // Do not have access
                        'roles'=>['?'], // Guests '?'
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all RoomReservation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoomReservationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RoomReservation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $customer = \app\models\Customer::findOne($id);
        return $this->render('view', [
            'model' => $customer,
        ]);
    }

    /**
     * Creates a new RoomReservation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RoomReservation();
        //$model->cancel = "N";

        if ($model->load(Yii::$app->request->post())) {
            $strdate = $model->startdate;
            $date = explode("-",$model->startdate);
            $model->startdate = date("Y-m-d", strtotime(str_replace("/","-",$date[0])));
            $model->enddate = date("Y-m-d", strtotime(str_replace("/","-",$date[1])));

            $model->deposit = str_replace('.','',$model->deposit);
            if ($model->out != null)
                $model->out = date("Y-m-d", strtotime($model->out));

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            $acc = true;

            if (!$model->save()){
                $acc = false;
            }

            $model_rate = new \app\models\RoomReservationRate();
            $roomtype = \app\models\RoomType::find()->where(['roomtypeid'=>$model->room->roomtypeid])->one();
            $model_rate->roomreservationid = $model->roomreservationid;
            $model_rate->rate = $roomtype->rate;
            $model_rate->childcharge = $roomtype->childcharge;
            $model_rate->adultcharge = $roomtype->adultcharge;
            $model_rate->weekendrate = $roomtype->weekendrate;

            if (!$model_rate->save()){
                $acc = false;
            }

            if ($acc){
                $transaction->commit();   
                return $this->redirect(['index']); 
            }else{
                $transaction->rollback();
            }

            if ($model->out != null)
                $model->out = date("d-M-Y", strtotime($model->out));
            
            $model->startdate = $strdate;
            $model->enddate = '';
            return $this->render('create', [
                'model' => $model,
            ]);  
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RoomReservation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->cancel = "N";

        if ($model->load(Yii::$app->request->post())) {
            $strdate = $model->startdate;
            $date = explode("-",$model->startdate);
            $model->startdate = date("Y-m-d", strtotime(str_replace("/","-",$date[0])));
            $model->enddate = date("Y-m-d", strtotime(str_replace("/","-",$date[1])));
    
            $model->deposit = str_replace('.','',$model->deposit);
            if ($model->out != null)
                $model->out = date("Y-m-d", strtotime($model->out));

            if ($model->save()){
                return $this->redirect(['index']); 
            }
            
            $model->startdate = $strdate;
            $model->enddate = '';

            if ($model->out != null)
                $model->out = date("d-M-Y", strtotime($model->out));

            return $this->render('create', [
                'model' => $model,
            ]); 
        } else {
            $model->startdate = date("d-M-Y", strtotime($model->startdate));
            $model->enddate = date("d-M-Y", strtotime($model->enddate));
            
            $model->startdate = str_replace("-","/", $model->startdate);
            $model->enddate = str_replace("-","/", $model->enddate);

            $model->startdate = $model->startdate . ' - ' . $model->enddate;
            if ($model->out != null)
                $model->out = date("d-M-Y", strtotime($model->out));

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RoomReservation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RoomReservation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RoomReservation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RoomReservation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionReservationList()
    {
        if(isset($_POST))
        {
            $roomid = isset($_POST['room']) ? $_POST['room'] : '';
            $roomtypeid = isset($_POST['roomtype']) ? $_POST['roomtype'] : '';
            $equipments = isset($_POST['equipments']) ? $_POST['equipments'] : [];
            $date = isset($_POST['date']) ? $_POST['date'] : date("D, d-M-Y");

            $date = date("Y-m-d", strtotime($date));
            $str = "'" . $date . "' between ps_roomreservation.startdate and ps_roomreservation.enddate";

            $query = new \yii\db\Query;
            $query->select('ps_room.roomid, ps_room.name, ps_floor.name as floor, ps_roomtype.name as roomtype, ps_roomtype.rate, ps_roomreservation.roomreservationid, ps_roomreservation.startdate, ps_roomreservation.enddate, ps_roomstatus.color, ps_roomstatus.name as status')
                ->distinct('ps_room.roomid, ps_room.name, ps_floor.name as floor, ps_roomtype.name as roomtype, ps_roomtype.rate, ps_roomreservation.roomreservationid, ps_roomreservation.startdate, ps_roomreservation.enddate, ps_roomstatus.color, ps_roomstatus.name as status')
                ->from('ps_room')
                ->leftJoin('ps_roomreservation', 'ps_roomreservation.out is null and ps_roomreservation.cancel = "N" and ps_room.roomid = ps_roomreservation.roomid and ' . $str)
                ->leftJoin('ps_floor', 'ps_room.floorid = ps_floor.floorid')
                ->leftJoin('ps_roomtype', 'ps_roomtype.roomtypeid = ps_room.roomtypeid')
                ->leftJoin('ps_roomtypeequipment', 'ps_room.roomtypeid = ps_roomtypeequipment.roomtypeid')
                ->leftJoin('ps_roomstatus', 'coalesce(ps_roomreservation.roomstatusid, ps_room.roomstatusid) = ps_roomstatus.roomstatusid')
                ->where(['like','ps_room.roomid',$roomid])
                ->andWhere(['like','ps_room.roomtypeid',$roomtypeid]);


            if (count($equipments) > 1){
                $query->andWhere(['in','ps_roomtypeequipment.equipmentid',$equipments]);
            }

            $query->orderBy('ps_room.name');
                
            $rows = $query->all();
            $command = $query->createCommand();
            $rows = $command->queryAll();

            echo(json_encode($rows));   
        }//else{
        //  $this->redirect(array('um/menu'));
        //}
    }

    public function actionGetReservationList(){
        date_default_timezone_set('Asia/Jakarta');
        
        if(isset($_POST) && sizeof($_POST) > 0){
            $roomid = isset($_POST['room']) && $_POST['room'] != '' ? $_POST['room'] : null;
            $roomtypeid = isset($_POST['roomtype']) && $_POST['roomtype'] != '' ? $_POST['roomtype'] : null;
            $equipments = isset($_POST['equipments']) && $_POST['equipments'] != "" ? $_POST['equipments'] : [];

            if (!isset($_POST['date'])){
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                trigger_error("Invalid date format.");
            }

            try{
                $date = new \DateTime($_POST['date']);
            } catch (Exception $e) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                trigger_error("Invalid date format.");
            }
        }else{
            throw new \yii\web\HttpException(404, 'Page not found.');
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $equipmentParam = implode("','", $equipments);

        $query = new \yii\db\Query;
        $command = $query->createCommand();
        $command->setSql("select a.roomid, a.name as room, a.roomtypeid, b.code as roomtype, a.floorid, c.name as floor, 
                    e.customerid, f.name as customer, d.roomstatusid, coalesce(g.name, h.name) as roomstatus, 
                    coalesce(g.color, h.color) as statuscolor, d.reservationdetailid, d.checkin, d.checkout
                from ps_room a
                left join ps_roomtype b on a.roomtypeid = b.roomtypeid
                left join ps_floor c on a.floorid = c.floorid
                left join ps_roomreservationdetail d on a.roomid = d.roomid and 
                    STR_TO_DATE(:3, '%d-%m-%Y') between d.start_date and d.end_date and d.cancel = 0 and d.checkout is null
                left join ps_roomreservation e on e.reservationid = d.reservationid
                left join ps_customer f on e.customerid = f.customerid
                left join ps_roomstatus g on d.roomstatusid = g.roomstatusid
                left join ps_roomstatus h on a.roomstatusid = h.roomstatusid
                where a.roomid = coalesce(:1, a.roomid) and b.roomtypeid = coalesce(:2, b.roomtypeid) and :4 <= (
                    select count(distinct equipmentid) from ps_roomtypeequipment where equipmentid in ('".$equipmentParam."') and roomtypeid = a.roomtypeid
                )
                order by floor, room
            ");
        
        $command->bindValue(':1', $roomid);
        $command->bindValue(':2', $roomtypeid);
        $command->bindValue(':3', $date->format('d-m-Y'));
        $command->bindValue(':4', sizeof($equipments));
        $rows = $command->queryAll();

        echo(json_encode($rows));
    }

    public function actionCreateReservation(){
        $customer = new Customer();
        $customerPhone = new CustomerPhone();
        $customerIdentification = new CustomerIdentification();
        $roomReservation = new RoomReservation();

        return $this->render('newreservation', [
            'roomReservation' => $roomReservation,
            'customer' => $customer,
            'customerPhone' => $customerPhone,
            'customerIdentification' => $customerIdentification,
        ]); 
    }

    public function actionGetRoomList(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $query = new \yii\db\Query;
        $command = $query->createCommand();
        $command->setSql("select a.roomid, a.name as room, a.roomtypeid, b.code as roomtype, a.floorid, c.name as floor, b.rate
                from ps_room a
                left join ps_roomtype b on a.roomtypeid = b.roomtypeid
                left join ps_floor c on a.floorid = c.floorid
                order by room, floor, roomtype
            ");
        
        $rows = $command->queryAll();
        echo(json_encode($rows));
    }

    public function actionRoomRateByDate(){
        date_default_timezone_set('Asia/Jakarta');

        if(isset($_POST) && sizeof($_POST) > 0){
            $date = isset($_POST['date']) ? $_POST['date'] : date('dd-MM-yyyy');
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $query = new \yii\db\Query;
        $command = $query->createCommand();
        $command->setSql("select distinct a.roomid, a.roomtypeid, b.rate, 
                    coalesce(e.percent, 0)/100 * b.rate + coalesce(e.rate, 0) as roomdiscount,
                    coalesce(g.percent, 0)/100 * b.rate + coalesce(g.rate, 0) as roomtypediscount,
                    :1 as date,
                    coalesce(h.color, i.color) as color,
                    case when h.reservationid is not null || i.roomstatusid is not null then 0 else 1 end as book
                from ps_room a
                left join ps_roomtype b on a.roomtypeid = b.roomtypeid
                left join ps_discountroom d on a.roomid = d.roomid
                left join ps_discount e on d.discountid = e.discountid and STR_TO_DATE(:1,'%e-%c-%Y') between e.from_date and coalesce(e.to_date, STR_TO_DATE(:1,'%e-%c-%Y'))
                left join ps_discountroomtype f on b.roomtypeid = f.roomtypeid
                left join ps_discount g on f.discountid = g.discountid and STR_TO_DATE(:1,'%e-%c-%Y') between g.from_date and coalesce(g.to_date, STR_TO_DATE(:1,'%e-%c-%Y'))
                left join (
                    select a.reservationid, b.reservationdetailid, b.roomid, c.name, c.color from ps_roomreservation a
                    join ps_roomreservationdetail b on a.reservationid = b.reservationid
                    join ps_roomstatus c on b.roomstatusid = c.roomstatusid and c.name not like '%vacant%'
                    where STR_TO_DATE(:1,'%e-%c-%Y') between b.start_date and b.end_date and b.cancel = 0 and b.checkout is null
                ) h on a.roomid = h.roomid
                left join ps_roomstatus i on a.roomstatusid = i.roomstatusid and i.name not like '%vacant%'
            ");
        
        $command->bindValue(':1', $date);
        $rows = $command->queryAll();
        echo(json_encode($rows));
    }

    public function actionCreateNewReservation(){
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(isset($_POST) && sizeof($_POST) > 0){
            $customerid = isset($_POST['customerid']) ? $_POST['customerid'] : 0;
            $customername = isset($_POST['customername']) ? $_POST['customername'] : '';
            $customeraddress = isset($_POST['customeraddress']) ? $_POST['customeraddress'] : '';
            $customerlocation = isset($_POST['customerlocation']) ? $_POST['customerlocation'] : '';
            $customerphone = isset($_POST['customerphone']) ? $_POST['customerphone'] : '';
            $customeridentificationtype = isset($_POST['customeridentificationtype']) ? $_POST['customeridentificationtype'] : '';
            $customeridentificationno = isset($_POST['customeridentificationno']) ? $_POST['customeridentificationno'] : '';
            $reservation = isset($_POST['reservation']) ? $_POST['reservation'] : [];
            $deposit = isset($_POST['deposit']) ? $_POST['deposit'] : 0;
            $deposit = str_replace('.','',$deposit);

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();

            try{
                if ($customerid > 0){
                    $customer = Customer::findOne($customerid);
                    if ($customer == null){
                        $transaction->rollback();
                        echo(json_encode("Pelanggan tidak ditemukan. Silahkan pilih opsi pelanggan baru."));
                        return;
                    }
                }else{

                    $customer = new Customer();
                    $customer->name = $customername;
                    $customer->address = $customeraddress;
                    $customer->locationid = $customerlocation;
                    $customer->save();
                    if (!$customer->save()){
                        $transaction->rollback();
                        echo(json_encode($customer->getErrors()));
                        return;
                    }

                    $customerPhone = new CustomerPhone();
                    $customerPhone->phone = $customerphone;
                    $customerPhone->customerid = $customer->customerid;
                    $customerPhone->save();
                    if (!$customerPhone->save()){
                        $transaction->rollback();
                        echo(json_encode($customerPhone->getErrors()));
                        return;
                    }

                    $customerIdentification = new CustomerIdentification();
                    $customerIdentification->identificationtypeid = $customeridentificationtype;
                    $customerIdentification->identificationno = $customeridentificationtype;
                    $customerIdentification->customerid = $customer->customerid;
                    $customerIdentification->save();
                    if (!$customerIdentification->save()){
                        $transaction->rollback();
                        echo(json_encode($customerIdentification->getErrors()));
                        return;
                    }
                }

                $status = \app\models\RoomStatus::find()->where(['like', 'name', 'reserve'])->one();
                if($status == null){
                    $transaction->rollback();
                    echo(json_encode("Status kamar tidak ditemukan."));
                    return;
                }

                $roomReservation = new RoomReservation();
                $roomReservation->customerid = $customer->customerid;
                $roomReservation->date = date("Y-m-d H:i:s");
                $roomReservation->save();
                if (!$roomReservation->save()){
                    $transaction->rollback();
                    echo(json_encode($roomReservation->getErrors()));
                    return;
                }

                $roomDeposit = new ReservationDeposit();
                $roomDeposit->reservationid = $roomReservation->reservationid;
                $roomDeposit->date = date("Y-m-d H:i:s");
                $roomDeposit->rate = $deposit;
                $roomDeposit->save();
                if (!$roomDeposit->save()){
                    $transaction->rollback();
                    echo(json_encode($roomDeposit->getErrors()));
                    return;
                }

                foreach ($reservation as $item) {
                    $room = \app\models\Room::findOne($item["roomid"]);
                    if ($room == null){
                        $transaction->rollback();
                        echo(json_encode("Kamar tidak ditemukan."));
                        return;
                    }

                    $roomReservationDetail = new RoomReservationDetail();
                    $roomReservationDetail->reservationid = $roomReservation->reservationid;
                    $roomReservationDetail->roomid = $room->roomid;
                    $roomReservationDetail->rate = $room->roomtype->rate;
                    $roomReservationDetail->start_date = date("Y-m-d", strtotime($item["date"]));
                    $roomReservationDetail->end_date = date("Y-m-d", strtotime($item["date"]));
                    $roomReservationDetail->roomstatusid = $status->roomstatusid;
                    $roomReservationDetail->save();
                    if (!$roomReservationDetail->save()){
                        $transaction->rollback();
                        echo(json_encode($roomReservationDetail->getErrors()));
                        return;
                    }
                }

                $query = new \yii\db\Query;
                $command = $query->createCommand();
                $command->setSql("insert into ps_discountreservation (discountid, reservationdetailid, rate)
                        select discountid, reservationdetailid, discountrate from (
                            select distinct 'Room' as discounttype, a.reservationdetailid, e.discountid, 
                                (coalesce(e.percent, 0)/100 * c.rate + coalesce(e.rate, 0)) as discountrate
                            from ps_roomreservationdetail a
                            join ps_room b on a.roomid = b.roomid
                            join ps_roomtype c on b.roomtypeid = c.roomtypeid
                            join ps_discountroom d on b.roomid = d.roomid
                            join ps_discount e on d.discountid = e.discountid and a.start_date between e.from_date and coalesce(e.to_date, a.start_date)
                            where a.reservationid = :1 and a.checkin is null
                            union
                            select distinct 'RoomType' as discounttype, a.reservationdetailid, g.discountid, 
                                (coalesce(g.percent, 0)/100 * c.rate + coalesce(g.rate, 0))
                            from ps_roomreservationdetail a
                            join ps_room b on a.roomid = b.roomid
                            join ps_roomtype c on b.roomtypeid = c.roomtypeid
                            join ps_discountroomtype f on c.roomtypeid = f.roomtypeid
                            join ps_discount g on f.discountid = g.discountid and a.start_date between g.from_date and coalesce(g.to_date, a.start_date)
                            where a.reservationid = :1 and a.checkin is null
                        ) a
                    ");
                
                $command->bindValue(':1', $roomReservation->reservationid);
                $rows = $command->execute();

                $transaction->commit();

            } catch (Exception $e) {
                trigger_error($e);
            }

            echo(json_encode(1));

        }else{
            echo(json_encode(0));
            return;
        }
    }

    public function actionCheckIn(){
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(isset($_POST) && sizeof($_POST) > 0){
            $reservationdetailid = isset($_POST['reservationdetailid']) ? $_POST['reservationdetailid'] : null;
            if ($reservationdetailid == null){
                echo(json_encode("Reservasi tidak ditemukan."));
                return;
            }

            $reservationDetail = \app\models\RoomReservationDetail::findOne($reservationdetailid);
            if ($reservationDetail == null){
                echo(json_encode("Reservasi tidak ditemukan."));
                return;
            }

            if ($reservationDetail->checkin != null){
                echo(json_encode("Kamar sedang dipakai."));
                return;   
            }
            
            $status = \app\models\RoomStatus::find()->where(['like', 'name', 'in use'])->one();
            if($status == null){
                echo(json_encode("Status kamar tidak ditemukan."));
                return;
            }

            $reservationDetail->checkin = date("Y-m-d H:i:s");
            $reservationDetail->roomstatusid = $status->roomstatusid;

            if ($reservationDetail->save()){
                echo(json_encode(1));
                return;
            }else{
                echo(json_encode($roomReservationDetail->getErrors()));
                return;
            }
        }else{
            echo(json_encode("Reservasi tidak ditemukan."));
            return;
        }
    }

    public function actionCheckOut(){
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(isset($_POST) && sizeof($_POST) > 0){
            $reservationdetailid = isset($_POST['reservationdetailid']) ? $_POST['reservationdetailid'] : null;
            if ($reservationdetailid == null){
                echo(json_encode("Reservasi tidak ditemukan."));
                return;
            }

            $reservationDetail = \app\models\RoomReservationDetail::findOne($reservationdetailid);
            if ($reservationDetail == null){
                echo(json_encode("Reservasi tidak ditemukan."));
                return;
            }

            if ($reservationDetail->checkin == null){
                echo(json_encode("Kamar belum check in."));
                return;   
            }

            if ($reservationDetail->checkout != null){
                echo(json_encode("Reservasi tidak ditemukan."));
                return;   
            }
            
            $status = \app\models\RoomStatus::find()->where(['like', 'name', 'vacant'])->one();
            if($status == null){
                echo(json_encode("Status kamar tidak ditemukan."));
                return;
            }

            $reservationDetail->checkout = date("Y-m-d H:i:s");
            $reservationDetail->roomstatusid = $status->roomstatusid;

            if ($reservationDetail->save()){
                echo(json_encode(1));
                return;
            }else{
                echo(json_encode($roomReservationDetail->getErrors()));
                return;
            }
        }else{
            echo(json_encode("Reservasi tidak ditemukan."));
            return;
        }
    }

    public function actionCancelReservation(){
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(isset($_POST) && sizeof($_POST) > 0){
            $reservationdetailid = isset($_POST['reservationdetailid']) ? $_POST['reservationdetailid'] : null;
            if ($reservationdetailid == null){
                echo(json_encode("Reservasi tidak ditemukan."));
                return;
            }

            $reservationDetail = \app\models\RoomReservationDetail::findOne($reservationdetailid);
            if ($reservationDetail == null){
                echo(json_encode("Reservasi tidak ditemukan."));
                return;
            }

            if ($reservationDetail->cancel == 1){
                echo(json_encode("Reservasi tidak ditemukan."));
                return;   
            }

            $reservationDetail->cancel = 1;
            if ($reservationDetail->save()){
                echo(json_encode(1));
                return;
            }else{
                echo(json_encode($roomReservationDetail->getErrors()));
                return;
            }
        }else{
            echo(json_encode("Reservasi tidak ditemukan."));
            return;
        }
    }

    public function actionGetCustomerReservations(){
        if(isset($_POST) && sizeof($_POST) > 0){
            $customer = isset($_POST['customer']) ? $_POST['customer'] : null;
            if ($customer == null){
                echo(json_encode(null));
                return;
            }
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $query = new \yii\db\Query;
        $command = $query->createCommand();
        $command->setSql("select a.reservationid, a.customerid, c.name as customer, a.date as reservedate, 
                    b.reservationdetailid, b.roomid, d.name as room, d.roomtypeid, e.code as roomtype, 
                    b.rate, b.start_date, b.end_date, b.checkin, b.checkout
                from ps_roomreservation a
                join ps_roomreservationdetail b on a.reservationid = b.reservationid
                join ps_customer c on a.customerid = c.customerid
                join ps_room d on b.roomid = d.roomid
                join ps_roomtype e on d.roomtypeid = e.roomtypeid
                where a.customerid = :1 and b.cancel = 0 and b.reservationdetailid not in (
                    select reservationdetailid from ps_reservationpayment
                )
                order by b.start_date, d.name, a.date
            ");
        
        $command->bindValue(':1', $customer);
        $rows = $command->queryAll();
        echo(json_encode($rows));
    }
}

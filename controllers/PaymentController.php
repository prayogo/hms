<?php

namespace app\controllers;

use Yii;
use app\models\Payment;
use app\models\PaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Payment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Payment();
        $model_reservation = [];

        if ($model->load(Yii::$app->request->post())) {
            $acc = false;
            if (isset($_POST['Payment']['RoomReservationPayment'])){
                foreach($_POST['Payment']['RoomReservationPayment'] as $reservationid){
                    array_push($model_reservation, $reservationid);
                    $acc = true;
                }
            }

            if (!$acc){
                $model->date = date("d-M-Y", strtotime($model->date));
                $model->addError('customerid', 'Room reservation must be choosen.');
                return $this->render('create', [
                    'model' => $model,
                    'model_reservation' => $model_reservation,
                ]);
            }

            $model->amountpaid = str_replace(",","",$model->amountpaid);
            $model->date = date("Y-m-d", strtotime($model->date));
            
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            $model->save();
            foreach($model_reservation as $reservationid){
                $reservation_save = new \app\models\ReservationPayment();   
                $reservation_save->paymentid = $model->paymentid;
                $reservation_save->roomreservationid = $reservationid;
                $reservation_save->save();
            }

            $transaction->commit();
            return $this->redirect(['view', 'id' => $model->paymentid]);

            $model->date = date("d-M-Y", strtotime($model->date));
            return $this->render('create', [
                'model' => $model,
                'model_reservation' => $model_reservation,
            ]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'model_reservation' => $model_reservation,
            ]);
        }
    }

    /**
     * Deletes an existing Payment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();

        \app\models\ReservationPayment::deleteAll(['paymentid'=>$id]);
        $this->findModel($id)->delete();

        $transaction->commit();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionRoomReservation($customer)
    {
        $query = new \yii\db\Query;
        $query->select(['ps_roomreservation.roomreservationid', 'ps_room.name', 'ps_roomreservation.deposit', 'DATE_FORMAT(ps_roomreservation.startdate, \'%d-%b-%Y\') as startdate', 'DATE_FORMAT(ps_roomreservation.enddate, \'%d-%b-%Y\') as enddate', 'DATE_FORMAT(ps_roomreservation.out, \'%d-%b-%Y\') as checkout'])
            ->distinct(['ps_roomreservation.roomreservationid', 'ps_room.name', 'ps_roomreservation.deposit', 'DATE_FORMAT(ps_roomreservation.startdate, \'%d-%b-%Y\') as startdate', 'DATE_FORMAT(ps_roomreservation.enddate, \'%d-%b-%Y\') as enddate', 'DATE_FORMAT(ps_roomreservation.out, \'%d-%b-%Y\') as checkout'])
            ->from('ps_customer')
            ->innerJoin('ps_roomreservation', 'ps_roomreservation.customerid = ps_customer.customerid and ps_roomreservation.cancel = "N" and ps_roomreservation.out is not null')
            ->leftJoin('ps_room', 'ps_roomreservation.roomid = ps_room.roomid')
            ->where(['ps_customer.customerid' => $customer])
            ->andWhere(['not in', 'ps_roomreservation.roomreservationid', (new \yii\db\Query())->select('roomreservationid')->from('ps_reservationpayment')]);
        $query->orderBy('ps_roomreservation.startdate');
            
        $rows = $query->all();
        $command = $query->createCommand();
        $rows = $command->queryAll();

        echo(json_encode($rows));   
    }

    public function actionRoomReservationRate($reservation)
    {
        
        $reservation = \app\models\RoomReservation::find()->where(['roomreservationid' => $reservation])->one();

        $data[0]["reservation"] = $reservation->roomreservationid;
        $data[0]["date"] = date('d.m.Y', strtotime($reservation->startdate)) . ' - ' . 
            date('d.m.Y', strtotime($reservation->enddate));
        $chargeStr = '';
        $chargeStr = 'Adult@'.$reservation->adult.'-'.$reservation->room->roomtype->maxadult;
        $chargeStr = $chargeStr.', Child@'.$reservation->child.'-'.$reservation->room->roomtype->maxchild;

        $data[0]["service"] = 'Akomodasi ' . $reservation->room->name . ' - ' . $reservation->room->roomtype->name. ' ('.$chargeStr . ')';

        $date = $reservation->startdate;
        $debit = 0;
        $charge = 0;
        while (strtotime($date) < strtotime($reservation->enddate)) {
            $day = date("w", strtotime($date));
            if ($day == '6' || $day == '7'){
                $debit = $debit + $reservation->roomreservationrate->rate + $reservation->roomreservationrate->rate * $reservation->roomreservationrate->weekendrate;
            }else{
                $debit = $debit + $reservation->roomreservationrate->rate;
            }
            $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
            if ($reservation->adult > $reservation->room->roomtype->maxadult){
                $charge += ($reservation->adult - $reservation->room->roomtype->maxadult) * $reservation->room->roomtype->adultcharge;
            }
            if ($reservation->child > $reservation->room->roomtype->maxchild){
                $charge += ($reservation->child - $reservation->room->roomtype->maxchild) * $reservation->room->roomtype->childcharge;
            }
        }

        $data[0]["debit"] = number_format($debit);
        $data[0]["credit"] = '';

        $data[0]["charge"] = number_format($charge);

        $i = 1;
        foreach ($reservation->extraservices as $extra){
            $data[$i]["reservation"] = $reservation->roomreservationid;
            $data[$i]["date"] = date('d.m.Y, H:i', strtotime($extra->date));
            $data[$i]["service"] = $extra->serviceitem->name . ' @' . $extra->quantity;
            $data[$i]["debit"] = number_format($extra->serviceitem->rate * $extra->quantity);
            $data[$i]["credit"] = '';
            $data[$i]["charge"] = 0;
            $i++;
        }

        echo json_encode($data);
    }

    public function actionPrintPayment($paymentid){
        return $this->renderPartial('payment', ['paymentid' => $paymentid]);
    }

    public function actionGetPaymentList(){
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
                    b.rate, b.start_date, b.end_date 
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

    public function actionGetDepositList(){
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
        $command->setSql("select distinct a.reservationid, d.depositid, a.customerid, c.name as customer, d.rate, d.date
                from ps_roomreservation a
                join ps_customer c on a.customerid = c.customerid
                join ps_reservationdeposit d on a.reservationid = d.reservationid
                where d.returndate is null and c.customerid = :1
                order by d.date
            ");
        
        $command->bindValue(':1', $customer);
        $rows = $command->queryAll();
        echo(json_encode($rows));
    }

    public function actionGetPaymentSummary(){
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        //$_POST['reservations'] = [30,31,32,33];
        //$_POST['deposit'] = [];

        if(isset($_POST) && sizeof($_POST) > 0){
            $reservations = isset($_POST['reservations']) ? $_POST['reservations'] : [0];
            $deposits = isset($_POST['deposits']) ? $_POST['deposits'] : [0];
            $param = implode(", ", $reservations);
            $paramDeposit = implode(", ", $deposits);

            $taxConfig = \app\models\Tax::find()->orderBy('taxid desc')->one();

            $sql = 'select * from ps_room where roomid in (
                select distinct roomid from ps_roomreservationdetail
                where reservationdetailid in ('.$param.') and cancel = 0 and reservationdetailid not in (
                    select reservationdetailid from ps_reservationpayment
                )
            ) order by name';

            $rooms = \app\models\Room::findBySql($sql)->all();  
            $json = [];
            foreach ($rooms as $room) {
                $obj = new \stdClass();
                $obj->roomtypeid = $room->roomtypeid;
                $obj->roomtype = $room->roomtype->name;
                $obj->roomid = $room->roomid;
                $obj->room = $room->name;
                $obj->date = date("d-M-Y");
                
                $obj->days = 0;
                $obj->tax = 0;
                $obj->rate = 0;
                $obj->deposit = 0;
                $obj->discount = 0;
                $obj->extras = [];

                //Get reservations
                $sql = 'select * from ps_roomreservationdetail
                    where roomid = '.$room->roomid.' and reservationdetailid in ('.$param.') and cancel = 0 and reservationdetailid not in (
                        select reservationdetailid from ps_reservationpayment
                    )';
                $reservations = \app\models\RoomReservationDetail::findBySql($sql)->all();  
                foreach ($reservations as $detail) {
                    $obj->days++;
                    $obj->rate += $detail->rate;
                    $obj->tax += $taxConfig->room * $detail->rate/100;
                }

                if (count($reservations) > 0){
                    $obj->customername = $reservations[0]->reservation->customer->name;
                    $obj->customeraddr = $reservations[0]->reservation->customer->address;
                    $phones = $reservations[0]->reservation->customer->customerphones;
                    if (count($phones) > 0){
                        $obj->customerphone = $phones[0]->phone;
                    }
                }


                //Get discounts
                $sql = 'select * from ps_discountreservation where reservationdetailid in (
                    select reservationdetailid from ps_roomreservationdetail
                    where roomid = '.$room->roomid.' and reservationdetailid in ('.$param.') and cancel = 0 and reservationdetailid not in (
                        select reservationdetailid from ps_reservationpayment
                    )
                )';
                $discounts = \app\models\DiscountReservation::findBySql($sql)->all();  
                foreach ($discounts as $discount) {
                    $obj->discount += $discount->rate;
                }

                $obj->tax -= $taxConfig->room * $obj->discount/100;

                //Get extra service
                $sql = 'select * from ps_extraservice a
                    where reservationdetailid in (
                        select reservationdetailid from ps_roomreservationdetail
                        where roomid = '.$room->roomid.' and reservationdetailid in ('.$param.') and cancel = 0 and reservationdetailid not in (
                            select reservationdetailid from ps_reservationpayment
                        )
                    )';
                $extras = \app\models\ExtraService::findBySql($sql)->all();  
                foreach ($extras as $extra) {
                    $item = new \stdClass();
                    $item->date = $extra->date;
                    $item->subtotal = 0;
                    $item->details = [];
                    foreach ($extra->extraservicedetails as $detail) {
                        $extradetail = new \stdClass();
                        $extradetail->service = $detail->serviceitem->name;
                        $extradetail->rate = $detail->rate;
                        $extradetail->qty = $detail->quantity;
                        $extradetail->subtotal = $detail->rate * $detail->quantity;
                        array_push($item->details, $extradetail);
                    }
                    array_push($obj->extras, $item);
                }

                //Get deposit
                $sql = 'select * from ps_reservationdeposit a
                        where depositid in ('.$paramDeposit.')
                    ';
                $depositModel = \app\models\ReservationDeposit::findBySql($sql)->all();  
                foreach ($depositModel as $detail) {
                    $obj->deposit += $detail->rate;
                }

                array_push($json, $obj);
            }

            echo(json_encode($json));

        }else{
            echo(json_encode(null));
            return;
        }
    }

    function actionSubmitPayment(){
        date_default_timezone_set('Asia/Jakarta');
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(isset($_POST) && sizeof($_POST) > 0){
            $reservations = isset($_POST['reservations']) ? $_POST['reservations'] : [0];
            $deposits = isset($_POST['deposits']) ? $_POST['deposits'] : [0];
            $param = implode(", ", $reservations);
            $paramDeposit = implode(", ", $deposits);

            if (count($reservations) < 0){
                echo(json_encode('Reservasi tidak ditemukan.'));
                return;
            }

            $sql = 'select distinct * from ps_customer
                where customerid in (
                    select distinct a.customerid from ps_roomreservation a
                    join ps_roomreservationdetail b on a.reservationid = b.reservationid
                    where b.cancel = 0 and b.reservationdetailid not in (
                        select reservationdetailid from ps_reservationpayment
                    ) and b.reservationdetailid in ('.$param.')
                )';
            $customer = \app\models\Customer::findBySql($sql)->one();

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();

            $payment = new \app\models\Payment();
            $payment->customerid = $customer->customerid;
            $payment->date = date("Y-m-d H:i:s");
            if (!$payment->save()){
                $transaction->rollback();
                echo(json_encode($payment->getErrors()));
                return;
            }

            foreach ($reservations as $reservationdetailid) {
                $paymentDetail = new \app\models\ReservationPayment();
                $paymentDetail->paymentid = $payment->paymentid;
                $paymentDetail->reservationdetailid = $reservationdetailid;
                if (!$paymentDetail->save()){
                    $transaction->rollback();
                    echo(json_encode($paymentDetail->getErrors()));
                    return;
                }
            }
            
            $sql = 'select * from ps_reservationdeposit where depositid in ('.$paramDeposit.')';
            $deposits = \app\models\ReservationDeposit::findBySql($sql)->all();
            foreach ($deposits as $detail) {
                $detail->returndate = date("Y-m-d H:i:s");
                if (!$detail->save()){
                    $transaction->rollback();
                    echo(json_encode($detail->getErrors()));
                    return;
                }
            }

            $transaction->commit();

            echo(json_encode(1));
        }else{
            echo(json_encode(0));
            return;
        }
    }


}


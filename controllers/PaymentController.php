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
}


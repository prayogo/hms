<?php

namespace app\controllers;

use Yii;
use app\models\RoomReservation;
use app\models\RoomReservationSearch;
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
               return $this->redirect(['view', 'id' => $model->roomreservationid]); 
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
               return $this->redirect(['view', 'id' => $model->roomreservationid]); 
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
}

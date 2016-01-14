<?php

namespace app\controllers;

use Yii;
use app\models\RoomType;
use app\models\RoomTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \app\models\ESaveRelatedBehavior;
use yii\filters\AccessControl;

/**
 * RoomTypeController implements the CRUD actions for RoomType model.
 */
class RoomTypeController extends Controller
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
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->admin === "Y";
                        }
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
     * Lists all RoomType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoomTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RoomType model.
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
     * Creates a new RoomType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RoomType();

        $model->singleb = 1;
        $model->doubleb = 1;
        $model->extrab = 1;

        $model->maxchild = 1;
        $model->maxadult = 1;

        $model->weekendrate = 0;

        if ($model->load(Yii::$app->request->post())) {
            $model->childcharge = str_replace('.','',$model->varchildCharge);
            $model->adultcharge = str_replace('.','',$model->varadultCharge);
            $model->rate = str_replace('.','',$model->varrate);

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            try {
                if (!$model->save()){

                    $transaction->rollback();

                    if ($model->hasErrors('childcharge')){
                        $model->addError('varchildCharge', $model->errors['childcharge'][0]);
                    }
                    if ($model->hasErrors('adultcharge')){
                        $model->addError('varadultCharge', $model->errors['adultcharge'][0]);
                    }
                    if ($model->hasErrors('rate')){
                        $model->addError('varrate', $model->errors['rate'][0]);
                    }
                    return $this->render('create', [
                        'model' => $model,
                    ]);  
                }
               
                foreach($model->equipments as $equipmentid){
                    $roomEquipment = new \app\models\RoomTypeEquipment();
                    $roomEquipment->roomtypeid = $model->roomtypeid;
                    $roomEquipment->equipmentid = $equipmentid;
                    $roomEquipment->save();                           
                }

                foreach($model->discounts as $discountid){
                    $roomDiscount = new \app\models\DiscountRoomType();
                    $roomDiscount->roomtypeid = $model->roomtypeid;
                    $roomDiscount->discountid = $discountid;
                    $roomDiscount->save();                          
                }

                $transaction->commit();
            } catch(Exception $e) {
                $model->addError('name', $e);
                $transaction->rollback();
            }
            return $this->redirect(['view', 'id' => $model->roomtypeid]);  
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RoomType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->equipments = \yii\helpers\ArrayHelper::map(\app\models\RoomTypeEquipment::find()
            ->where('roomtypeid = :1',[':1'=>$model->roomtypeid])->asArray()->all(), 'equipmentid', 'equipmentid');
        $model->discounts = \yii\helpers\ArrayHelper::map(\app\models\DiscountRoomType::find()
            ->where('roomtypeid = :1',[':1'=>$model->roomtypeid])->asArray()->all(), 'discountid', 'discountid');

        $model->varchildCharge = $model->childcharge;
        $model->varadultCharge = $model->adultcharge;
        $model->varrate = $model->rate;

        if ($model->load(Yii::$app->request->post())) {

            $model->childcharge = str_replace('.','',$model->varchildCharge);
            $model->adultcharge = str_replace('.','',$model->varadultCharge);
            $model->rate = str_replace('.','',$model->varrate);

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 
            
            try {
                if (!$model->save()){

                    $transaction->rollback();

                    if ($model->hasErrors('childcharge')){
                        $model->addError('varchildCharge', $model->errors['childcharge'][0]);
                    }
                    if ($model->hasErrors('adultcharge')){
                        $model->addError('varadultCharge', $model->errors['adultcharge'][0]);
                    }
                    if ($model->hasErrors('rate')){
                        $model->addError('varrate', $model->errors['rate'][0]);
                    }
                    return $this->render('create', [
                        'model' => $model,
                    ]);  
                }

                \app\models\RoomTypeEquipment::deleteAll(
                    'roomtypeid = :1 and equipmentid not in (:2)',
                    [
                        ':1'=>$model->roomtypeid,
                        ':2'=>implode("','",$model->equipments)
                    ]
                );

                foreach($model->equipments as $equipmentid){
                    $existEquipment = \app\models\RoomTypeEquipment::find()->where(
                        'roomtypeid = :1 and equipmentid = (:2)',
                        [
                            ':1'=>$model->roomtypeid,
                            ':2'=>$equipmentid
                        ]
                    )->one();

                    if ($existEquipment == null){
                        $roomEquipment = new \app\models\RoomTypeEquipment();
                        $roomEquipment->roomtypeid = $model->roomtypeid;
                        $roomEquipment->equipmentid = $equipmentid;
                        $roomEquipment->save();   
                    }
                }

                \app\models\DiscountRoomType::deleteAll(
                    'roomtypeid = :1 and discountid not in (:2)',
                    [
                        ':1'=>$model->roomtypeid,
                        ':2'=>implode("','",$model->discounts)
                    ]
                );

                foreach($model->discounts as $discountid){
                    $exist = \app\models\DiscountRoomType::find()->where(
                        'roomtypeid = :1 and discountid = (:2)',
                        [
                            ':1'=>$model->roomtypeid,
                            ':2'=>$discountid
                        ]
                    )->one();

                    if ($exist == null){
                        $roomDiscount = new \app\models\DiscountRoomType();
                        $roomDiscount->roomtypeid = $model->roomtypeid;
                        $roomDiscount->discountid = $discountid;
                        $roomDiscount->save();   
                    }
                }

                $transaction->commit();
            } catch(Exception $e) {
                $model->addError('name', $e);
                $transaction->rollback();
            }
            return $this->redirect(['view', 'id' => $model->roomtypeid]);   
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RoomType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction(); 

        $model = $this->findModel($id);
        \app\models\DiscountRoomType::deleteAll('roomtypeid = :1', [':1'=>$model->roomtypeid]);
        \app\models\RoomTypeEquipment::deleteAll('roomtypeid = :1', [':1'=>$model->roomtypeid]);
        $model->delete();

        $transaction->commit();

        return $this->redirect(['index']);
    }

    /**
     * Finds the RoomType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RoomType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RoomType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace app\controllers;

use Yii;
use app\models\Room;
use app\models\RoomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RoomController implements the CRUD actions for Room model.
 */
class RoomController extends Controller
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
                            return isset(Yii::$app->user->identity) && Yii::$app->user->identity->admin === "Y";
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
     * Lists all Room models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RoomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Room model.
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
     * Creates a new Room model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Room();

        if ($model->load(Yii::$app->request->post())) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            try {
                 if (!$model->save()){
                    $transaction->rollback();
                    return $this->render('create', [
                        'model' => $model,
                    ]);  
                }

                if ($model->discounts != null){
                    foreach($model->discounts as $discountid){
                        $roomDiscount = new \app\models\DiscountRoom();
                        $roomDiscount->roomid = $model->roomid;
                        $roomDiscount->discountid = $discountid;
                        $roomDiscount->save();                          
                    }
                }

                $transaction->commit();
                
            } catch(Exception $e) {
                $model->addError('name', $e);
                $transaction->rollback();
            }

            return $this->redirect(['view', 'id' => $model->roomid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Room model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->discounts = \yii\helpers\ArrayHelper::map(\app\models\DiscountRoom::find()
            ->where('roomid = :1',[':1'=>$model->roomid])->asArray()->all(), 'discountid', 'discountid');

        if ($model->load(Yii::$app->request->post())) {

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            try {
                 if (!$model->save()){
                    $transaction->rollback();
                    return $this->render('create', [
                        'model' => $model,
                    ]);  
                }

                if ($model->discounts != null){
                    \app\models\DiscountRoom::deleteAll(
                        'roomid = :1 and discountid not in (:2)',
                        [
                            ':1'=>$model->roomid,
                            ':2'=>implode("','",$model->discounts)
                        ]
                    );

                    foreach($model->discounts as $discountid){
                        $exist = \app\models\DiscountRoom::find()->where(
                            'roomid = :1 and discountid = (:2)',
                            [
                                ':1'=>$model->roomid,
                                ':2'=>$discountid
                            ]
                        )->one();

                        if ($exist == null){
                            $roomDiscount = new \app\models\DiscountRoom();
                            $roomDiscount->roomid = $model->roomid;
                            $roomDiscount->discountid = $discountid;
                            $roomDiscount->save();   
                        }
                    }
                }else{
                    \app\models\DiscountRoom::deleteAll(
                        'roomid = :1',
                        [
                            ':1'=>$model->roomid,
                        ]
                    );
                }
                
                $transaction->commit();
                
            } catch(Exception $e) {
                $model->addError('name', $e);
                $transaction->rollback();
            }


            return $this->redirect(['view', 'id' => $model->roomid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Room model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction(); 

        $model = $this->findModel($id);
        \app\models\DiscountRoom::deleteAll('roomid = :1', [':1'=>$model->roomid]);
        $model->delete();

        $transaction->commit();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Room model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Room the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Room::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace app\controllers;

use Yii;
use app\models\ExtraService;
use app\models\ExtraServiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ExtraServiceController implements the CRUD actions for ExtraService model.
 */
class ExtraServiceController extends Controller
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
     * Creates a new ExtraService model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new ExtraService();

        if ($model->load(Yii::$app->request->post())) {
            $model->date = date("Y-m-d", strtotime($model->date)) . ' ' . $model->time;
            $model->rate = $model->serviceitem->rate;

            if ($model->save()){
                return $this->redirect(['room-reservation/view', 'id' => $model->roomreservationid]);   
            }

            $model->date = explode(" ",$model->date)[0];
            $model->date = date("d-M-Y", strtotime($model->date));
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
     * Updates an existing ExtraService model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->date = date("Y-m-d", strtotime($model->date)) . ' ' . $model->time;
            $model->rate = $model->serviceitem->rate;

            if ($model->save()){
                return $this->redirect(['room-reservation/view', 'id' => $model->roomreservationid]);   
            }

            $model->date = explode(" ",$model->date)[0];
            $model->date = date("d-M-Y", strtotime($model->date));
            return $this->render('update', [
                'model' => $model,
            ]);
        } else {
            $model->time = date("H:i", strtotime($model->date));
            $model->date = date("d-M-Y", strtotime($model->date));
            
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ExtraService model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id, $roomreservation)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['room-reservation/view', 'id'=>$roomreservation]);
    }

    /**
     * Finds the ExtraService model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExtraService the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExtraService::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

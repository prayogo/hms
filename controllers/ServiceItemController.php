<?php

namespace app\controllers;

use Yii;
use app\models\ServiceItem;
use app\models\ServiceItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ServiceItemController implements the CRUD actions for ServiceItem model.
 */
class ServiceItemController extends Controller
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
     * Lists all ServiceItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ServiceItem model.
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
     * Creates a new ServiceItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ServiceItem();

        if ($model->load(Yii::$app->request->post())) {
            $model->rate = str_replace('.','',$model->varRate);
            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->serviceitemid]);
            } else{
                if ($model->hasErrors('rate')){
                    $model->addError('varRate', $model->errors['rate'][0]);
                }
                return $this->render('create', [
                    'model' => $model,
                ]);
            }   
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ServiceItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->varRate = $model->rate;
        if ($model->load(Yii::$app->request->post())) {
            $model->rate = str_replace('.','',$model->varRate);
            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->serviceitemid]);
            } else{
                if ($model->hasErrors('rate')){
                    $model->addError('varRate', $model->errors['rate'][0]);
                }
                return $this->render('create', [
                    'model' => $model,
                ]);
            }   
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ServiceItem model.
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
     * Finds the ServiceItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ServiceItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ServiceItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

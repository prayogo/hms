<?php

namespace app\controllers;

use Yii;
use app\models\Discount;
use app\models\DiscountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DiscountController implements the CRUD actions for Discount model.
 */
class DiscountController extends Controller
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
     * Lists all Discount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DiscountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Discount model.
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
     * Creates a new Discount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Discount();

        if ($model->load(Yii::$app->request->post())) {
            $model->from_date = date("Y-m-d", strtotime(str_replace("/","-",$model->from_date)));
            $model->to_date = $model->to_date ? date("Y-m-d", strtotime(str_replace("/","-",$model->to_date))) : null;

            $model->amount = intval(str_replace(".", "", $model->amount));

            if ($model->discountby == 'P'){
                $model->rate = null;
                $model->percent = $model->amount;
            }else if ($model->discountby == 'R'){
                $model->rate = $model->amount;
                $model->percent = null;
            }else{
                $model->addError('discountby', 'Discount by cannot be blank.');
            }

            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->discountid]);
            }else{
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
     * Updates an existing Discount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->amount = $model->percent ? $model->percent : $model->rate;
        $model->discountby = $model->percent ? 'P' : 'R';
        $model->from_date = date("d-M-Y", strtotime($model->from_date));
        $model->to_date = $model->to_date ? date("d-M-Y", strtotime($model->to_date)) : null;


        if ($model->load(Yii::$app->request->post())) {
            $model->from_date = date("Y-m-d", strtotime(str_replace("/","-",$model->from_date)));
            $model->to_date = $model->to_date ? date("Y-m-d", strtotime(str_replace("/","-",$model->to_date))) : null;

            $model->amount = intval(str_replace(".", "", $model->amount));

            if ($model->discountby == 'P'){
                $model->rate = null;
                $model->percent = $model->amount;
            }else if ($model->discountby == 'R'){
                $model->rate = $model->amount;
                $model->percent = null;
            }else{
                $model->addError('discountby', 'Discount by cannot be blank.');
            }

            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->discountid]);
            }else{
                return $this->render('update', [
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
     * Deletes an existing Discount model.
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
     * Finds the Discount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Discount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Discount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

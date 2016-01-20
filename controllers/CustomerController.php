<?php

namespace app\controllers;

use Yii;
use app\models\Customer;
use app\models\CustomerPhone;
use app\models\CustomerIdentification;
use app\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
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
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();
        $model->blacklist = 'N';
        $index = 1;
        $index1 = 1;
        $customerPhone = null;
        $customerIdentification = null;
        $model->locationid = "IDN";

        if ($model->load(Yii::$app->request->post())) {
            $model->birthdate = date("Y-m-d", strtotime($model->birthdate));

            $acc = true;

            if (!isset($_POST["CustomerPhone"])){
                $acc = false;
                $phonemodel = new CustomerPhone();
                $phonemodel->addError('phone', 'Phone cannot be blank.');
                $customerPhone[] = $phonemodel;
            }else{
                $phones = $_POST["CustomerPhone"];
                foreach($phones as $phone){
                    $phonemodel = new CustomerPhone();
                    $phonemodel->phone = $phone["phone"];
                    if ($phonemodel->phone == ""){
                        $phonemodel->addError('phone', 'Phone cannot be blank.');
                        $acc = false;
                    } else if (strlen($phonemodel->phone) > 15){
                        $phonemodel->addError('phone', 'Phone should contain at most 15 characters.');
                        $acc = false;
                    }
                    $customerPhone[] = $phonemodel;
                }
            }

            if (!isset($_POST["CustomerIdentification"])){
                $acc = false;
                $identificationmodel = new CustomerIdentification();
                $identificationmodel->addError('identificationno', 'Identification cannot be blank.');
                $customerIdentification[] = $identificationmodel;
            }else{
                $identifications = $_POST["CustomerIdentification"];
                foreach($identifications as $identification){
                    $identificationmodel = new CustomerIdentification();
                    $identificationmodel->identificationtypeid = $identification["identificationtypeid"];
                    $identificationmodel->identificationno = $identification["identificationno"];

                    if ($identificationmodel->identificationtypeid == "" 
                        || $identificationmodel->identificationno == ""){
                        $identificationmodel->addError('identificationno', 'Identification cannot be blank.');
                        $acc = false;
                    } else if (strlen($identificationmodel->identificationno) > 25){
                        $identificationmodel->addError('identificationno', 'Identification should contain at most 25 characters.');
                        $acc = false;
                    }

                    $customerIdentification[] = $identificationmodel;
                }
            }

            if (!$acc){
                $model->birthdate = date("d-M-Y", strtotime($model->birthdate));
                return $this->render('create', [
                    'model' => $model,
                    'index' => $index,
                    'index1' => $index1,
                    'customerPhone' => $customerPhone,
                    'customerIdentification' => $customerIdentification,
                ]);
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            $model->save();
            foreach($customerPhone as $phonemodel){
                $phonemodel->customerid = $model->customerid;
                $phonemodel->save();   
            }

            foreach($customerIdentification as $identificationmodel){
                $identificationmodel->customerid = $model->customerid;
                $identificationmodel->save();   
            }

            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->customerid]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'index' => $index,
                'index1' => $index1,
                'customerPhone' => null,
                'customerIdentification' => null,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $index = 1;
        $index1 = 1;
        $customerPhone = null;
        $customerIdentification = null;
        $model->locationid = "IDN";

        if ($model->load(Yii::$app->request->post())) {
            $model->birthdate = date("Y-m-d", strtotime($model->birthdate));

            $acc = true;

            if (!isset($_POST["CustomerPhone"])){
                $acc = false;
                $phonemodel = new CustomerPhone();
                $phonemodel->addError('phone', 'Phone cannot be blank.');
                $customerPhone[] = $phonemodel;
            }else{
                $phones = $_POST["CustomerPhone"];
                foreach($phones as $phone){
                    $phonemodel = new CustomerPhone();
                    $phonemodel->phone = $phone["phone"];
                    if ($phonemodel->phone == ""){
                        $phonemodel->addError('phone', 'Phone cannot be blank.');
                        $acc = false;
                    } else if (strlen($phonemodel->phone) > 15){
                        $phonemodel->addError('phone', 'Phone should contain at most 15 characters.');
                        $acc = false;
                    }
                    $customerPhone[] = $phonemodel;
                }
            }

            if (!isset($_POST["CustomerIdentification"])){
                $acc = false;
                $identificationmodel = new CustomerIdentification();
                $identificationmodel->addError('identificationno', 'Identification cannot be blank.');
                $customerIdentification[] = $identificationmodel;
            }else{
                $identifications = $_POST["CustomerIdentification"];
                foreach($identifications as $identification){
                    $identificationmodel = new CustomerIdentification();
                    $identificationmodel->identificationtypeid = $identification["identificationtypeid"];
                    $identificationmodel->identificationno = $identification["identificationno"];

                    if ($identificationmodel->identificationtypeid == "" 
                        || $identificationmodel->identificationno == ""){
                        $identificationmodel->addError('identificationno', 'Identification cannot be blank.');
                        $acc = false;
                    } else if (strlen($identificationmodel->identificationno) > 25){
                        $identificationmodel->addError('identificationno', 'Identification should contain at most 25 characters.');
                        $acc = false;
                    }

                    $customerIdentification[] = $identificationmodel;
                }
            }

            if (!$acc){
                $model->birthdate = date("d-M-Y", strtotime($model->birthdate));
                return $this->render('create', [
                    'model' => $model,
                    'index' => $index,
                    'index1' => $index1,
                    'customerPhone' => $customerPhone,
                    'customerIdentification' => $customerIdentification,
                ]);
            }

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction(); 

            $model->save();

            CustomerPhone::deleteAll(
                'customerid = :1',
                [
                    ':1'=>$model->customerid,
                ]
            );

            CustomerIdentification::deleteAll(
                'customerid = :1',
                [
                    ':1'=>$model->customerid,
                ]
            );

            foreach($customerPhone as $phonemodel){
                $phonemodel->customerid = $model->customerid;
                $phonemodel->save();   
            }

            foreach($customerIdentification as $identificationmodel){
                $identificationmodel->customerid = $model->customerid;
                $identificationmodel->save();   
            }

            $transaction->commit();

            return $this->redirect(['view', 'id' => $model->customerid]);
        } else {

            $customerPhone = \app\models\CustomerPhone::find()->where(
                'customerid = :1',[':1'=>$model->customerid,]
            )->all();

            $customerIdentification = \app\models\CustomerIdentification::find()->where(
                'customerid = :1',[':1'=>$model->customerid,]
            )->all();

            $model->birthdate = date("d-M-Y", strtotime($model->birthdate));

            return $this->render('update', [
                'model' => $model,
                'index' => $index,
                'index1' => $index1,
                'customerPhone' => $customerPhone,
                'customerIdentification' => $customerIdentification,
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
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
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionRenderPhone($index)
    {
        $model = new CustomerPhone;
        return $this->renderPartial('phone/_form', array(
            'model' => $model,
            'index' => $index,
        ), false, true);
    }

    public function actionRenderIdentification($index)
    {
        $model = new CustomerIdentification;
        return $this->renderPartial('identification/_form', array(
            'model' => $model,
            'index' => $index,
        ), false, true);
    }
}

<?php

namespace app\controllers;

use Yii;
use app\models\Hotel;
use app\models\Tax;
use app\models\Bank;
use app\models\ContactPerson;
use app\models\HotelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * HotelController implements the CRUD actions for Hotel model.
 */
class HotelController extends Controller
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
     * Lists all Hotel models.
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = new Hotel();
        $tax = new Tax();
        $contact = new ContactPerson();
        $bank = new Bank();

        if (Hotel::find()->orderBy('hotelid desc')->one() != null)
            $model = Hotel::find()->orderBy('hotelid desc')->one();
        if (Tax::find()->orderBy('taxid desc')->one() != null)
            $tax = Tax::find()->orderBy('taxid desc')->one();
        if (ContactPerson::find()->orderBy('contactpersonid desc')->one() != null)
            $contact = ContactPerson::find()->orderBy('contactpersonid desc')->one();
        if (Bank::find()->orderBy('bankid desc')->one() != null)
            $bank = Bank::find()->orderBy('bankid desc')->one();


        if ($model->load(Yii::$app->request->post()) && $tax->load(Yii::$app->request->post()) && 
            $contact->load(Yii::$app->request->post()) && $bank->load(Yii::$app->request->post())) {
          
            $model->save();
            $tax->save();
            $contact->save();
            $bank->save();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'tax' => $tax,
            'contact' => $contact,
            'bank' => $bank,
        ]);
    }

    /**
     * Displays a single Hotel model.
     * @param integer $id
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Hotel();
        $tax = new Tax();
        $contact = new ContactPerson();
        $bank = new Bank();

        if (Hotel::find()->orderBy('hotelid desc')->one() != null)
            $model = Hotel::find()->orderBy('hotelid desc')->one();
        if (Tax::find()->orderBy('taxid desc')->one() != null)
            $tax = Tax::find()->orderBy('taxid desc')->one();
        if (ContactPerson::find()->orderBy('contactpersonid desc')->one() != null)
            $contact = ContactPerson::find()->orderBy('contactpersonid desc')->one();
        if (Bank::find()->orderBy('bankid desc')->one() != null)
            $bank = Bank::find()->orderBy('bankid desc')->one();

        return $this->render('index', [
            'model' => $model,
            'tax' => $tax,
            'contact' => $contact,
            'bank' => $bank,
        ]);
    }

    /**
     * Finds the Hotel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Hotel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Hotel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace app\controllers;

class PaymentHistoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id){
        return $this->render('view',
        	['paymentid' => $id]
        );
    }

    public function actionGetPaymentHistory(){
    	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    	//$_POST['customerid'] = 1;

    	if(isset($_POST) && sizeof($_POST) > 0){
            $customerid = isset($_POST['customerid']) ? $_POST['customerid'] : null;
            $startdate = isset($_POST['startdate']) && $_POST['startdate'] != "" ? $_POST['startdate'] : null;
            $enddate = isset($_POST['enddate']) && $_POST['enddate'] != "" ? $_POST['enddate'] : null;

            if ($customerid == null){
                $obj = new \stdClass();
				$obj->data = [];
	        	echo(json_encode($obj));
	        	return;
            }

            $query = new \yii\db\Query;
	        $command = $query->createCommand();
	        $command->setSql("select a.paymentid, a.customerid, b.name as customer, a.date from ps_payment a
	        		join ps_customer b on b.customerid = a.customerid
					where a.customerid = :1 and a.date between coalesce(:2, a.date) and coalesce(:3, a.date)
					order by a.date
	            ");
	        
	        $command->bindValue(':1', $customerid);
	        $command->bindValue(':2', $startdate);
	        $command->bindValue(':3', $enddate);
	        $rows = $command->queryAll();

			$obj = new \stdClass();
			$obj->data = $rows;

	        echo(json_encode($obj));
        }else{
        	$obj = new \stdClass();
			$obj->data = [];
        	echo(json_encode($obj));
        }
    }

}

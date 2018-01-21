<?php
namespace app\components;

use app\models\Challans;
use yii\base\Component;
use Yii;

class ServiceHelper extends Component{

    /*
     * Returns new bill number as per the current year
     * */
    public function newBillNo(){
        $currentYear = date('y');
        $prefix = $currentYear . '000';
        $maxBIllNo = (new Yii\db\Query())
            ->select('max(bill_no) as bill_no')
            ->from('bill')
            ->where(['like','bill_no',$prefix])
            ->one();
        if(isset($maxBIllNo['bill_no'])){
            $oldIn = str_split($maxBIllNo['bill_no'],5);
            $newBillNo = $prefix . ((int)$oldIn[1] + 1);
        } else {
            $newBillNo = $prefix . '1';
        }
        return $newBillNo;
    }

    /*
     * Returns challan state
     * */
    public function getChallanState($challan_number){
        $challan = Challans::find()
            ->where('challan_number=:cn',[':cn'=>$challan_number])
            ->one();
        return $challan->status;
    }
}
<?php

namespace App\Http\Controllers;

use App\Exports\TransactionExport;
use App\Transaction;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Excel;
use Auth;

class Transaction_Controller extends Controller
{
    //
    public function __construct(){
        //$this->today = date('Y-m-d');
		$this->today = '2019-08-23';
    }

      public static function export(Request $request) 
    { 
        return Excel::download(new TransactionExport($request), 'transaction.xlsx');
    }

    public function bank_to_bank_search(Request $request){
    

        $transactions = Transaction::from('transactions AS t')
            ->join('beneficiaries AS b','b.id','=','t.beneficiary_id')
            ->join('beneficiary_service_centers AS bsc','bsc.id','=','t.beneficiary_service_center_id')
            ->join('mode_centers AS mc','mc.id','=','bsc.mode_center_id')
            ->join('service_modes AS sm','sm.id','=','mc.service_mode_id')
            ->join('service_centers AS sc','sc.id','=','mc.service_center_id')
            ->join('transaction_statuses AS ts','ts.id','=','t.transaction_status_id')
            //kim
            ->join('senders AS s','s.id','=','t.sender_id')
            ->join('users as u','u.id','=','t.user_id')
            ->leftJoin('users as ur','ur.id','=','t.approved_by')
            ->leftJoin('users as us','us.id','=','t.completed_by')
            ->where('sm.flag',1)
            //->whereRaw('t.created_at between ? AND ?',[$from,Carbon::parse($to)->addDay()])

            //change created_at to approved_at as per requested by ma'am mermory for bank to bank report 11/15/2017
            ->whereRaw('t.approved_at between ? AND ?',[$request->input('from'),Carbon::parse($request->input('to'))->addDay()])
            //->whereNotIn('sc.id',[84,95,96,97,12])
            ->where('t.transaction_status_id',$request->input('status'))
            //For security purpose
            // ->where(function ($query){
            //     if (Auth::user()->roles[0]->role =='DirectClient'){
            //         $query->where('t.sender_id',Auth::user()->sender->id);
            //     }
            // })
            ->select('t.receive_amount','t.total_payment','t.charge_amount','t.exchange_rate','t.approved_at','t.tracking_no','t.send_amount','bsc.account_no','sc.service_center','b.fname','b.mname','b.lname','sm.flag','u.fname AS u_fname',
                'u.mname AS u_mname',
                'u.lname AS u_lname',
                'ur.fname AS ur_fname',
                'ur.mname AS ur_mname',
                'ur.lname AS ur_lname',
                'us.fname AS us_fname',
                'us.mname AS us_mname',
                'us.lname AS us_lname',
                's.fname AS s_fname',
                's.mname AS s_mname',
                's.lname AS s_lname')

            ->get();
            return $transactions;
    }

    
    public function search(Request $request){
      ini_set('memory_limit','-1'); 

       return
      $transaction = Transaction::with('user','sender','beneficiary','beneficiary_service_center','beneficiary_service_center.mode_center','beneficiary_service_center.mode_center.service_center','beneficiary_service_center.mode_center.service_mode','completed_by_user','approved_by_user')
      ->when(!empty($request['status_id']) , function ($query) use($request){
        return $query->where('transaction_status_id','=',$request['status_id']);
    }) 
      ->when(!empty($request['tracking_no']) , function ($query) use($request){
        return $query->where('tracking_no','like',$request['tracking_no'].'%');
    })
      ->when(!empty($request['start_date'] && !empty($request['end_date'])) , function ($query) use($request){
        return $query->whereBetween('created_at', [$request['start_date'].' 00:00:00', $request['end_date'].' 22:00:40']);
    })
      ->whereHas('sender', function($q)use($request) {
          $q->where('fname','like' ,$request['sender_f_name'].'%');
          $q->where('lname','like' ,$request['sender_l_name'].'%');
          $q->where(function($q)use($request) {
              $q->where('mname','like',$request['sender_m_name'].'%' )
              ->orWhereNull('mname');
          });

      })
      ->whereHas('beneficiary', function($q)use($request) {
          $q->where('fname','like' ,$request['beneficiary_f_name'].'%');
          $q->where('lname','like' ,$request['beneficiary_l_name'].'%');
          $q->where(function($q)use($request) {
              $q->where('mname','like',$request['beneficiary_m_name'].'%' )
              ->orWhereNull('mname');
          });

      })
      ->get();





  }

  public function austrac_search(Request $request){

   ini_set('memory_limit','-1'); 

 return
      $transaction = Transaction::with('user','sender','beneficiary','beneficiary_service_center','beneficiary_service_center.mode_center','beneficiary_service_center.mode_center.service_center','beneficiary_service_center.mode_center.service_mode','completed_by_user','approved_by_user')
      ->when(!empty($request['status_id']) , function ($query) use($request){
        return $query->where('transaction_status_id','=',$request['status_id']);
    }) 
      ->when(!empty($request['start_date'] && !empty($request['end_date'])) , function ($query) use($request){
        return $query->whereBetween('created_at', [$request['start_date'].' 00:00:00', $request['end_date'].' 22:00:40']);
    })
      ->whereHas('sender', function($q)use($request) {
          $q->where('fname','like' ,$request['sender_f_name'].'%');
          $q->where('lname','like' ,$request['sender_l_name'].'%');
          $q->where(function($q)use($request) {
              $q->where('mname','like',$request['sender_m_name'].'%' )
              ->orWhereNull('mname');
          });

      })
      ->whereHas('beneficiary', function($q)use($request) {
          $q->where('fname','like' ,$request['beneficiary_f_name'].'%');
          $q->where('lname','like' ,$request['beneficiary_l_name'].'%');
          $q->where(function($q)use($request) {
              $q->where('mname','like',$request['beneficiary_m_name'].'%' )
              ->orWhereNull('mname');
          });

      })
      ->get();

  }


  public function counts(){

$data['c_per_day']  = Transaction::
        whereRaw('created_at >= SUBDATE(now(),INTERVAL 28 DAY)')
            ->select(DB::raw('DATE_FORMAT(created_at,"%a, %b %d %Y") AS created, COUNT(*) AS total,
               FORMAT(SUM(total_payment),2) AS payment_total,
             FORMAT(SUM(charge_amount),2) AS charge_total,
             FORMAT(SUM(total_payment) - SUM(charge_amount),2)  AS remit_total,
             FORMAT(ROUND(((SUM(total_payment) - SUM(charge_amount)) * ROUND(AVG(exchange_rate),2)),2),2) AS send_total,
             ROUND(AVG(exchange_rate),2)  AS rate_ave '))
            ->groupBy(DB::raw('DATE_FORMAT(created_at,"%a %b %d %Y")'))
            ->orderBy(DB::raw('DATE_FORMAT(created_at,"%Y"), DATE_FORMAT(created_at,"%m"),DATE_FORMAT(created_at,"%d")'))
            ->get(); 


    
      $data['r_per_month'] = Transaction::select(DB::raw('DISTINCT YEAR(created_at) AS year , DATE_FORMAT(created_at, "%M") AS month , FORMAT(count(*),2) as count'))
           ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
      ->get();
    //for count voulune per month//
      $data['c_v_per_month'] = Transaction::select(DB::raw('DISTINCT FORMAT(sum(charge_amount),2) as charge,FORMAT(AVG(exchange_rate),2) as avarage_rate,FORMAT(sum(receive_amount),2) as receive_amount,FORMAT(sum(send_amount),2) as send_amount_php, YEAR(created_at) AS year , DATE_FORMAT(created_at, "%M") AS month ,FORMAT(SUM(total_payment),2) as total_payment, FORMAT(count(*),2) as count'))
           ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
      ->get();

      return $data;
  }

  public function transaction(){
    return
    $transaction = Transaction::with('user','sender','beneficiary','beneficiary_service_center','beneficiary_service_center.mode_center','beneficiary_service_center.mode_center.service_center','beneficiary_service_center.mode_center.service_mode','completed_by_user','approved_by_user')
    ->where('created_at','like',date('Y-m-d').'%')
    ->get();


}
public function transaction_logs()
{
    $logs = Transaction::select('tracking_no as trackingNo', 'created_at as createdAt')
    ->where('created_at','like',$this->today.'%')
    ->orderBy('created_at','desc')
    ->limit(5)
    ->get();

    return json_encode($logs);
}

public function daily_transaction(){
    $total = Transaction::from('transactions as t')
    ->selectRaw('a.agent_code as agentCode, SUM(t.charge_amount) AS serviceCharge, 
        SUM(t.send_amount) +  SUM(t.charge_amount) AS totalPayment, COUNT(*) AS `count`')
    ->leftJoin('agents as a', 'a.id','=','t.agent_id')
    ->where('t.created_at', 'like',$this->today.'%')
    ->groupBy('t.agent_id')
    ->get();
    return json_encode($total);
}

public function find_transaction_group($agent=null){
    $transaction = Transaction::
    join('agents','agents.id','=','transactions.agent_id')
    ->where(function ($query) use ($agent){
        if($agent){
            $query->where('agents.id','=',$agent);
        }
    })
    ->select('agent_id','business_name',DB::raw('TRUNCATE(SUM(total_payment) - (SUM(charge_amount)/2),2) AS TotalPayable,
        (SELECT IFNULL(SUM(payment_amount),0)
        FROM agent_payments   
        WHERE agent_id = transactions.agent_id) AS TotalAgentPayment,
        (TRUNCATE(SUM(total_payment) - (SUM(charge_amount)/2),2)-(SELECT IFNULL(SUM(payment_amount),0)
        FROM agent_payments   
        WHERE agent_id = transactions.agent_id)) AS TotalAgentBalance'))
    ->groupBy('agents.id')
    ->get();

    return json_encode($transaction);
}

public function transaction_chart()
{
    $data = Transaction::where('created_at','like',$this->today.'%')
    ->select(DB::raw('SUM(transaction_status_id=1) AS verification, 
        SUM(transaction_status_id=2) AS approved,
        SUM(transaction_status_id=3) AS completed'))->get();

    return json_encode($data,JSON_NUMERIC_CHECK);
}

public function transaction_list()
{
    $to = date('Y-m-d',strtotime('+1 days'));
    $from = date('Y-m-d',strtotime("-1 days"));
    $data = DB::table('transactions as t')
    ->select(DB::raw('ts.status as status, 
        CONCAT(u.fname,", ",u.lname) AS createdBy, 
        CONCAT(s.lname,", ",s.fname) AS sender, 
        CONCAT(b.lname,", ",b.fname) AS beneficiary, 
        s.contact_no as senderContact, 
        b.contact_no as beneficiaryContact,
        (t.charge_amount+t.send_amount) AS total, 
        t.created_at as createdAt,
        t.tracking_no as trackingNo,
        t.send_amount as sendAmount,
        t.exchange_rate as exchangeRate,
        t.charge_amount as serviceFee,
        t.receive_amount as recievedAmount'                                         
    ))
    ->leftjoin('users as u', 'u.id','=','t.user_id')
    ->leftjoin('senders as s', 's.id','=','t.sender_id')
    ->leftjoin('transaction_statuses AS ts', 'ts.id', '=', 't.transaction_status_id')
    ->leftjoin('beneficiaries AS b', 'b.id','=','t.beneficiary_id')
    ->whereBetween('t.created_at',[$from, $to])
    ->get();

    return json_encode($data);
}
}

<?php

namespace App\Exports;

use App\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionExport implements FromView	
{

	public function __construct($request)
	{
		$this->request = $request;
	}
	public function view(): View
	{

		ini_set('memory_limit','-1'); 
		
		$request = $this->request;
		return view('admin.exports.transaction', [
			'transaction' =>  Transaction::with('user','sender','beneficiary','beneficiary_service_center','beneficiary_service_center.mode_center','beneficiary_service_center.mode_center.service_center','beneficiary_service_center.mode_center.service_mode','completed_by_user','approved_by_user')
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
			->get()
		]

	);
	}

}

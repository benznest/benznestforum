<?php namespace App\Http\Controllers;
use Input; 
use DB;

class ReportController extends Controller {

	public function getDataReportCategory(){
		$sql_select =  "SELECT  COUNT(*) as count_topic,G.tag_name
						FROM 	tag G,tag_topic T
						WHERE   G.tag_id = T.tag_id
						GROUP BY G.tag_id";

		$data_req_report = DB::select($sql_select);
		return $data_req_report;
	}
}

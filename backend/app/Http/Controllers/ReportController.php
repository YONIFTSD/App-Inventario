<?php

namespace App\Http\Controllers;

use App\Exports\ReportMonthUtilityAccountReceivableExport;
use App\Exports\ReportMonthUtilityDailySettlementExport;
use App\Exports\ReportMonthUtilityExport;
use App\Exports\ReportMonthUtilityManagementExport;
use App\Exports\ReportUtilityAccountReceivableExport;
use App\Exports\ReportUtilityDailySettlementExport;
use App\Exports\ReportUtilityExport;
use App\Exports\ReportUtilityManagementExport;
use App\Models\Business;
use App\Models\DataManager;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function UtilityDailySettlement(Request $request){
        try{
            $result = Report::UtilityDailySettlement($request->from,$request->to,$request->coin);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function UtilityManagement(Request $request){
        try{
            $result = Report::UtilityManagement($request->from,$request->to,$request->coin);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function UtilityAccountReceivable(Request $request){
        try{
            $result = Report::UtilityAccountReceivable($request->from,$request->to,$request->coin);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function Utility(Request $request){
        try{
            $result = Report::Utility($request->from,$request->to,$request->coin);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }



    public function MonthUtilityDailySettlement(Request $request){
        try{
            $result = Report::MonthUtilityDailySettlement($request->month);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function MonthUtilityManagement(Request $request){
        try{
            $result = Report::MonthUtilityManagement($request->month);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function MonthUtilityAccountReceivable(Request $request){
        try{
            $result = Report::MonthUtilityAccountReceivable($request->month);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function MonthUtility(Request $request){
        try{
            $result = Report::MonthUtility($request->month);
            return response()->json(['status' => 200,'result' => $result]);
        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }



    //excel
    public function ExcelUtilityDailySettlement($from,$to,$coin){
        try{
            set_time_limit(0);
            ini_set('memory_limit', '2G');
            $report = Report::UtilityDailySettlement($from,$to,$coin);
            $business = Business::GetBusinessInfo();

            $data = array(
                'report' => $report,
                'business' => $business,
            );
            return Excel::download(new ReportUtilityDailySettlementExport($data), 'R. Utilidad de Liq Diaria.xlsx');

        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function ExcelUtilityManagement($from,$to,$coin){
        try{
            set_time_limit(0);
            ini_set('memory_limit', '2G');
            $report = Report::UtilityManagement($from,$to,$coin);
            $business = Business::GetBusinessInfo();

            $data = array(
                'report' => $report,
                'business' => $business,
            );
            return Excel::download(new ReportUtilityManagementExport($data), 'R. Gastos.xlsx');

        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function ExcelUtilityAccountReceivable($from,$to,$coin){
        try{
            set_time_limit(0);
            ini_set('memory_limit', '2G');
            $report = Report::UtilityAccountReceivable($from,$to,$coin);
            $business = Business::GetBusinessInfo();

            $data = array(
                'report' => $report,
                'business' => $business,
            );
            return Excel::download(new ReportUtilityAccountReceivableExport($data), 'R. Util. Gest. Cobros.xlsx');

        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function ExcelUtility($from,$to,$coin){
        try{
            set_time_limit(0);
            ini_set('memory_limit', '2G');
       
            $report = Report::Utility($from,$to,$coin);
            $business = Business::GetBusinessInfo();

            $data = array(
                'report' => $report,
                'business' => $business,
            );
            return Excel::download(new ReportUtilityExport($data), 'R. Utililidad.xlsx');

        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }




     //excel

     
    public function ExcelMonthUtilityDailySettlement($month){
        try{
            set_time_limit(0);
            ini_set('memory_limit', '2G');
            $report = Report::MonthUtilityDailySettlement($month);
            $business = Business::GetBusinessInfo();
            $year = Carbon::parse($month)->format('Y');
            $month = Carbon::parse($month)->format('m');
            $data = array(
                'report' => $report,
                'business' => $business,
                'month' => DataManager::NameMonth($month)." del ".$year,
            );
            return Excel::download(new ReportMonthUtilityDailySettlementExport($data), 'R. Util. Men. Liq Diaria.xlsx');

        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


    public function ExcelMonthUtilityManagement($month){
        try{
            set_time_limit(0);
            ini_set('memory_limit', '2G');
            $report = Report::MonthUtilityManagement($month);
            $business = Business::GetBusinessInfo();
            $year = Carbon::parse($month)->format('Y');
            $month = Carbon::parse($month)->format('m');
            $data = array(
                'report' => $report,
                'business' => $business,
                'month' => DataManager::NameMonth($month)." del ".$year,
            );
            return Excel::download(new ReportMonthUtilityManagementExport($data), 'R. Gastos Externos.xlsx');

        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }

    public function ExcelMonthUtilityAccountReceivable($month){
        try{
            set_time_limit(0);
            ini_set('memory_limit', '2G');
            $report = Report::MonthUtilityAccountReceivable($month);
            $business = Business::GetBusinessInfo();
            $year = Carbon::parse($month)->format('Y');
            $month = Carbon::parse($month)->format('m');
            $data = array(
                'report' => $report,
                'business' => $business,
                'month' => DataManager::NameMonth($month)." del ".$year,
            );
            return Excel::download(new ReportMonthUtilityAccountReceivableExport($data), 'R. Util. Men. Gest. Cobros.xlsx');

        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }



    public function ExcelMonthUtility($month){
        try{
            set_time_limit(0);
            ini_set('memory_limit', '2G');
            $report = Report::MonthUtility($month);
            $business = Business::GetBusinessInfo();
            $year = Carbon::parse($month)->format('Y');
            $month = Carbon::parse($month)->format('m');
            $data = array(
                'report' => $report,
                'business' => $business,
                'month' => DataManager::NameMonth($month)." del ".$year,
            );
            return Excel::download(new ReportMonthUtilityExport($data), 'R. Utililidad Men.xlsx');

        } catch (\Exception $e){   
            return response()->json(['status' => 400,'message' => 'A ocurrido un error', 'result' => $e->getMessage()]);
        }
    }


}

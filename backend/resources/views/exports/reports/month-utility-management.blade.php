@php
    $business = ($data['business']);
    $report = $data['report'];
    $detail_expense = $report['detail_expense'];
    $detail_income = $report['detail_income'];
    $total = $report['total'];
    $month = $data['month'];
    
    // dd($report);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>R. Gastos Externos</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td colspan="2" style="background-color: #007bff; color: #ffffff">Empresa:</td>
                <th colspan="6">{{ $business->name }}</th>
            </tr>
            <tr>
                <td colspan="2" style="background-color: #007bff; color: #ffffff">RUC:</td>
                <th colspan="6" style="text-align: left">{{ $business->document_number }}</th>
            </tr>
            <tr>
                <td colspan="2" style="background-color: #007bff; color: #ffffff">Fecha:</td>
                <th colspan="6">{{ date('Y-m-d') }}</th>
            </tr>

            <tr>
                <th></th>
            </tr>

            <tr>
                <th style="background-color: #007bff; color: #ffffff; text-align: center;" colspan="5">R. DE GASTOS EXTERNOS - {{ $month}}</th>
            </tr>

            <tr>
                <th></th>
            </tr>

            <tr>
                <th colspan="5" style="background-color: #007bff; color: #ffffff; text-align: center;">INGRESO MENSUAL</th>
            </tr>
            <tr>
                <th style="background-color: #007bff; color: #ffffff; text-align: center;">#</th>
                <th style="background-color: #007bff; color: #ffffff; text-align: center;">Mes</th>
                <th style="background-color: #007bff; color: #ffffff; text-align: center;">Descripción</th>
                <th style="background-color: #007bff; color: #ffffff; text-align: center;">T. USD</th>
                <th style="background-color: #007bff; color: #ffffff; text-align: center;">T. PEN</th>
            </tr>
      
            @for ($i = 0; $i < count($detail_income); $i++)
            <tr>
                <th>{{ $i +1}}</th>
                <th>{{ $detail_income[$i]['year']." - ".$detail_income[$i]['month']  }}</th>
                <th>{{ $detail_income[$i]['description'] }}</th>
                <th>{{ $detail_income[$i]['total_usd'] }}</th>
                <th>{{ $detail_income[$i]['total_pen'] }}</th>
            </tr>
            @endfor
            <tr>
                <th style="text-align: center;" colspan="3">TOTALES</th>
                <th>{{$total['income_usd']}}</th>
                <th>{{$total['income_pen']}}</th>
            </tr>
           
           
            <tr>
                <th></th>
            </tr>

            <tr>
                <th></th>
            </tr>


            <tr>
                <th colspan="5" style="background-color: #007bff; color: #ffffff; text-align: center;">EGRESO MENSUAL</th>
            </tr>
            <tr>
                <th style="background-color: #007bff; color: #ffffff; text-align: center;">#</th>
                <th style="background-color: #007bff; color: #ffffff; text-align: center;">Mes</th>
                <th style="background-color: #007bff; color: #ffffff; text-align: center;">Descripción</th>
                <th style="background-color: #007bff; color: #ffffff; text-align: center;">T. USD</th>
                <th style="background-color: #007bff; color: #ffffff; text-align: center;">T. PEN</th>
            </tr>
            @for ($i = 0; $i < count($detail_expense); $i++)
            <tr>
                <th>{{ $i +1}}</th>
                <th>{{ $detail_expense[$i]['year']." - ".$detail_expense[$i]['month']  }}</th>
                <th>{{ $detail_expense[$i]['description'] }}</th>
                <th>{{ $detail_expense[$i]['total_usd'] }}</th>
                <th>{{ $detail_expense[$i]['total_pen'] }}</th>
            </tr>
            @endfor
            <tr>
                <th style="text-align: center;" colspan="3">TOTALES</th>
                <th>{{$total['expense_usd']}}</th>
                <th>{{$total['expense_pen']}}</th>
            </tr>

            
            <tr>
                <th></th>
            </tr>

            <tr>
                <th></th>
            </tr>

            
            <tr>
                <th colspan="2"></th>
                <th style="background-color: #007bff; color: #ffffff; text-align: right;">Restante Efectivo PEN</th>
                <th>{{$total['balance_pen']}}</th>
            </tr>
            <tr>
                <th colspan="2"></th>
                <th style="background-color: #007bff; color: #ffffff; text-align: right;">Restante Efectivo USD</th>
                <th>{{$total['balance_usd']}}</th>
            </tr>
            
           
        </thead>
        <tbody>
   
        </tbody>
    </table>
</body>
</html>


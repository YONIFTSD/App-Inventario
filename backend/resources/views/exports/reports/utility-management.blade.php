@php
    $business = ($data['business']);
    $report = $data['report'];
    $title = $report['title'];
    $income = $report['income'];
    $expense = $report['expense'];
    $balance = $report['balance'];
    $balance_final = $report['balance_final'];
    // dd($title);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>R. Gastos Acumulado</title>
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
                <th style="background-color: #007bff; color: #ffffff; text-align: center;" colspan="{{count($title)+1}}">
                    REPORTE DE GASTOS EXTERNOS</th>
            </tr>

            <tr>
                <th></th>
            </tr>
            
            <tr>
                <th  style="background-color: #007bff; color: #ffffff"></th>
                @for ($i = 0; $i < count($title); $i++)
                <th  style="background-color: #007bff; color: #ffffff; text-align: center;">{{$title[$i]}}</th>
                @endfor
            </tr>
            <tr>
                <th  style="background-color: #007bff; color: #ffffff">INGRESOS</th>
                @for ($i = 0; $i < count($income); $i++)
                <th>{{$income[$i]}}</th>
                @endfor
            </tr>
            <tr>
                <th  style="background-color: #007bff; color: #ffffff">EGRESOS</th>
                @for ($i = 0; $i < count($expense); $i++)
                <th>{{$expense[$i]}}</th>
                @endfor
            </tr>
            <tr>
                <th  style="background-color: #007bff; color: #ffffff">RESULTADO</th>
                @for ($i = 0; $i < count($balance); $i++)
                <th>{{$balance[$i]}}</th>
                @endfor
            </tr>
            <tr>
                <th  style="background-color: #007bff; color: #ffffff">SALDO ACUMULADO</th>
                @for ($i = 0; $i < count($balance_final); $i++)
                <th>{{$balance_final[$i]}}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
   
        </tbody>
    </table>
</body>
</html>


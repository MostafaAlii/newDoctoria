<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>anlysis</title>
    <style>
        * {
            font-family: Arial, sans-serif;
        }

        .flex-container {
            margin-bottom: 130px;
        }

        .flex-container div {
            display: inline;
        }

        .flex-container h3 {
            display: inline-block;
            margin: 10px;
        }

        .text-right {
            display: flex !important;
            justify-content: end;
            padding: 0;
            margin: 0;
        }

        ul li {
            font-size: 17px;
            padding: 8px;
        }

        .diagnosis, .diagnosis th, .diagnosis td {
            border: 1px solid black;
        }

        .diagnosis th, .diagnosis td {
            padding: 10px;
        }
    </style>
</head>
<body>
<header class="flex-container">
    <div style="width: 50%; float: left;">
        <h3 style="display: block;">Doctoria</h3>
        @if($type == 'analysis')
            <h3>Analysis & Imaging Study</h3>
        @elseif($type == 'diagnoses')
            <h3>Disease</h3>
        @endif
    </div>
    <div style="width: 50%; float: right;">
        <h3 class="text-right">دكتوريا</h3>
        @if($type == 'analysis')
        <h3 class="text-right">تحليل & وصور اشعة طيبة</h3>
        @elseif($type == 'diagnoses')
        <h3>وصفة طيبة</h3>
        @endif
    </div>
</header>

<div style="margin-left: 20px;">
    <table style="width: 90%; font-weight: 400;">
        <tr>
            <th style="text-align: left;">Physician Name</th>
            <th>اسم الدكتور</th>
            <th style="text-align: left;">{{$replay->doctor->name}}</th>
        </tr>
        <tr>
            <th style="text-align: left;">Patient Name</th>
            <th>اسم المراجع</th>
            <th style="text-align: left;">{{$booking->patient->name}}</th>
        </tr>
        {{-- <tr>
            <th style="text-align: left;">Date Of Birth</th>
            <th>تاريخ الميلاد</th>
            <th style="text-align: left;">May, 31, 200</th>
        </tr> --}}
        <tr>
            <th style="text-align: left;">Visit Date</th>
            <th>تاريخ الزيارة</th>
            <th style="text-align: left;">Jan, 15. 2024</th>
        </tr>
        <tr>
            <th style="text-align: left;">Gender</th>
            <th>الجنس</th>
            <th style="text-align: left;">{{$booking->patient->gender}}</th>
        </tr>
    </table>
</div>
@if($type == 'analysis')
<div>
    <h3>Analytics</h3>

    <table class="diagnosis" style="width: 100%;">
        <tr>
            <th>Name</th>
            <th>Laboratory</th>
            <th>Notes</th>
        </tr>
        @foreach ($replay->replyingBookingAnalysis as $item)
            <tr>
                <td>{{$item->analysis->name}}</td>
                <td>{{$item->laboratory->name}}</td>
                <td>{{$item->notes}}</td>
            </tr>
        @endforeach

  
    </table>
</div>
@elseif($type == 'diagnoses')
<div>
    <h3>Diagnosis:</h3>
    <table class="diagnosis" style="width: 100%;">

        <tr>
            <th style="padding: 15px;">Disease</th>
        </tr>
        @foreach($replay->replyingBookingDiagnoses as $row)
        <tr>
            <th style="text-align: left; padding: 15px;">{{$row->diagnosis->diagnosis}}</th>
        </tr>
        @endforeach
    </table>
</div>

<div>
    <h3 style="width: 100%;">Medications:</h3>
    <table style="width: 100%;">
        <tr>
            <th style="padding: 10px;">Medications</th>
            <th style="padding: 10px;">Insructions</th>
        </tr>
        @foreach($replay->replyingBookingMedicals as $row)
            <tr>
                <th style="padding: 10px;">{{$row->medicationUnit->unit}}</th>
                <th style="padding: 10px;">{{$row->notes}}</th>
            </tr>
        @endforeach

    </table>
</div>
@endif

<div style="text-align: center;">
    <h4>اسم الطبيب و توقعيه</h4>
    <h4>Physician name and signature</h4>
    <h4>{{$replay->doctor->name}}</h4>
</div>
</body>
</html>

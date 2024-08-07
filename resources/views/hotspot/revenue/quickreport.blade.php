<!DOCTYPE html>
<html>
<head>
    <title>Revenue Report for {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            /* background: #f7f8fc; */
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        h1, h2 {
            color: #007BFF;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 30px;
        }
        h2 {
            font-size: 20px;
            margin-top: 20px;
        }
        .content {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table thead th {
            background: #f8f8f8;
            font-weight: bold;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #ddd !important;
        }
        .text-success {
            color: green;
        }
        .text-danger {
            color: red;
        }
        .chart {
            text-align: center;
            margin-bottom: 40px;
            page-break-inside: avoid;
        }
        .chart img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            padding: 10px;
            background: #f8f8f8;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Hotspot Revenue Report for {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</h1>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Revenue Difference</th>
                    <td class="{{ $revenueDifference >= 0 ? 'text-success' : 'text-danger' }}">
                        Ksh {{ number_format($revenueDifference, 2) }} ({{ $revenueDifferenceText }})
                    </td>
                </tr>
                <tr>
                    <th>Total Revenue</th>
                    <td>Ksh {{ number_format($totalRevenue, 2) }}</td>
                </tr>
                <tr>
                    <th>Total Payments</th>
                    <td>{{ $totalPayments }}</td>
                </tr>
                <tr>
                    <th>Growth from Previous Month</th>
                    <td class="{{ $growth >= 0 ? 'text-success' : 'text-danger' }}">
                        {{ is_null($growth) ? 'N/A' : number_format($growth, 2) . ' %' }}
                    </td>
                </tr>
                <tr>
                    <th>Previous Month Revenue</th>
                    <td>Ksh {{ number_format($previousMonthRevenue, 2) }}</td>
                </tr>
                <tr>
                    <th>Previous Month Payments</th>
                    <td>{{ $previousMonthPayments }}</td>
                </tr>
                <tr>
                    <th>Average Daily Revenue</th>
                    <td>Ksh {{ number_format($averageDailyRevenue, 2) }}</td>
                </tr>
                <tr>
                    <th>Median Daily Revenue</th>
                    <td>Ksh {{ number_format($medianDailyRevenue, 2) }}</td>
                </tr>
                <tr>
                    <th>Highest Single-Day Revenue</th>
                    <td>Ksh {{ number_format($highestSingleDayRevenue, 2) }}</td>
                </tr>
                <tr>
                    <th>Lowest Single-Day Revenue</th>
                    <td>Ksh {{ number_format($lowestSingleDayRevenue, 2) }}</td>
                </tr>
                <tr>
                    <th>Top 5 Revenue Days</th>
                    <td>
                        <ul>
                            @foreach($top5RevenueDays as $day => $revenue)
                                <li>{{ $day }} ({{ \Carbon\Carbon::parse($day)->format('l') }}): Ksh {{ number_format($revenue, 2) }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</body>
</html>

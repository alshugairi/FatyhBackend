<!DOCTYPE html>
<html dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .header-container {
            width: 100%;
            margin-bottom: 30px;
        }
        .main-header {
            width: 100%;
            border-bottom: 2px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        .header-left {
            width: 50%;
            float: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
        }
        .header-right {
            width: 50%;
            float: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};
            text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};
        }
        .company-name {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 18px;
            color: #666;
            margin-bottom: 5px;
        }
        .meta-info {
            font-size: 12px;
            color: #666;
            line-height: 1.5;
        }
        .clearfix {
            clear: both;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }};
            font-size: 12px;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .page-number {
            text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }};
            font-size: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="header-container">
    <div class="main-header">
        <div class="header-left">
            <div class="company-name">{{ get_setting('company_name', 'Shopifyze') }}</div>
            <div class="report-title">{{ __('admin.products_report') }}</div>
        </div>
        <div class="header-right">
            <div class="meta-info">
                <div>{{ __('admin.report_no') }}: PRD-{{ date('Ymd') }}-{{ random_int(1000, 9999) }}</div>
                <div>{{ __('admin.generated_date') }}: {{ now()->format('Y-m-d H:i:s') }}</div>
                <div>{{ __('admin.total_records') }}: {{ count($data) }}</div>
                @if(isset($filters['date_from']) && isset($filters['date_to']))
                    <div>{{ __('admin.date_range') }}: {{ $filters['date_from'] }} - {{ $filters['date_to'] }}</div>
                @endif
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="page-number">
        {{ __('admin.page') }} {PAGENO}/{nbpg}
    </div>
</div>

<table autosize="1">
    <thead>
    <tr>
        @foreach($headings as $heading)
            <th>{{ $heading }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>
            @foreach($row as $cell)
                <td>{{ $cell }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

<div style="text-align: center; font-size: 10px; margin-top: 20px; color: #666;">
    {{ get_setting('company_name', 'Shopifyze') }} © {{ date('Y') }} - {{ __('admin.products_report') }}
</div>
</body>
</html>

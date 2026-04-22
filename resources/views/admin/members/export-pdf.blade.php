<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #0ea5e9;
            padding-bottom: 15px;
        }
        
        .header h1 {
            color: #0f172a;
            font-size: 24px;
            margin-bottom: 8px;
        }
        
        .header .subtitle {
            color: #64748b;
            font-size: 12px;
        }
        
        .info {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            background: #f8fafc;
            padding: 10px 15px;
            border-radius: 8px;
            border-left: 4px solid #0ea5e9;
        }
        
        .info-item {
            font-size: 11px;
            color: #334155;
        }
        
        .info-label {
            font-weight: bold;
            color: #0f172a;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        th {
            background: #0ea5e9;
            color: white;
            padding: 12px 10px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #0284c7;
        }
        
        td {
            padding: 8px 10px;
            border: 1px solid #e2e8f0;
            text-align: center;
            vertical-align: middle;
        }
        
        tr:nth-child(even) {
            background: #f8fafc;
        }
        
        tr:hover {
            background: #f1f5f9;
        }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
        
        .badge-password {
            font-family: monospace;
            background: #fef3c7;
            color: #d97706;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10px;
        }
        
        .text-left {
            text-align: left;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .font-bold {
            font-weight: bold;
        }
        
        @page {
            margin: 20px;
            size: landscape;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <div class="subtitle">Perpustakaan Digital</div>
    </div>
    
    <div class="info">
        <div class="info-item">
            <span class="info-label">Tanggal Cetak:</span> {{ $date }}
        </div>
        <div class="info-item">
            <span class="info-label">Total Anggota:</span> {{ $total }} orang
        </div>
        <div class="info-item">
            <span class="info-label">Status:</span> Aktif
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Username</th>
                <th width="20%">Nama Lengkap</th>
                <th width="15%">Nomor Anggota</th>
                <th width="20%">Email</th>
                <th width="15%">Password</th>
                <th width="10%">Tgl Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $member)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $member->username }}</td>
                <td class="text-left">{{ $member->name }}</td>
                <td class="text-center">{{ $member->number }}</td>
                <td class="text-left">{{ $member->email }}</td>
                <td class="text-center">
                    <span class="badge-password">{{ $member->plain_password }}</span>
                </td>
                <td class="text-center">{{ $member->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data anggota</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari sistem | {{ $date }}</p>
        <p style="margin-top: 5px; font-size: 9px;">© {{ date('Y') }} Perpustakaan Digital - All Rights Reserved</p>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pendaftaran</title>
</head>

<body>
    <h1>Status Pendaftaran Diperbarui</h1>
    <p>{{ $body }}</p>
    <h3>Detail Pendaftaran:</h3>
    <ul>
        <li>Tanggal: {{ date('d F Y', strtotime($date)) }}</li>
        <li>Status Terkini:
            @if ($status === 'approved')
                <strong style="color: green;">DISETUJUI</strong>
            @elseif($status === 'rejected')
                <strong style="color: red;">DITOLAK</strong>
            @else
                <strong>Dalam Proses Verifikasi</strong>
            @endif
        </li>

        @if ($rejection_reason)
            <li>Alasan Penolakan: {{ $rejection_reason }}</li>
        @endif

        <p>Anda dapat memeriksa detail pendaftaran di dashboard Anda.</p>
        <p>Hormat kami,<br>Tim Klinik</p>
    </ul>
</body>

</html>

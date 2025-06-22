<!DOCTYPE html>
<html>

<head>
    <title>Hasil Import</title>
</head>

<body>
    <h1>Hasil Import Excel</h1>

    @if (count($data) > 0)
        <table border="1" cellpadding="8">
            <tr>
                <th>No</th>
                <th>Nama</th>
            </tr>
            @foreach ($data as $index => $nama)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $nama }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p>Tidak ada data yang diimpor.</p>
    @endif
</body>

</html>

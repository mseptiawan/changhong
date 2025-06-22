<!DOCTYPE html>
<html>
<head>
    <title>Upload Excel</title>
</head>
<body>
    <h1>Upload Excel File</h1>

    <form action="{{ route('import.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="excel_file" required>
        <button type="submit">Upload</button>
    </form>
</body>
</html>

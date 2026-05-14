<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>Tambah Data Mahasiswa</div>

    <div>
        <form action="{{ route('store-mahasiswa') }}" method="post">
            @csrf

            <div>
                <input type="text" id="nama" name="nama" placeholder="Nama Mahasiswa">
            </div>

            <div>
                <input type="text" id="alamat" name="alamat" placeholder="Alamat Mahasiswa">
            </div>

            <div>
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Form Input Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f8fafc;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Input Order</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('orders.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Qty</label>
                                <input type="number" name="qty" class="form-control" value="{{ old('qty') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga" class="form-control" value="{{ old('harga') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Barang</label>
                                <input type="text" name="jenis_barang" class="form-control" value="{{ old('jenis_barang') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok" class="form-control" value="{{ old('stok') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Order</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">Kembali ke Dashboard</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>

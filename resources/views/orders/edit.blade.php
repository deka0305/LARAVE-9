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
                        <h4 class="mb-0">edit Order</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success" style="display:none;">
                            <span class="success-message"></span>
                        </div>
                        <div class="alert alert-danger" style="display:none;">
                            <ul class="mb-0 error-list"></ul>
                        </div>
                        <form method="POST" action="{{ route('orders.update', $order->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $order->nama_barang) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Qty</label>
                                <input type="number" name="qty" class="form-control" value="{{ old('qty', $order->qty) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga" class="form-control" value="{{ old('harga', $order->harga) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Barang</label>
                                <input type="text" name="jenis_barang" class="form-control" value="{{ old('jenis_barang', $order->jenis_barang) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok" class="form-control" value="{{ old('stok', $order->stok) }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Order</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">Kembali ke Dashboard</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</body>
</html>

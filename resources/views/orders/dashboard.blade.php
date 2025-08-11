<!-- filepath: c:\laragon\www\LARAVE-9\resources\views\orders\dashboard.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body style="background:#f8fafc;">
    <div class="d-flex">
        <!-- Sidebar -->
       @include('layout.slidebar')

        <!-- Main Content -->
        <div class="container py-5 flex-grow-1">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Dashboard Order</h1>
                <a href="{{ route('orders.create') }}" class="btn btn-primary">+ Input Order</a>
            </div>
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Jenis Barang</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->nama_barang }}</td>
                                <td>{{ $order->qty }}</td>
                                <td>Rp {{ number_format($order->harga, 0, ',', '.') }}</td>
                                <td>{{ $order->jenis_barang }}</td>
                                <td>{{ $order->stok }}</td>
                                <td>
                                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data order.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
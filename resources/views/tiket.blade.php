<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .sidebar {
            min-width: 220px;
            background: #1e293b;
            color: #fff;
            min-height: 100vh;
            box-shadow: 2px 0 8px rgba(30, 41, 59, 0.08);
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 14px 24px;
            border-radius: 8px;
            margin: 8px 12px;
            transition: background 0.2s;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #3b82f6;
        }

        .container {
            padding: 32px 32px 24px 32px;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 6px 32px rgba(30, 41, 59, 0.10);
            margin-top: 32px;
            margin-bottom: 32px;
        }

        h1 {
            color: #1e293b;
            font-weight: 700;
            margin-bottom: 32px;
            letter-spacing: 1px;
        }

        .form-label {
            font-weight: 600;
            color: #334155;
        }

        .btn-primary {
            background: linear-gradient(90deg, #3b82f6 0%, #6366f1 100%);
            border: none;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.10);
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #2563eb 0%, #4f46e5 100%);
        }

        .table {
            margin-top: 24px;
            background: #f1f5f9;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(30, 41, 59, 0.07);
        }

        .table th {
            background: linear-gradient(90deg, #3b82f6 0%, #6366f1 100%);
            color: #fff;
            text-align: center;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
            color: #334155;
        }

        .badge-status {
            font-size: 0.95em;
            padding: 0.5em 1em;
            border-radius: 1em;
            font-weight: 600;
        }

        .badge-open {
            background: #fbbf24;
            color: #fff;
        }

        .badge-progress {
            background: #3b82f6;
            color: #fff;
        }

        .badge-close {
            background: #10b981;
            color: #fff;
        }

        .pagination .page-link {
            color: #3b82f6;
            border-radius: 8px;
        }

        .pagination .active .page-link {
            background: #3b82f6;
            color: #fff;
            border: none;
        }

        @media (max-width: 900px) {
            .container {
                padding: 16px;
            }

            .sidebar {
                min-width: 60px;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('layout.slidebar')
        <div class="container flex-grow-1">
            <h1 class="text-center mb-4"><i class="fa-solid fa-ticket fa-lg me-2 text-primary"></i>PM Breakdown
                Entries</h1>
            <form id="filter-form" method="GET" action="{{ url('/tiket') }}" class="mb-3">
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ request('start_date', '') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                            value="{{ request('end_date', '') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="name" class="form-label">Name</label>
                        <select name="name" id="name" class="form-select">
                            <option value="">-</option>
                            <option value="deden.kurnia" {{ request('name') == 'deden.kurnia' ? 'selected' : '' }}>
                                deden.kurnia</option>
                            <option value="tio.laksono" {{ request('name') == 'tio.laksono' ? 'selected' : '' }}>
                                tio.laksono
                            </option>
                            <option value="nilo.pamungkas" {{ request('name') == 'nilo.pamungkas' ? 'selected' : '' }}>
                                nilo.pamungkas</option>
                            <option value="asep.riqki" {{ request('name') == 'asep.riqki' ? 'selected' : '' }}>
                                asep.riqki
                            </option>
                            <option value="kris.dit" {{ request('name') == 'kris.dit' ? 'selected' : '' }}>kris.dit
                            </option>
                            <option value="usman.as" {{ request('name') == 'usman.as' ? 'selected' : '' }}>usman.as
                            </option>
                            <option value="joko.susanto" {{ request('name') == 'joko.susanto' ? 'selected' : '' }}>
                                joko.susanto</option>
                            <option value="mitra.sunengsih"
                                {{ request('name') == 'mitra.sunengsih' ? 'selected' : '' }}>
                                mitra.sunengsih</option>
                            <option value="tobias.mikha" {{ request('name') == 'tobias.mikha' ? 'selected' : '' }}>
                                tobias.mikha</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="proses" class="form-label">Status</label>
                        <select name="proses" id="proses" class="form-select">
                            <option value="0">-</option>
                            <option value="1" {{ request('proses') == '1' ? 'selected' : '' }}>Open</option>
                            <option value="2" {{ request('proses') == '2' ? 'selected' : '' }}>In Progress</option>
                            <option value="3" {{ request('proses') == '3' ? 'selected' : '' }}>Close</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter me-1"></i>Filter</button>
                    </div>
                </div>
            </form>
            <div id="data-table">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th width="9%">Tanggal</th>
                            <th>TIKET</th>
                            <th>DEPARTMENT</th>
                            <th>KETERANGAN</th>
                            <th>STATUS</th>
                            <th>USER</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tiket as $index => $item)
                            <tr>
                                <td>{{ ($tiket->currentPage() - 1) * $tiket->perPage() + $loop->iteration }}</td>
                                <td>{{ isset($item->identifieddate) ? \Carbon\Carbon::parse($item->identifieddate)->format('d-m-Y') : '-' }}
                                </td>
                                <td><span class="fw-bold text-primary"><i class="fa-solid fa-ticket me-1"></i>{{ $item->code
                                        ?? '-' }}</span></td>
                                <td>{{ $item->shortdescription ?? '-' }}</td>
                                <td class="text-justify whitespace-normal">{{ $item->symptom ?? '-' }}</td>
                                <td>
                                    @if (($item->status ?? null) == 1)
                                        <span class="badge badge-status badge-open"><i class="fa fa-circle me-1"></i>Open</span>
                                    @elseif (($item->status ?? null) == 2)
                                        <span class="badge badge-status badge-progress"><i class="fa fa-spinner me-1"></i>In
                                            Progress</span>
                                    @else
                                        <span class="badge badge-status badge-close"><i class="fa fa-check me-1"></i>Close</span>
                                    @endif
                                </td>
                                <td><i class="fa fa-user me-1 text-secondary"></i>{{ $item->defaultassignedtouserid ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7" class="text-center">
                                <nav aria-label="Page navigation">
                                    @if ($tiket instanceof \Illuminate\Pagination\LengthAwarePaginator || $tiket instanceof \Illuminate\Pagination\Paginator)
                                        {{ $tiket->appends(request()->query())->links('pagination::bootstrap-5') }}
                                    @endif
                                </nav>
                            </td>
                        </tr>
                </table>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>

</html>

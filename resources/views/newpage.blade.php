<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #343a40;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .table {
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        .table td {
            text-align: center;
        }

        .container {
            padding: 20px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="d-flex">
        @include('layout.slidebar')
        <div class="container" with="100%">
            <!-- Sidebar -->
            <h1 class="text-center">PM Breakdown Entries</h1>

            <form id="filter-form" method="GET" action="{{ url('/newpage') }}">
                <div class="row">
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
                                tio.laksono</option>
                            <option value="nilo.pamungkas" {{ request('name') == 'nilo.pamungkas' ? 'selected' : '' }}>
                                nilo.pamungkas</option>
                            <option value="asep.riqki" {{ request('name') == 'asep.riqki' ? 'selected' : '' }}>
                                asep.riqki</option>
                            <option value="kris.dit" {{ request('name') == 'kris.dit' ? 'selected' : '' }}>kris.dit
                            </option>
                            <option value="usman.as" {{ request('name') == 'usman.as' ? 'selected' : '' }}>usman.as
                            </option>
                            <option value="joko.susanto" {{ request('name') == 'joko.susanto' ? 'selected' : '' }}>
                                joko.susanto</option>
                            <option value="mitra.sunengsih"
                                {{ request('name') == 'mitra.sunengsih' ? 'selected' : '' }}>mitra.sunengsih</option>
                            <option value="tobias.mikha" {{ request('name') == 'tobias.mikha' ? 'selected' : '' }}>
                                tobias.mikha</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="proses" class="form-label">&nbsp;</label>
                        <select name="proses" id="proses" class="form-select">
                            <option value="0">-</option>
                            <option value="1" {{ request('proses') == '1' ? 'selected' : '' }}>Open</option>
                            <option value="2" {{ request('proses') == '2' ? 'selected' : '' }}>In Progress
                            </option>
                            <option value="3" {{ request('proses') == '3' ? 'selected' : '' }}>Close</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
            <div>
                <div id="data-table">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th width="9%">TANGGAL</th>
                                <th>TIKET</th>
                                <th>DEPARTMENT</th>
                                <th>KETERANGAN</th>
                                <th>STATUS</th>
                                <th>USER</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ ($data->currentPage() - 1) * $data->perPage() + $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->identifieddate)->format('d-m-Y') }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->shortdescription }}</td>
                                    <td>{{ $item->symptom }}</td>
                                    <td>
                                        @if ($item->status == 1)
                                            Open
                                        @elseif ($item->status == 2)
                                            In Progress
                                        @else
                                            Close
                                        @endif
                                    <td>{{ $item->defaultassignedtouserid }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-center">
                                    <nav aria-label="Page navigation">
                                        {{ $data->appends(request()->query())->links('pagination::bootstrap-5') }}
                                    </nav>
                                </td>
                            </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</html>

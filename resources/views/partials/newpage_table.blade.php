@if($data)
    <p>Total Data: {{ $total }}</p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Code</th>
                <th>Dept</th>
                <th>Symptom</th>
                <th>Identified Date</th>
                <th>Status</th>
                <th>Default Assigned User</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $entry)
                <tr>
                    <td>{{ ($currentPage - 1) * $perPage + $index + 1 }}</td>
                    <td>{{ $entry->code }}</td>
                    <td>{{$entry->shortdescription}}</td>
                    <td>{{ $entry->symptom }}</td>
                    <td>{{ \Carbon\Carbon::parse($entry->identifieddate)->format('d-m-Y') }}</td>
                    <td>
                        @if($entry->status == 1)
                            Open
                        @elseif($entry->status == 2)
                            In Progress
                        @elseif($entry->status == 3)
                            Close
                        @else
                            status
                        @endif
                    </td>
                    <td>{{ $entry->defaultassignedtouserid }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination -->
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="javascript:void(0)" onclick="changePage({{ $currentPage - 1 }})">Previous</a>
            </li>
            @for ($i = 1; $i <= $lastPage; $i++)
                <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                    <a class="page-link" href="javascript:void(0)" onclick="changePage({{ $i }})">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                <a class="page-link" href="javascript:void(0)" onclick="changePage({{ $currentPage + 1 }})">Next</a>
            </li>
        </ul>
    </nav>
@else
    <p>No data available for the selected date range.</p>
@endif
<script>
function changePage(page) {
    document.querySelector('input[name="page"]').value = page;
    fetchData();
}
if (!document.querySelector('input[name="page"]')) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'page';
    input.value = {{ $currentPage ?? 1 }};
    document.getElementById('filter-form').appendChild(input);
}
</script>

<div class="col-xl-12">
    <div class="card">
        <div class="card-body">
            <div class="teacher-deatails">
                {{-- <h3 class="heading">Member's Profile:</h3> --}}
                <table class="table">
                    <thead>
                        <tr>
                            <th><h6>Absensi Datang</h6></th>
                            <th><h6>Absensi Pulang</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personalTrainers as $item)
                        <tr>
                            <td>{{ $item->check_in_time }}</td>
                            <td>{{ $item->check_out_time }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between">
        <a href="{{ route('absensi-non-pt') }}" class="btn btn-info text-right">Back</a>
    </div>
</div>

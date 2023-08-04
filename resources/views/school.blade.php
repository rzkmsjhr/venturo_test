<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="margin-top: 2rem;margin-bottom:1rem">
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header">
            Venturo - Laporan siswa per sekolah
        </div>
        <div class="card-body">
            <form action="/school-data" method="GET">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <select class="form-control" id="schoolType" name="type">
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="SMK">SMK</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-primary" type="submit">Tampilan</button>
                        <a href="http://tes-web.landa.id/sekolah.json" class="btn btn-secondary" target="_blank">Json Sekolah</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @foreach ($schools as $schoolName => $school)
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="form-group row">
                        <div class="col-6">
                            <label><b>NAMA SEKOLAH</b></label>
                        </div>
                        <div class="col-6">
                            <label>: {{ $schoolName }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label><b>TELEPON</b></label>
                        </div>
                        <div class="col-6">
                            <label>: {{ $school['tlp'] }}</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <label><b>ALAMAT</b></label>
                        </div>
                        <div class="col-6">
                            <label>: {{ $school['alamat'] }}</label>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                        <br>
                        <table class="table table-bordered" style="margin-bottom: 0;">
                        <tbody>
                            <tr class="table-dark">
                            <th>NIS</th>
                            <th>NAMA</th>
                            <th>TANGGAL LAHIR</th>
                        </tr>
                        @if (isset($school['siswa']) && is_array($school['siswa']))
                        @foreach ($school['siswa'] as $student)
                            <tr>
                            <td>{{ $student['nis'] }}</td>
                            <td>{{ $student['nama'] }}</td>
                            <td>{{ $student['tgl_lahir'] }}</td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3" align="center">tidak ada siswa</td>
                        </tr>
                        @endif
                    </tbody>
                    </table>
            </div>
        </div>
    </div>
    </div>
    @endforeach
</div>
</body>
</html>
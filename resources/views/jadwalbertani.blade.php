<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>
        JADWAL BUDIDAYA PETANI KOBESSA
    </title>
</head>
<body>
<style type="text/css">
    table tr td,
    table tr th {
        font-size: 12pt;
        border: 1px solid black;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table tr th {
        text-align: center;
    }

    td {
        text-transform: capitalize;
        height: 0px !important;
    }

    .hang {
        text-indent: -2em;
        margin-left: 4em;
    }

</style>
<h5 style="text-align: center; margin-top: 5px; margin-bottom: 5px;">
    <strong><u>JADWAL BUDIDAYA PETANI KOBESSA</u></strong>
</h5>
@php date_default_timezone_set('Asia/Jakarta') @endphp
<br>
<pre style="line-height: 20pt;font-weight: bold;font-size: 12pt;">

Nama Petani                        :{{$biodata->nama}}
Nama Lahan                         :{{$biodata->namalahan}}
Luas Lahan                         :{{$biodata->luaslahan}} Ha
Lokasi Lahan di                    :Desa {{$biodata->namadesa}}
                                    Kec. {{$biodata->kecamatan}} Kab. Situbondo
Tergabung dalam Kelompok tani      :{{$biodata->namakelompok}}


</pre>

<table class='' style="font-weight: bold;text-align: center;">
    <thead>
    <tr>
        <th>No.</th>
        <th>Tanggal Aktivitas</th>
        <th>Aktivitas</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i=1;
    @endphp
    @foreach($jadwal as $values)
        <tr style="height: 0">
            <td>{{ $i++ }}</td>
            <td>{{$values->tglaktivitas}}</td>
            <td>{{$values->aktivitas}}</td>
            <td>{{$values->status}}</td>
        </tr>
    @endforeach

    </tbody>
</table>
<br>
</body>
</html>

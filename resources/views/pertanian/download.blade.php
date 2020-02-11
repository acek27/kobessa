<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=petani.xls");
?>
<h3>Data Petani "KOBESSA"</h3>

<table border="1">
    <tr>
        <th>nik</th>
        <th>nama</th>
        <th>tempatlahir</th>
        <th>tgllahir</th>
        <th>jeniskelamin</th>
        <th>alamat</th>
        <th>telp</th>
        <th>iddesa</th>
    </tr>
    @foreach($download as $value)
        <tr>
            <td>{{$value->nik}}</td>
            <td style="text-transform: capitalize">{{$value->nama}}</td>
            <td style="text-transform: capitalize">{{$value->tempatlahir}}</td>
            <td style="text-transform: capitalize">{{$value->tgllahir}}</td>
            <td>{{$value->jeniskelamin}}</td>
            <td style="text-transform: lowercase">{{$value->alamat}}</td>
            <td>(+62) {{$value->telp}}</td>
            <td>{{$value->iddesa}}</td>
        </tr>
    @endforeach
</table>

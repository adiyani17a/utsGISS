<table class="table table-hover">
    <thead>
        <th>Nama Kabupaten</th>
        <th>Nama Bupati</th>
        <th>Jumlah Penduduk</th>
        <th>Jumlah UKM</th>
        <th>Aksi</th>
    </thead>
    <tbody>
    	@foreach ($data as $i => $d)
    		<tr style="cursor: pointer" data-dismiss="modal">
				<td onclick="loadData('{{ $d->id }}')">{{ $d->nama_kabupaten }}</td>    		
				<td onclick="loadData('{{ $d->id }}')">{{ $d->nama_bupati }}</td>    		
				<td onclick="loadData('{{ $d->id }}')">{{ $d->jumlah_penduduk }}</td>    		
				<td onclick="loadData('{{ $d->id }}')">{{ $d->jumlah_ukm }}</td>    		
				<td><button class="btn btn-danger" onclick="hapus('{{ $d->id }}')">X</button></td>    		
    		</tr>
    	@endforeach
    	@if (count($data) == 0)
    		<tr>
    			<td align="center" colspan="5">Tidak Ada Data</td>
    		</tr>
    	@endif
    </tbody>
</table>
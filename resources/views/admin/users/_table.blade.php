<table id="example" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
  <thead>
    <tr>
      <th>ID</th>
      <th class="head">Nombres</th>
      <th class="head">Apellidos</th>
      <th class="head">Correo Electrónico</th>
      <th class="head">Fecha</th>
    </tr>
    <tr>
      <th>Filtros:</th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th></th>
      <th class="text-center">Nombres</th>
      <th class="head">Apellidos</th>
      <th class="head">Correo Electrónico</th>
      <th class="head">Fecha</th>
    </tr>
  </tfoot>
  <tbody>
    @foreach ($users as $item)
      <tr>
        <td class="text-center">{{ $item->id }}</td>
        <td>{{ $item->first_name}}</td>
        <td>{{ $item->last_name }}</td>
        <td>{{ $item->email }}</td>
        <td class="text-xs text-center">
          {{ date("Y/m/d", strtotime($item->created_at))}}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<button onclick="tablesToExcel(['example'], ['Users'], 'Users.xlsx', 'Excel')" class="inline-flex items-center justify-center px-6 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">
  <i class="fa-solid fa-file-excel mr-2"></i>Exportar a Excel
</button>
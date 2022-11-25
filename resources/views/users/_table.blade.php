<table id="dtFilters" class="min-w-full table display" style="width:100%">
  <thead>
    <tr>
      <th>ID</th>
      <th>Nombres</th>
      <th>Apellidos</th>
      <th>Correo Electrónico</th>
      <th>Fecha</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th>ID</th>
      <th>Nombres</th>
      <th>Apellidos</th>
      <th>Correo Electrónico</th>
      <th>Fecha</th>
    </tr>
  </tfoot>
  <tbody>
    @foreach ($users as $item)
      <tr>
        <td class="text-center">{{ $item->id }}</td>
        <td>{{ $item->first_name }}</td>
        <td>{{ $item->last_name }}</td>
        <td>{{ $item->email }}</td>
        <td class="text-xs text-center">
          {{ date("Y/m/d", strtotime($item->created_at))}}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
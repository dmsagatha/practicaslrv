<table id="dtFilters" class="table min-w-full display" style="width: 60%">
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
      <th>Nombres
        {{-- <select data-column="0" class="block py-2 text-sm font-medium text-gray-900 dark:text-gray-400 filter-select">
          <option value="">Seleccionar Nombres</option>
          @foreach ($first_names as $name)
            <option value="{{ $name }}">{{ $name }}</option>
          @endforeach
        </select> --}}
      </th>
      <th>Apellidos
        {{-- <select data-column="1" class="block py-2 text-sm font-medium text-gray-900 dark:text-gray-400 filter-select">
          <option value="">Seleccionar Apellidos</option>
          @foreach ($last_names as $name)
            <option value="{{ $name }}">{{ $name }}</option>
          @endforeach
        </select> --}}
      </th>
      <th>Correo Electrónico</th>
      <th>Fecha</th>
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

<button onclick="tablesToExcel(['dtFilters'], ['Users'], 'Users.xlsx', 'Excel')" class="inline-flex items-center justify-center px-6 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 active:bg-green-600 disabled:opacity-25 transition">
  <i class="fa-solid fa-file-excel mr-2"></i>Exportar a Excel
</button>
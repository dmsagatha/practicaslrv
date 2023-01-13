<div class="flex flex-col">
  <div class="w-full">
    <div class="border-b border-gray-300 shadow">
      <table id="exampleFilters" class="delete_table table table-condensed stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
        <thead>
          <tr>
            <th><input type="checkbox" id="bulk_delete"></th>
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Areas</th>
            <th>Correo Electrónico</th>
            <th>Fecha</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $item)
            <tr id="tr_{{ $item->id }}">
              <td>
                <input type="checkbox" class="check_item" data-id="{{ $item->id }}">
              </td>
              <td class="text-center">{{ $item->id }}</td>
              <td>{{ $item->first_name}}</td>
              <td>{{ $item->last_name }}</td>
              <td>{{ $item->area->name }}</td>
              <td>{{ $item->email }}</td>
              <td class="text-xs text-center">
                {{ date("Y/m/d", strtotime($item->created_at))}}
              </td>
              <td>
                {{-- <form id="{{ route('users.destroy', $item) }}" action="{{ route('users.destroy', $item) }}" method="POST">
                @csrf @method('DELETE')

                  <a type="button" href="#" onclick="deleteConfirm('{{ route('users.destroy', $item) }}')"
                    class="text-red-600 hover:text-red-900" title="Eliminar">
                    <i class="fas fa-trash-alt text-red-600"></i>
                  </a>
                </form> --}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="flex flex-col">
  <div class="w-full">
    <div class="border-b border-gray-300 shadow">
      <table id="exampleFilters" class="delete_table table stripe hover"
        style="width:100%; padding-top: 1em; padding-bottom: 1em;">
        <thead>
          <tr>
            <th><input type="checkbox" class="check-all"></th>
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo Electrónico</th>
            <th>Fecha</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $item)
            <tr>
              <td><input type="checkbox" class="check" value="{{ $item->id }}"></td>
              <td class="text-center">{{ $item->id }}</td>
              <td>{{ $item->first_name }}</td>
              <td>{{ $item->last_name }}</td>
              <td>{{ $item->email }}</td>
              <td class="text-xs text-center">
                {{ date('Y/m/d', strtotime($item->created_at)) }}
              </td>
              <td>
                {{-- <form method="post" class="delete-form" data-route="{{route('posts.destroy',$post->id)}}">
                      @method('delete')
                      <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                  </form> --}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

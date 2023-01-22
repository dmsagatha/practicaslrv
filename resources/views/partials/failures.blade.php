@if (session()->has('failures'))
  <div class="flex items-center justify-center px-4 py-4">
    <table class="table">
      <tr>
        <th>Fila</th>
        <th>Atributo</th>
        <th>Errores</th>
        <th>Valor</th>
      </tr>
      @foreach (session()->get('failures') as $validation)
        <tr>
          <td>{{ $validation->row() }}</td>
          <td>{{ $validation->attribute() }}</td>
          <td>
            <ul>
              @foreach ($validation->errors() as $e)
                <li>{{ $e }}</li>
              @endforeach
            </ul>
          </td>
          <td>{{ $validation->values()[$validation->attribute()] }}</td>
        </tr>
      @endforeach
    </table>
  </div>
@endif
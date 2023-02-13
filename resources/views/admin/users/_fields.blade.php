<div class="grid grid-cols-6 gap-x-10 gap-y-8">
  <div class="col-span-6 sm:col-span-3 md:col-span-2">
    <div class="relative form-group mt-8">
      <input type="text" id="first_name" name="first_name" value="{{ old("first_name", $user->first_name) }}" placeholder=" " class="peer h-10 w-full border-b-2 border-gray-300 bg-transparent text-gray-900 placeholder-transparent focus:outline-none focus:border-black">
      <label class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">
        Nombres
      </label>
      
      @error("first_name")
        <p class="text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>
  </div>

  <div class="col-span-6 sm:col-span-3 md:col-span-2">
    <div class="relative form-group mt-8">
      <input type="text" id="last_name" name="last_name" value="{{ old("last_name", $user->last_name) }}" placeholder=" " class="peer h-10 w-full border-b-2 border-gray-300 bg-transparent text-gray-900 placeholder-transparent focus:outline-none focus:border-black">
      <label class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">
        Apellidos
      </label>
      
      @error("last_name")
        <p class="text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>
  </div>

  <div class="col-span-6 sm:col-span-3 md:col-span-2">
    <div class="relative form-group mt-8">
      <input type="email" id="email" name="email" value="{{ old("email", $user->email) }}" placeholder=" " class="peer h-10 w-full border-b-2 border-gray-300 bg-transparent text-gray-900 placeholder-transparent focus:outline-none focus:border-black">
      <label class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">
        Correo Electrónico
      </label>
      
      @error("email")
        <p class="text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>
  </div>

  <div class="col-span-6 sm:col-span-3 md:col-span-2">
    <div class="relative form-group mt-8">
      <input type="password" id="password" name="password" value="{{ old("password", $user->password) }}" placeholder=" " class="peer h-10 w-full border-b-2 border-gray-300 bg-transparent text-gray-900 placeholder-transparent focus:outline-none focus:border-black">
      <label class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">
        Contraseña
      </label>
      
      @error("password")
        <p class="text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>
  </div>
</div>

{{-- Avatar --}}
<div class="relative form-group mt-8">
  <div class="dropzone" id="dropzone"></div>
  <input type="hidden" readonly class="newimage" name="image" value="">
</div>
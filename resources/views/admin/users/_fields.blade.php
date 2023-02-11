<div class="grid grid-cols-6 gap-x-10 gap-y-8">
  <div class="col-span-6 sm:col-span-3 md:col-span-2">
    <div class="relative form-group mt-8">
      <input id="first_name" name="first_name" value="{{ old("first_name", $value ?? '') }}" placeholder=" " type="text" class="peer h-10 w-full border-b-2 border-gray-300 bg-transparent text-gray-900 placeholder-transparent focus:outline-none focus:border-black">
      <label class="absolute left-0 -top-3.5 text-gray-600 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-2 peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">
        Nombres
      </label>
      
      @error("first_name")
        <p class="text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>
  </div>

 {{--  <div class="col-span-6 sm:col-span-3 md:col-span-2">
    <div class="relative form-group mt-8">
      <x-form.input name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" autocomplete="last_name" onkeyup="forceInputUcwords(this)" />
      <x-form.label for="last_name" class="required" value="Apellidos" />
    </div>
  </div>
  
  <div class="col-span-6 sm:col-span-3 md:col-span-2">
    <div class="relative form-group mt-8">
      <x-form.input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" autocomplete="email" onkeyup="this.value=this.value.toLowerCase()" />
      <x-form.label for="email" class="required" value="Correo electrónico" />
    </div>
  </div>
  
  <div class="col-span-6 sm:col-span-3 md:col-span-2">
    <div class="relative form-group mt-8">
      <x-form.input type="password" name="password" id="password" value="{{ old('password', $user->password) }}" />
      <x-form.label for="password" value="Contraseña" />
    </div>
  </div> --}}
</div>
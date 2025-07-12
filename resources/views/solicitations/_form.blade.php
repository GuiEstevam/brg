<div class="row g-4">
  <div class="col-md-4 form-floating">
    <select name="enterprise_id" id="enterprise_id" class="form-select @error('enterprise_id') is-invalid @enderror"
      required>
      <option value="">Selecione a empresa</option>
      @foreach ($enterprises as $enterprise)
        <option value="{{ $enterprise->id }}" @selected(old('enterprise_id', $solicitation->enterprise_id ?? request('enterprise_id')) == $enterprise->id)>
          {{ $enterprise->name }}
        </option>
      @endforeach
    </select>
    <label for="enterprise_id">Empresa *</label>
    @error('enterprise_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <select name="branch_id" id="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
      <option value="">Selecione a filial</option>
      @foreach ($branches as $branch)
        <option value="{{ $branch->id }}" @selected(old('branch_id', $solicitation->branch_id ?? request('branch_id')) == $branch->id)>
          {{ $branch->name }}
        </option>
      @endforeach
    </select>
    <label for="branch_id">Filial</label>
    @error('branch_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
      <option value="">Usuário responsável</option>
      @foreach ($users as $user)
        <option value="{{ $user->id }}" @selected(old('user_id', $solicitation->user_id ?? request('user_id')) == $user->id)>
          {{ $user->name }}
        </option>
      @endforeach
    </select>
    <label for="user_id">Usuário *</label>
    @error('user_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-6 form-floating">
    <select name="driver_id" id="driver_id" class="form-select @error('driver_id') is-invalid @enderror">
      <option value="">Selecione o motorista</option>
      @foreach ($drivers as $driver)
        <option value="{{ $driver->id }}" @selected(old('driver_id', $solicitation->driver_id ?? request('driver_id')) == $driver->id)>
          {{ $driver->name }}
        </option>
      @endforeach
    </select>
    <label for="driver_id">Motorista</label>
    @error('driver_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-6 form-floating">
    <select name="vehicle_id" id="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror">
      <option value="">Selecione o veículo</option>
      @foreach ($vehicles as $vehicle)
        <option value="{{ $vehicle->id }}" @selected(old('vehicle_id', $solicitation->vehicle_id ?? request('vehicle_id')) == $vehicle->id)>
          {{ $vehicle->plate }}
        </option>
      @endforeach
    </select>
    <label for="vehicle_id">Veículo</label>
    @error('vehicle_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror"
      value="{{ old('type', $solicitation->type ?? '') }}" placeholder="Tipo" required>
    <label for="type">Tipo *</label>
    @error('type')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" name="subtype" id="subtype" class="form-control @error('subtype') is-invalid @enderror"
      value="{{ old('subtype', $solicitation->subtype ?? '') }}" placeholder="Subtipo" required>
    <label for="subtype">Subtipo *</label>
    @error('subtype')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" name="value" id="value" class="form-control @error('value') is-invalid @enderror"
      value="{{ old('value', $solicitation->value ?? '') }}" placeholder="Valor" required>
    <label for="value">Valor *</label>
    @error('value')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
      <option value="pending" @selected(old('status', $solicitation->status ?? '') == 'pending')>Pendente</option>
      <option value="processing" @selected(old('status', $solicitation->status ?? '') == 'processing')>Processando</option>
      <option value="finished" @selected(old('status', $solicitation->status ?? '') == 'finished')>Finalizada</option>
      <option value="error" @selected(old('status', $solicitation->status ?? '') == 'error')>Erro</option>
    </select>
    <label for="status">Status *</label>
    @error('status')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="text" name="vincle_type" id="vincle_type"
      class="form-control @error('vincle_type') is-invalid @enderror"
      value="{{ old('vincle_type', $solicitation->vincle_type ?? '') }}" placeholder="Tipo de Vínculo">
    <label for="vincle_type">Tipo de Vínculo</label>
    @error('vincle_type')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="text" name="research_type" id="research_type"
      class="form-control @error('research_type') is-invalid @enderror"
      value="{{ old('research_type', $solicitation->research_type ?? '') }}" placeholder="Tipo de Pesquisa">
    <label for="research_type">Tipo de Pesquisa</label>
    @error('research_type')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="number" name="original_solicitation_id" id="original_solicitation_id"
      class="form-control @error('original_solicitation_id') is-invalid @enderror"
      value="{{ old('original_solicitation_id', $solicitation->original_solicitation_id ?? '') }}"
      placeholder="Solicitação Original">
    <label for="original_solicitation_id">Solicitação Original</label>
    @error('original_solicitation_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>
<div class="d-flex gap-2 mt-4 justify-content-end">
  <button type="submit" class="btn btn-primary btn-lg px-4">Salvar</button>
  <a href="{{ route('solicitations.index') }}" class="btn btn-secondary btn-lg px-4">Cancelar</a>
</div>

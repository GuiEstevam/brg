<div class="row g-4">
  <div class="col-md-3 form-floating">
    <input type="text" name="plate" id="plate" class="form-control @error('plate') is-invalid @enderror"
      value="{{ old('plate', $vehicle->plate ?? '') }}" placeholder="Placa" maxlength="8" required
      style="text-transform:uppercase">
    <label for="plate">Placa *</label>
    @error('plate')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="text" name="renavam" id="renavam" class="form-control @error('renavam') is-invalid @enderror"
      value="{{ old('renavam', $vehicle->renavam ?? '') }}" placeholder="RENAVAM" maxlength="11">
    <label for="renavam">RENAVAM</label>
    @error('renavam')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="text" name="chassi" id="chassi" class="form-control @error('chassi') is-invalid @enderror"
      value="{{ old('chassi', $vehicle->chassi ?? '') }}" placeholder="Chassi">
    <label for="chassi">Chassi</label>
    @error('chassi')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="text" name="brand" id="brand" class="form-control @error('brand') is-invalid @enderror"
      value="{{ old('brand', $vehicle->brand ?? '') }}" placeholder="Marca">
    <label for="brand">Marca</label>
    @error('brand')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="text" name="model" id="model" class="form-control @error('model') is-invalid @enderror"
      value="{{ old('model', $vehicle->model ?? '') }}" placeholder="Modelo">
    <label for="model">Modelo</label>
    @error('model')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-2 form-floating">
    <input type="number" name="manufacture_year" id="manufacture_year"
      class="form-control @error('manufacture_year') is-invalid @enderror"
      value="{{ old('manufacture_year', $vehicle->manufacture_year ?? '') }}" placeholder="Ano Fab.">
    <label for="manufacture_year">Ano Fab.</label>
    @error('manufacture_year')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-2 form-floating">
    <input type="number" name="model_year" id="model_year"
      class="form-control @error('model_year') is-invalid @enderror"
      value="{{ old('model_year', $vehicle->model_year ?? '') }}" placeholder="Ano Mod.">
    <label for="model_year">Ano Mod.</label>
    @error('model_year')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-2 form-floating">
    <input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror"
      value="{{ old('color', $vehicle->color ?? '') }}" placeholder="Cor">
    <label for="color">Cor</label>
    @error('color')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="text" name="fuel" id="fuel" class="form-control @error('fuel') is-invalid @enderror"
      value="{{ old('fuel', $vehicle->fuel ?? '') }}" placeholder="Combustível">
    <label for="fuel">Combustível</label>
    @error('fuel')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="text" name="vehicle_type" id="vehicle_type"
      class="form-control @error('vehicle_type') is-invalid @enderror"
      value="{{ old('vehicle_type', $vehicle->vehicle_type ?? '') }}" placeholder="Tipo do Veículo">
    <label for="vehicle_type">Tipo do Veículo</label>
    @error('vehicle_type')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="text" name="vehicle_specie" id="vehicle_specie"
      class="form-control @error('vehicle_specie') is-invalid @enderror"
      value="{{ old('vehicle_specie', $vehicle->vehicle_specie ?? '') }}" placeholder="Espécie do Veículo">
    <label for="vehicle_specie">Espécie do Veículo</label>
    @error('vehicle_specie')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="date" name="licensing_date" id="licensing_date"
      class="form-control @error('licensing_date') is-invalid @enderror"
      value="{{ old('licensing_date', $vehicle->licensing_date ?? '') }}" placeholder="Data do Licenciamento">
    <label for="licensing_date">Licenciamento</label>
    @error('licensing_date')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="text" name="licensing_status" id="licensing_status"
      class="form-control @error('licensing_status') is-invalid @enderror"
      value="{{ old('licensing_status', $vehicle->licensing_status ?? '') }}" placeholder="Situação Licenciamento">
    <label for="licensing_status">Situação Licenciamento</label>
    @error('licensing_status')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" name="owner_document" id="owner_document"
      class="form-control @error('owner_document') is-invalid @enderror"
      value="{{ old('owner_document', $vehicle->owner_document ?? '') }}" placeholder="Doc. Proprietário">
    <label for="owner_document">Doc. Proprietário</label>
    @error('owner_document')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" name="owner_name" id="owner_name"
      class="form-control @error('owner_name') is-invalid @enderror"
      value="{{ old('owner_name', $vehicle->owner_name ?? '') }}" placeholder="Nome Proprietário">
    <label for="owner_name">Nome Proprietário</label>
    @error('owner_name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" name="lessee_document" id="lessee_document"
      class="form-control @error('lessee_document') is-invalid @enderror"
      value="{{ old('lessee_document', $vehicle->lessee_document ?? '') }}" placeholder="Doc. Locatário">
    <label for="lessee_document">Doc. Locatário</label>
    @error('lessee_document')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" name="lessee_name" id="lessee_name"
      class="form-control @error('lessee_name') is-invalid @enderror"
      value="{{ old('lessee_name', $vehicle->lessee_name ?? '') }}" placeholder="Nome Locatário">
    <label for="lessee_name">Nome Locatário</label>
    @error('lessee_name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" name="antt_situation" id="antt_situation"
      class="form-control @error('antt_situation') is-invalid @enderror"
      value="{{ old('antt_situation', $vehicle->antt_situation ?? '') }}" placeholder="Situação ANTT">
    <label for="antt_situation">Situação ANTT</label>
    @error('antt_situation')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-2 form-floating">
    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
      <option value="active" @selected(old('status', $vehicle->status ?? '') == 'active')>Ativo</option>
      <option value="inactive" @selected(old('status', $vehicle->status ?? '') == 'inactive')>Inativo</option>
    </select>
    <label for="status">Status *</label>
    @error('status')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>
<div class="d-flex gap-2 mt-4 justify-content-end">
  <button type="submit" class="btn btn-primary btn-lg px-4">Salvar</button>
  <a href="{{ route('vehicles.index') }}" class="btn btn-secondary btn-lg px-4">Cancelar</a>
</div>

<div class="row g-4">
  <div class="col-md-4 form-floating">
    <input type="text" name="cpf" id="cpf" class="form-control @error('cpf') is-invalid @enderror"
      value="{{ old('cpf', $driver->cpf ?? '') }}" placeholder="CPF" required maxlength="14">
    <label for="cpf">CPF *</label>
    @error('cpf')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
      value="{{ old('name', $driver->name ?? '') }}" placeholder="Nome" required>
    <label for="name">Nome *</label>
    @error('name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
      value="{{ old('email', $driver->email ?? '') }}" placeholder="E-mail">
    <label for="email">E-mail</label>
    @error('email')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
      value="{{ old('phone', $driver->phone ?? '') }}" placeholder="Telefone">
    <label for="phone">Telefone</label>
    @error('phone')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="date" name="birth_date" id="birth_date"
      class="form-control @error('birth_date') is-invalid @enderror"
      value="{{ old('birth_date', $driver->birth_date ?? '') }}" placeholder="Data de Nascimento">
    <label for="birth_date">Data de Nascimento</label>
    @error('birth_date')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" name="mother_name" id="mother_name"
      class="form-control @error('mother_name') is-invalid @enderror"
      value="{{ old('mother_name', $driver->mother_name ?? '') }}" placeholder="Nome da Mãe">
    <label for="mother_name">Nome da Mãe</label>
    @error('mother_name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 form-floating">
    <input type="text" name="rg_number" id="rg_number" class="form-control @error('rg_number') is-invalid @enderror"
      value="{{ old('rg_number', $driver->rg_number ?? '') }}" placeholder="RG">
    <label for="rg_number">RG</label>
    @error('rg_number')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-2 form-floating">
    <input type="text" name="rg_uf" id="rg_uf" class="form-control @error('rg_uf') is-invalid @enderror"
      value="{{ old('rg_uf', $driver->rg_uf ?? '') }}" placeholder="UF" maxlength="2"
      style="text-transform:uppercase">
    <label for="rg_uf">UF RG</label>
    @error('rg_uf')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-2 form-floating">
    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
      <option value="active" @selected(old('status', $driver->status ?? '') == 'active')>Ativo</option>
      <option value="inactive" @selected(old('status', $driver->status ?? '') == 'inactive')>Inativo</option>
    </select>
    <label for="status">Status *</label>
    @error('status')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>
<div class="d-flex gap-2 mt-4 justify-content-end">
  <button type="submit" class="btn btn-primary btn-lg px-4">Salvar</button>
  <a href="{{ route('drivers.index') }}" class="btn btn-secondary btn-lg px-4">Cancelar</a>
</div>

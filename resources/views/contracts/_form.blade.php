<div class="row g-4">
  <div class="col-md-6 form-floating">
    <select name="enterprise_id" id="enterprise_id" class="form-select @error('enterprise_id') is-invalid @enderror"
      required>
      <option value="">Selecione a empresa</option>
      @foreach ($enterprises as $enterprise)
        <option value="{{ $enterprise->id }}" @selected(old('enterprise_id', $contract->enterprise_id ?? request('enterprise_id')) == $enterprise->id)>
          {{ $enterprise->name }}
        </option>
      @endforeach
    </select>
    <label for="enterprise_id">Empresa *</label>
    @error('enterprise_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-6 form-floating">
    <select name="branch_id" id="branch_id" class="form-select @error('branch_id') is-invalid @enderror">
      <option value="">Selecione a filial (opcional)</option>
      @foreach ($branches as $branch)
        <option value="{{ $branch->id }}" @selected(old('branch_id', $contract->branch_id ?? request('branch_id')) == $branch->id)>
          {{ $branch->name }}
        </option>
      @endforeach
    </select>
    <label for="branch_id">Filial</label>
    @error('branch_id')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-6 form-floating">
    <input type="text" name="plan_name" id="plan_name" class="form-control @error('plan_name') is-invalid @enderror"
      value="{{ old('plan_name', $contract->plan_name ?? '') }}" placeholder="Nome do Plano" required>
    <label for="plan_name">Nome do Plano *</label>
    @error('plan_name')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="date" name="start_date" id="start_date"
      class="form-control @error('start_date') is-invalid @enderror"
      value="{{ old('start_date', $contract->start_date ?? '') }}" required>
    <label for="start_date">Início *</label>
    @error('start_date')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror"
      value="{{ old('end_date', $contract->end_date ?? '') }}">
    <label for="end_date">Fim</label>
    @error('end_date')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="number" name="max_users" id="max_users" class="form-control @error('max_users') is-invalid @enderror"
      value="{{ old('max_users', $contract->max_users ?? '') }}" placeholder="Máx. Usuários">
    <label for="max_users">Máx. Usuários</label>
    @error('max_users')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="number" name="max_queries" id="max_queries"
      class="form-control @error('max_queries') is-invalid @enderror"
      value="{{ old('max_queries', $contract->max_queries ?? '') }}" placeholder="Máx. Consultas">
    <label for="max_queries">Máx. Consultas</label>
    @error('max_queries')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <input type="number" name="total_queries_used" id="total_queries_used"
      class="form-control @error('total_queries_used') is-invalid @enderror"
      value="{{ old('total_queries_used', $contract->total_queries_used ?? '') }}" placeholder="Consultas Realizadas">
    <label for="total_queries_used">Consultas Realizadas</label>
    @error('total_queries_used')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3">
    <div class="form-check mt-4">
      <input class="form-check-input" type="checkbox" name="unlimited_queries" id="unlimited_queries" value="1"
        {{ old('unlimited_queries', $contract->unlimited_queries ?? false) ? 'checked' : '' }}>
      <label class="form-check-label" for="unlimited_queries">
        Consultas Ilimitadas
      </label>
    </div>
    @error('unlimited_queries')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 form-floating">
    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
      <option value="active" @selected(old('status', $contract->status ?? '') == 'active')>Ativo</option>
      <option value="inactive" @selected(old('status', $contract->status ?? '') == 'inactive')>Inativo</option>
      <option value="pending" @selected(old('status', $contract->status ?? '') == 'pending')>Pendente</option>
      <option value="canceled" @selected(old('status', $contract->status ?? '') == 'canceled')>Cancelado</option>
      <option value="expired" @selected(old('status', $contract->status ?? '') == 'expired')>Expirado</option>
    </select>
    <label for="status">Status *</label>
    @error('status')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>
</div>
<div class="d-flex gap-2 mt-4 justify-content-end">
  <button type="submit" class="btn btn-primary btn-lg px-4">Salvar</button>
  <a href="{{ route('contracts.index') }}" class="btn btn-secondary btn-lg px-4">Cancelar</a>
</div>

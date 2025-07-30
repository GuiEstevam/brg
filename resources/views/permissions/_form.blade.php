<div class="d-flex justify-content-center">
  <div class="p-4 p-md-5 rounded-4 w-100">
    <p class="text-muted">Preencha os dados abaixo para
      {{ isset($role) && $role->exists ? 'editar' : 'criar' }} o papel.</p>
    <div class="row g-4">
      <div class="col-md-6 form-floating">
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
          placeholder="Nome do Papel" value="{{ old('name', $role->name ?? '') }}" required>
        <label for="name">Nome do Papel *</label>
        @error('name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-6 form-floating">
        <select class="form-select @error('team_id') is-invalid @enderror" name="team_id" id="team_id">
          <option value="">Global (superadmin)</option>
          @foreach ($enterprises as $enterprise)
            <option value="{{ $enterprise->id }}" @selected((string) old('team_id', $role->team_id ?? '') === (string) $enterprise->id)>
              {{ $enterprise->name }}
            </option>
          @endforeach
        </select>
        <label for="team_id">Vincular a empresa (opcional)</label>
        @error('team_id')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-12">
        <label class="form-label fw-semibold">Permissões para este papel</label>
        <div class="row">
          @foreach ($permissions as $permission)
            <div class="col-12 col-md-6 col-lg-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="perm-{{ $permission->id }}" name="permissions[]"
                  value="{{ $permission->name }}"
                  {{ in_array($permission->name, old('permissions', isset($role) ? $role->permissions->pluck('name')->toArray() : [])) ? 'checked' : '' }}>
                <label class="form-check-label" for="perm-{{ $permission->id }}">
                  {{ $permission->name }}
                </label>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
    <div class="d-flex gap-2 mt-4 justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg px-4">Salvar</button>
      <a href="{{ route('permissions.index') }}" class="btn btn-secondary btn-lg px-4">Cancelar</a>
    </div>
  </div>
</div>

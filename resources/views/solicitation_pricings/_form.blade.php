<div class="d-flex justify-content-center">
  <div class="rounded-4 w-100">
    <p class="text-muted">
      Preencha os dados abaixo para
      {{ isset($solicitationPricing) && $solicitationPricing->exists ? 'editar' : 'criar' }} a regra de preço.
    </p>
    <div class="row g-4">
      <!-- Empresa e Descrição -->
      <div class="col-md-6 form-floating">
        <select name="enterprise_id" id="enterprise_id" class="form-select @error('enterprise_id') is-invalid @enderror"
          required>
          <option value="">Selecione a empresa</option>
          @foreach ($enterprises as $enterprise)
            <option value="{{ $enterprise->id }}" @selected(old('enterprise_id', $solicitationPricing->enterprise_id ?? request('enterprise_id')) == $enterprise->id)>
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
        <input type="text" name="description" id="description"
          class="form-control @error('description') is-invalid @enderror"
          value="{{ old('description', $solicitationPricing->description ?? '') }}" placeholder="Descrição" required>
        <label for="description">Descrição *</label>
        @error('description')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-3 form-floating">
        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
          <option value="active" @selected(old('status', $solicitationPricing->status ?? '') == 'active')>Ativa</option>
          <option value="inactive" @selected(old('status', $solicitationPricing->status ?? '') == 'inactive')>Inativa</option>
        </select>
        <label for="status">Status *</label>
        @error('status')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Preços -->
      <div class="col-12">
        <h6 class="mt-3 mb-2">Preços</h6>
      </div>
      <div class="col-md-4 form-floating">
        <input type="text" name="individual_driver_price" id="individual_driver_price"
          class="form-control money-mask @error('individual_driver_price') is-invalid @enderror"
          value="{{ old('individual_driver_price', $solicitationPricing->individual_driver_price ?? '') }}"
          placeholder="Motorista Individual">
        <label for="individual_driver_price">Motorista Individual (R$)</label>
        @error('individual_driver_price')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-4 form-floating">
        <input type="text" name="individual_vehicle_price" id="individual_vehicle_price"
          class="form-control money-mask @error('individual_vehicle_price') is-invalid @enderror"
          value="{{ old('individual_vehicle_price', $solicitationPricing->individual_vehicle_price ?? '') }}"
          placeholder="Veículo Individual">
        <label for="individual_vehicle_price">Veículo Individual (R$)</label>
        @error('individual_vehicle_price')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-4 form-floating">
        <input type="text" name="unified_price" id="unified_price"
          class="form-control money-mask @error('unified_price') is-invalid @enderror"
          value="{{ old('unified_price', $solicitationPricing->unified_price ?? '') }}" placeholder="Unificado">
        <label for="unified_price">Unificado (R$)</label>
        @error('unified_price')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Adicionais unificados por placa -->
      <div class="col-12">
        <h6 class="mt-3 mb-2">Adicional por Veículo na Pesquisa Unificada</h6>
      </div>
      <div class="col-md-4 form-floating">
        <input type="text" name="unified_additional_vehicle_2" id="unified_additional_vehicle_2"
          class="form-control money-mask @error('unified_additional_vehicle_2') is-invalid @enderror"
          value="{{ old('unified_additional_vehicle_2', $solicitationPricing->unified_additional_vehicle_2 ?? '') }}"
          placeholder="2º Veículo">
        <label for="unified_additional_vehicle_2">2º Veículo (R$)</label>
        @error('unified_additional_vehicle_2')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-4 form-floating">
        <input type="text" name="unified_additional_vehicle_3" id="unified_additional_vehicle_3"
          class="form-control money-mask @error('unified_additional_vehicle_3') is-invalid @enderror"
          value="{{ old('unified_additional_vehicle_3', $solicitationPricing->unified_additional_vehicle_3 ?? '') }}"
          placeholder="3º Veículo">
        <label for="unified_additional_vehicle_3">3º Veículo (R$)</label>
        @error('unified_additional_vehicle_3')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-4 form-floating">
        <input type="text" name="unified_additional_vehicle_4" id="unified_additional_vehicle_4"
          class="form-control money-mask @error('unified_additional_vehicle_4') is-invalid @enderror"
          value="{{ old('unified_additional_vehicle_4', $solicitationPricing->unified_additional_vehicle_4 ?? '') }}"
          placeholder="4º Veículo">
        <label for="unified_additional_vehicle_4">4º Veículo (R$)</label>
        @error('unified_additional_vehicle_4')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <!-- Recorrência Automática -->
      <div class="col-12">
        <h6 class="mt-3 mb-2">Recorrência Automática</h6>
        <p class="text-muted mb-2" style="font-size:0.95em;">
          Marque para que, ao expirar a vigência, uma nova pesquisa seja gerada automaticamente para o tipo selecionado.
        </p>
      </div>
      <div class="col-md-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="recurrence_autonomo" id="recurrence_autonomo"
            value="1"
            {{ old('recurrence_autonomo', $solicitationPricing->recurrence_autonomo ?? false) ? 'checked' : '' }}>
          <label class="form-check-label" for="recurrence_autonomo">Autônomo</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="recurrence_agregado" id="recurrence_agregado"
            value="1"
            {{ old('recurrence_agregado', $solicitationPricing->recurrence_agregado ?? false) ? 'checked' : '' }}>
          <label class="form-check-label" for="recurrence_agregado">Agregado</label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="recurrence_frota" id="recurrence_frota"
            value="1"
            {{ old('recurrence_frota', $solicitationPricing->recurrence_frota ?? false) ? 'checked' : '' }}>
          <label class="form-check-label" for="recurrence_frota">Frota</label>
        </div>
      </div>

      <!-- Vigências -->
      <div class="col-12">
        <h6 class="mt-3 mb-2">Vigências (dias)</h6>
      </div>
      <div class="col-md-3 form-floating">
        <input type="number" name="validity_days" id="validity_days"
          class="form-control @error('validity_days') is-invalid @enderror"
          value="{{ old('validity_days', $solicitationPricing->validity_days ?? '') }}" placeholder="Vigência Geral">
        <label for="validity_days">Geral</label>
        @error('validity_days')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-3 form-floating">
        <input type="number" name="validity_autonomo_days" id="validity_autonomo_days"
          class="form-control @error('validity_autonomo_days') is-invalid @enderror"
          value="{{ old('validity_autonomo_days', $solicitationPricing->validity_autonomo_days ?? '') }}"
          placeholder="Autônomo">
        <label for="validity_autonomo_days">Autônomo</label>
        @error('validity_autonomo_days')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-3 form-floating">
        <input type="number" name="validity_agregado_days" id="validity_agregado_days"
          class="form-control @error('validity_agregado_days') is-invalid @enderror"
          value="{{ old('validity_agregado_days', $solicitationPricing->validity_agregado_days ?? '') }}"
          placeholder="Agregado">
        <label for="validity_agregado_days">Agregado</label>
        @error('validity_agregado_days')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
      <div class="col-md-3 form-floating">
        <input type="number" name="validity_funcionario_days" id="validity_funcionario_days"
          class="form-control @error('validity_funcionario_days') is-invalid @enderror"
          value="{{ old('validity_funcionario_days', $solicitationPricing->validity_funcionario_days ?? '') }}"
          placeholder="Funcionário">
        <label for="validity_funcionario_days">Funcionário</label>
        @error('validity_funcionario_days')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="d-flex gap-2 mt-4 justify-content-end">
      <button type="submit" class="btn btn-primary btn-lg px-4">Salvar</button>
      <a href="{{ route('solicitation-pricings.index') }}" class="btn btn-secondary btn-lg px-4">Cancelar</a>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
  $(function() {
    $('.money-mask').mask('000.000.000,00', {
      reverse: true
    });
  });
</script>

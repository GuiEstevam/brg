@extends('layouts.app')
@section('title', 'Nova Solicitação')

@section('content')
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('solicitations.index') }}">Solicitações</a></li>
      <li class="breadcrumb-item active" aria-current="page">Nova Solicitação</li>
    </ol>
  </nav>

  <div class="d-flex justify-content-center">
    <div class="enterprise-form-card w-100">
      <h1 class="mb-4 text-center">Nova Solicitação</h1>

      <form method="POST" action="{{ route('solicitations.store') }}" id="solicitation-form">
        @csrf

        <!-- Passo 1: Tipo de Entidade -->
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">
              <i class="fas fa-search me-2"></i>
              Passo 1: O que você quer pesquisar?
            </h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <div class="form-check p-3 border rounded h-100 entity-option" onclick="selectEntityType('driver')">
                  <input class="form-check-input" type="radio" name="entity_type" id="driver" value="driver"
                    required>
                  <label class="form-check-label" for="driver">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-user-tie fa-2x text-primary me-3"></i>
                      <div>
                        <h6 class="mb-1">Motorista</h6>
                        <small class="text-muted">Pesquisar dados de CNH, processos, etc.</small>
                      </div>
                    </div>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check p-3 border rounded h-100 entity-option" onclick="selectEntityType('vehicle')">
                  <input class="form-check-input" type="radio" name="entity_type" id="vehicle" value="vehicle"
                    required>
                  <label class="form-check-label" for="vehicle">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-truck fa-2x text-success me-3"></i>
                      <div>
                        <h6 class="mb-1">Veículo</h6>
                        <small class="text-muted">Pesquisar dados de placa, documentos, etc.</small>
                      </div>
                    </div>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check p-3 border rounded h-100 entity-option" onclick="selectEntityType('composed')">
                  <input class="form-check-input" type="radio" name="entity_type" id="composed" value="composed"
                    required>
                  <label class="form-check-label" for="composed">
                    <div class="d-flex align-items-center">
                      <i class="fas fa-link fa-2x text-warning me-3"></i>
                      <div>
                        <h6 class="mb-1">Composta</h6>
                        <small class="text-muted">Motorista + Veículo juntos</small>
                      </div>
                    </div>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Passo 2: Dados da Entidade -->
        <div class="card mb-4" id="entity-data-section" style="display: none;">
          <div class="card-header">
            <h5 class="mb-0">
              <i class="fas fa-info-circle me-2"></i>
              Passo 2: Dados para pesquisa
            </h5>
          </div>
          <div class="card-body">

            <!-- Dados do Motorista -->
            <div id="driver-data" class="entity-data" style="display: none;">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">
                    <i class="fas fa-user me-2"></i>CPF do Motorista
                  </label>
                  <input type="text" name="driver_entity_value" class="form-control" placeholder="000.000.000-00"
                    maxlength="14">
                  <div class="form-text">
                    <i class="fas fa-info-circle me-1"></i>Digite o CPF do motorista
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">
                    <i class="fas fa-list me-2"></i>Ou selecione um motorista existente
                  </label>
                  <div class="input-group">
                    <select name="driver_select_id" class="form-select">
                      <option value="">Selecione um motorista...</option>
                      @foreach ($drivers as $driver)
                        <option value="{{ $driver->id }}" data-cpf="{{ $driver->cpf }}">{{ $driver->name }}
                          ({{ $driver->cpf }})
                        </option>
                      @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                      data-bs-target="#quickDriverModal" title="Cadastrar novo motorista">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                  <div class="form-text">
                    <i class="fas fa-arrow-up me-1"></i>Ou digite o CPF acima
                  </div>
                </div>
              </div>

              <!-- Botão de cadastro rápido mais explícito -->
              <div class="row mt-3">
                <div class="col-12">
                  <div class="alert alert-info d-flex align-items-center">
                    <i class="fas fa-lightbulb me-2"></i>
                    <div>
                      <strong>Dica:</strong> Não encontrou o motorista?
                      <button type="button" class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal"
                        data-bs-target="#quickDriverModal">
                        <i class="fas fa-user-plus me-1"></i>Cadastrar Novo Motorista
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Dados do Veículo -->
            <div id="vehicle-data" class="entity-data" style="display: none;">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">
                    <i class="fas fa-car me-2"></i>Placa do Veículo
                  </label>
                  <input type="text" name="vehicle_entity_value" class="form-control" placeholder="ABC-1234"
                    maxlength="8">
                  <div class="form-text">
                    <i class="fas fa-info-circle me-1"></i>Digite a placa do veículo
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-bold">
                    <i class="fas fa-list me-2"></i>Ou selecione um veículo existente
                  </label>
                  <div class="input-group">
                    <select name="vehicle_select_id" class="form-select">
                      <option value="">Selecione um veículo...</option>
                      @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" data-plate="{{ $vehicle->plate }}">{{ $vehicle->plate }}
                          ({{ $vehicle->model }})
                        </option>
                      @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                      data-bs-target="#quickVehicleModal" title="Cadastrar novo veículo">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                  <div class="form-text">
                    <i class="fas fa-arrow-up me-1"></i>Ou digite a placa acima
                  </div>
                </div>
              </div>

              <!-- Botão de cadastro rápido mais explícito -->
              <div class="row mt-3">
                <div class="col-12">
                  <div class="alert alert-info d-flex align-items-center">
                    <i class="fas fa-lightbulb me-2"></i>
                    <div>
                      <strong>Dica:</strong> Não encontrou o veículo?
                      <button type="button" class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal"
                        data-bs-target="#quickVehicleModal">
                        <i class="fas fa-car me-1"></i>Cadastrar Novo Veículo
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Dados Compostos -->
            <div id="composed-data" class="entity-data" style="display: none;">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-bold">
                    <i class="fas fa-user me-2"></i>Motorista
                  </label>
                  <div class="input-group">
                    <select name="composed_driver_id" class="form-select">
                      <option value="">Selecione um motorista...</option>
                      @foreach ($drivers as $driver)
                        <option value="{{ $driver->id }}" data-cpf="{{ $driver->cpf }}">{{ $driver->name }}
                          ({{ $driver->cpf }})
                        </option>
                      @endforeach
                    </select>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                      data-bs-target="#quickDriverModal" title="Cadastrar novo motorista">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                  <div class="form-text">
                    <i class="fas fa-exclamation-triangle me-1"></i>Motorista é obrigatório para pesquisa composta
                  </div>
                </div>
              </div>

              <!-- Dica para cadastro rápido -->
              <div class="row mt-3">
                <div class="col-12">
                  <div class="alert alert-warning d-flex align-items-center">
                    <i class="fas fa-lightbulb me-2"></i>
                    <div>
                      <strong>Dica:</strong> Não encontrou o motorista?
                      <button type="button" class="btn btn-sm btn-primary ms-2" data-bs-toggle="modal"
                        data-bs-target="#quickDriverModal">
                        <i class="fas fa-user-plus me-1"></i>Cadastrar Novo Motorista
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-12">
                  <label class="form-label fw-bold">
                    <i class="fas fa-cars me-2"></i>Veículos (1 a 4 veículos)
                  </label>
                  <div id="vehicles-container">
                    <div class="vehicle-item mb-3">
                      <div class="row">
                        <div class="col-md-10">
                          <select name="composed_vehicles[]" class="form-select vehicle-select">
                            <option value="">Selecione um veículo...</option>
                            @foreach ($vehicles as $vehicle)
                              <option value="{{ $vehicle->id }}" data-plate="{{ $vehicle->plate }}">
                                {{ $vehicle->plate }}
                                ({{ $vehicle->model }})
                              </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-2">
                          <button type="button" class="btn btn-outline-danger btn-sm remove-vehicle"
                            style="display: none;">
                            <i class="fas fa-trash"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex gap-2 mt-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-vehicle">
                      <i class="fas fa-plus me-1"></i>Adicionar Veículo
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                      data-bs-target="#quickVehicleModal">
                      <i class="fas fa-car me-1"></i>Cadastrar Novo Veículo
                    </button>
                  </div>

                  <div class="form-text">
                    <i class="fas fa-info-circle me-1"></i>Selecione de 1 a 4 veículos para a pesquisa composta
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Passo 3: Configurações -->
        <div class="card mb-4" id="config-section" style="display: none;">
          <div class="card-header config-header">
            <h5 class="mb-0">
              <i class="fas fa-cog me-2"></i>
              Passo 3: Configurações da pesquisa
            </h5>
          </div>
          <div class="card-body">
            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label fw-bold">
                  <i class="fas fa-search me-2"></i>Tipo de Pesquisa
                </label>
                <select name="research_type" class="form-select" required>
                  <option value="">Selecione...</option>
                  <option value="basic" selected>Básica</option>
                  <option value="complete">Completa</option>
                  <option value="express">Expressa</option>
                </select>
                <div class="form-text">
                  <div class="mt-2">
                    <div class="d-flex align-items-center mb-1">
                      <i class="fas fa-check-circle text-success me-2"></i>
                      <strong>Básica:</strong> Dados principais
                    </div>
                    <div class="d-flex align-items-center mb-1">
                      <i class="fas fa-star text-warning me-2"></i>
                      <strong>Completa:</strong> Todos os dados disponíveis
                    </div>
                    <div class="d-flex align-items-center">
                      <i class="fas fa-bolt text-info me-2"></i>
                      <strong>Expressa:</strong> Resultado rápido
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold">
                  <i class="fas fa-link me-2"></i>Tipo de Vínculo
                </label>
                <select name="vincle_type" class="form-select" required>
                  <option value="">Selecione...</option>
                  @foreach (get_vincle_types() as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                  @endforeach
                </select>
                <div class="form-text">
                  <i class="fas fa-calendar me-1"></i>Define o período de validade da pesquisa
                </div>
              </div>
              <div class="col-md-4">
                <label class="form-label fw-bold">
                  <i class="fas fa-dollar-sign me-2"></i>Preço Estimado
                </label>
                <div class="estimated-price" id="estimated-price">
                  R$ 0,00
                </div>
                <div class="form-text">
                  <i class="fas fa-calculator me-1"></i>Preço calculado automaticamente
                </div>
              </div>
              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="auto_renewal" id="auto_renewal">
                  <label class="form-check-label fw-bold" for="auto_renewal">
                    <i class="fas fa-sync-alt me-2"></i>
                    Renovação automática
                  </label>
                  <div class="form-text">
                    <i class="fas fa-info-circle me-1"></i>A pesquisa será renovada automaticamente antes de expirar
                  </div>
                </div>
              </div>
              <div class="col-12">
                <label class="form-label fw-bold">
                  <i class="fas fa-sticky-note me-2"></i>Observações
                </label>
                <textarea name="notes" class="form-control" rows="3"
                  placeholder="Observações adicionais sobre esta solicitação..."></textarea>
                <div class="form-text">
                  <i class="fas fa-info-circle me-1"></i>Campo opcional para informações extras
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Campos ocultos para contexto -->
        <input type="hidden" name="enterprise_id"
          value="{{ current_enterprise_id() ?? (auth()->user()->enterprises->first()->id ?? 1) }}">
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <input type="hidden" name="branch_id" value="{{ current_branch_id() }}">

        <!-- Progress Indicator -->
        <div class="progress progress-indicator">
          <div class="progress-bar" id="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33"
            aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <!-- Botões -->
        <div class="solicitation-form-buttons d-flex justify-content-between align-items-center">
          <div>
            <a href="{{ route('solicitations.index') }}" class="btn btn-outline-secondary">
              <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
          </div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-info" onclick="showHelp()">
              <i class="fas fa-question-circle me-2"></i>Ajuda
            </button>
            <button type="submit" class="btn btn-primary" id="submit-btn" disabled>
              <i class="fas fa-check me-2"></i>Criar Solicitação
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal para cadastro rápido de motorista -->
  <div class="modal fade" id="quickDriverModal" tabindex="-1" aria-labelledby="quickDriverModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="quickDriverModalLabel">
            <i class="fas fa-user-plus me-2"></i>Cadastro Rápido de Motorista
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="quickDriverForm">
            <div class="row g-3">
              <div class="col-12">
                <label class="form-label">Nome Completo</label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">CPF</label>
                <input type="text" name="cpf" class="form-control" maxlength="14" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">CNH</label>
                <input type="text" name="cnh" class="form-control" required>
              </div>
              <div class="col-12">
                <label class="form-label">Telefone</label>
                <input type="text" name="phone" class="form-control">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="saveQuickDriver">
            <i class="fas fa-save me-2"></i>Salvar
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal para cadastro rápido de veículo -->
  <div class="modal fade" id="quickVehicleModal" tabindex="-1" aria-labelledby="quickVehicleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="quickVehicleModalLabel">
            <i class="fas fa-car me-2"></i>Cadastro Rápido de Veículo
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="quickVehicleForm">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Placa</label>
                <input type="text" name="plate" class="form-control" maxlength="8" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Modelo</label>
                <input type="text" name="model" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Marca</label>
                <input type="text" name="brand" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Ano</label>
                <input type="number" name="year" class="form-control" min="1900" max="2030" required>
              </div>
              <div class="col-12">
                <label class="form-label">Cor</label>
                <input type="text" name="color" class="form-control">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="saveQuickVehicle">
            <i class="fas fa-save me-2"></i>Salvar
          </button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <!-- Estilos específicos para o formulário de solicitação -->
@endpush

@push('scripts')
  <script>
    let currentEntityType = null;

    function selectEntityType(type) {
      console.log('Selecting entity type:', type);

      // Desmarcar todas as opções
      document.querySelectorAll('.entity-option input').forEach(input => {
        input.checked = false;
      });

      // Marcar a selecionada
      const selectedInput = document.getElementById(type);
      if (selectedInput) {
        selectedInput.checked = true;
        currentEntityType = type;
        console.log('Entity type set to:', currentEntityType);
      }

      // Mostrar seção de dados da entidade
      const entityDataSection = document.getElementById('entity-data-section');
      if (entityDataSection) {
        entityDataSection.style.display = 'block';
      }

      // Esconder todos os tipos de dados
      document.querySelectorAll('.entity-data').forEach(div => {
        div.style.display = 'none';
      });

      // Mostrar o tipo selecionado
      const selectedDataDiv = document.getElementById(type + '-data');
      if (selectedDataDiv) {
        selectedDataDiv.style.display = 'block';
      }

      // Limpar campos
      clearEntityFields();

      // Validar formulário
      validateForm();
    }

    function clearEntityFields() {
      console.log('Clearing entity fields');

      // Limpar todos os campos de entrada
      document.querySelectorAll('input[name="driver_entity_value"], input[name="vehicle_entity_value"]').forEach(
        input => {
          input.value = '';
        });

      // Limpar todos os selects
      document.querySelectorAll(
        'select[name="driver_select_id"], select[name="vehicle_select_id"], select[name="composed_driver_id"], select[name="composed_vehicle_id"]'
      ).forEach(select => {
        select.value = '';
      });

      // Resetar validação
      validateForm();
    }

    function formatCPF(input) {
      let value = input.value.replace(/\D/g, '');
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
      value = value.replace(/(\d{3})(\d)/, '$1.$2');
      value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
      input.value = value;
    }

    function formatPlate(input) {
      let value = input.value.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
      if (value.length > 3) {
        value = value.substring(0, 3) + '-' + value.substring(3);
      }
      input.value = value;
    }

    function validateForm() {
      console.log('Validating form, currentEntityType:', currentEntityType);

      let isValid = false;

      if (currentEntityType) {
        if (currentEntityType === 'driver') {
          const entityValueInput = document.querySelector('input[name="driver_entity_value"]');
          const driverSelect = document.querySelector('select[name="driver_select_id"]');

          if (entityValueInput) {
            const entityValue = entityValueInput.value.trim();
            const hasDriverId = driverSelect && driverSelect.value;

            isValid = entityValue.length > 0 || hasDriverId;
            console.log('Driver validation:', entityValue, hasDriverId, isValid);
          }
        } else if (currentEntityType === 'vehicle') {
          const entityValueInput = document.querySelector('input[name="vehicle_entity_value"]');
          const vehicleSelect = document.querySelector('select[name="vehicle_select_id"]');

          if (entityValueInput) {
            const entityValue = entityValueInput.value.trim();
            const hasVehicleId = vehicleSelect && vehicleSelect.value;

            isValid = entityValue.length > 0 || hasVehicleId;
            console.log('Vehicle validation:', entityValue, hasVehicleId, isValid);
          }
        } else if (currentEntityType === 'composed') {
          const driverSelect = document.querySelector('select[name="composed_driver_id"]');
          const vehicleSelects = document.querySelectorAll('select[name="composed_vehicles[]"]');

          if (driverSelect && vehicleSelects.length > 0) {
            const driverId = driverSelect.value;
            const vehicleIds = Array.from(vehicleSelects).map(select => select.value).filter(id => id);

            // Verificar se há pelo menos um motorista e um veículo
            isValid = driverId && vehicleIds.length > 0;

            // Verificar se não há veículos duplicados (apenas se houver mais de 1 selecionado)
            if (vehicleIds.length > 1 && vehicleIds.length !== new Set(vehicleIds).size) {
              isValid = false;
            }

            console.log('Composed validation:', driverId, vehicleIds, isValid);
          }
        }
      }

      // Mostrar/esconder seção de configurações
      const configSection = document.getElementById('config-section');
      const submitBtn = document.getElementById('submit-btn');

      if (configSection) {
        configSection.style.display = isValid ? 'block' : 'none';
        console.log('Config section display:', isValid ? 'block' : 'none');

        // Se está mostrando, inicializar valores padrão
        if (isValid) {
          initializeDefaultValues();
        }
      }

      if (submitBtn) {
        // Para o botão, vamos validar também os campos obrigatórios
        const researchType = document.querySelector('select[name="research_type"]');
        const vincleType = document.querySelector('select[name="vincle_type"]');

        let buttonValid = isValid;
        if (researchType && vincleType) {
          const researchTypeValue = researchType.value;
          const vincleTypeValue = vincleType.value;
          buttonValid = isValid && researchTypeValue && vincleTypeValue;
          console.log('Button validation:', researchTypeValue, vincleTypeValue, buttonValid);
        }

        submitBtn.disabled = !buttonValid;
        console.log('Submit button disabled:', !buttonValid);
      }

      // Atualizar progress indicator
      updateProgress();

      return isValid;
    }

    function initializeDefaultValues() {
      console.log('Initializing default values');

      // Definir valores padrão se não estiverem selecionados
      const researchType = document.querySelector('select[name="research_type"]');
      if (researchType && !researchType.value) {
        researchType.value = 'basic';
        console.log('Set research_type to basic');
      }

      // Calcular preço inicial
      calculatePrice();
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
      console.log('DOM loaded, setting up event listeners');

      // Validar quando campos mudarem
      document.querySelectorAll(
          'input[name="driver_entity_value"], input[name="vehicle_entity_value"], select[name="driver_select_id"], select[name="vehicle_select_id"], select[name="composed_driver_id"], select[name="composed_vehicle_id"]'
        )
        .forEach(element => {
          element.addEventListener('input', validateForm);
          element.addEventListener('change', validateForm);
        });

      // Adicionar listener específico para motorista da pesquisa composta
      const composedDriverSelect = document.querySelector('select[name="composed_driver_id"]');
      if (composedDriverSelect) {
        composedDriverSelect.addEventListener('change', function() {
          console.log('Composed driver changed:', this.value);
          validateForm();
        });
      }

      // Auto-preencher entity_value quando selects mudarem
      document.querySelectorAll('select[name="driver_select_id"]').forEach(select => {
        select.addEventListener('change', function() {
          if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const cpf = selectedOption.getAttribute('data-cpf');
            if (cpf) {
              const entityValueInput = this.closest('.entity-data').querySelector(
                'input[name="driver_entity_value"]');
              if (entityValueInput) {
                entityValueInput.value = cpf;
                validateForm();
              }
            }
          }
        });
      });

      document.querySelectorAll('select[name="vehicle_select_id"]').forEach(select => {
        select.addEventListener('change', function() {
          if (this.value) {
            const selectedOption = this.options[this.selectedIndex];
            const plate = selectedOption.getAttribute('data-plate');
            if (plate) {
              const entityValueInput = this.closest('.entity-data').querySelector(
                'input[name="vehicle_entity_value"]');
              if (entityValueInput) {
                entityValueInput.value = plate;
                validateForm();
              }
            }
          }
        });
      });

      // Calcular preço estimado
      const researchTypeSelect = document.querySelector('select[name="research_type"]');
      const vincleTypeSelect = document.querySelector('select[name="vincle_type"]');

      if (researchTypeSelect) {
        researchTypeSelect.addEventListener('change', function() {
          console.log('Research type changed:', this.value);
          calculatePrice();
          validateForm();
        });
      }
      if (vincleTypeSelect) {
        vincleTypeSelect.addEventListener('change', function() {
          console.log('Vincle type changed:', this.value);
          calculatePrice();
          validateForm();
        });
      }

      console.log('Event listeners set up successfully');

      // Gerenciar múltiplos veículos
      setupVehicleManagement();

      // Adicionar listener para submit do formulário
      const form = document.getElementById('solicitation-form');
      if (form) {
        form.addEventListener('submit', function(e) {
          console.log('Form submitted');

          // Validar antes de enviar
          if (!validateForm()) {
            e.preventDefault();
            alert('Por favor, preencha todos os campos obrigatórios.');
            return false;
          }

          // Verificar se os campos obrigatórios estão preenchidos
          const researchType = document.querySelector('select[name="research_type"]');
          const vincleType = document.querySelector('select[name="vincle_type"]');

          if (!researchType.value || !vincleType.value) {
            e.preventDefault();
            alert('Por favor, selecione o tipo de pesquisa e vínculo.');
            return false;
          }

          // Verificar se enterprise_id está preenchido
          const enterpriseId = document.querySelector('input[name="enterprise_id"]');
          if (!enterpriseId || !enterpriseId.value) {
            e.preventDefault();
            alert('Erro: ID da empresa não encontrado. Por favor, recarregue a página.');
            return false;
          }

          // Verificar se entity_type está selecionado
          if (!currentEntityType) {
            e.preventDefault();
            alert('Por favor, selecione o tipo de entidade.');
            return false;
          }

          // Mostrar loading no botão
          const submitBtn = document.getElementById('submit-btn');
          if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Criando...';
          }
        });
      }

      // Funções para cadastro rápido
      setupQuickCreateModals();
    });

    function calculatePrice() {
      const researchType = document.querySelector('select[name="research_type"]');
      const vincleType = document.querySelector('select[name="vincle_type"]');

      if (!researchType || !vincleType) {
        document.getElementById('estimated-price').textContent = 'R$ 0,00';
        return;
      }

      // Simular cálculo de preço
      let basePrice = 50.00;

      // Ajuste por tipo de pesquisa
      if (researchType.value === 'express') {
        basePrice *= 0.7;
      } else if (researchType.value === 'complete') {
        basePrice *= 1.3;
      }

      // Ajuste por tipo de entidade
      if (currentEntityType === 'composed') {
        basePrice *= 1.5;

        // Adicionar preço por veículo adicional
        const vehicleItems = document.querySelectorAll('.vehicle-item');
        if (vehicleItems.length > 1) {
          const additionalVehicles = vehicleItems.length - 1;
          const additionalPrice = additionalVehicles * 25.00; // R$ 25 por veículo adicional
          basePrice += additionalPrice;
        }
      }

      // Ajuste por vínculo
      if (vincleType.value === 'funcionario') {
        basePrice *= 1.2;
      }

      const priceElement = document.getElementById('estimated-price');
      if (priceElement) {
        priceElement.textContent = `R$ ${basePrice.toFixed(2).replace('.', ',')}`;
      }

      console.log('Price calculated:', basePrice);
    }

    function setupVehicleManagement() {
      const addVehicleBtn = document.getElementById('add-vehicle');
      const vehiclesContainer = document.getElementById('vehicles-container');

      if (addVehicleBtn && vehiclesContainer) {
        addVehicleBtn.addEventListener('click', function() {
          const vehicleItems = vehiclesContainer.querySelectorAll('.vehicle-item');

          if (vehicleItems.length >= 4) {
            alert('Máximo de 4 veículos permitido.');
            return;
          }

          const newVehicleItem = createVehicleItem(vehicleItems.length + 1);
          vehiclesContainer.appendChild(newVehicleItem);

          // Mostrar botão de remover no primeiro item se houver mais de 1
          if (vehicleItems.length === 0) {
            const firstRemoveBtn = vehiclesContainer.querySelector('.remove-vehicle');
            if (firstRemoveBtn) {
              firstRemoveBtn.style.display = 'inline-block';
            }
          }

          // Esconder botão de adicionar se chegou ao limite
          if (vehicleItems.length + 1 >= 4) {
            addVehicleBtn.style.display = 'none';
          }

          validateForm();
        });

        // Delegar eventos para botões de remover
        vehiclesContainer.addEventListener('click', function(e) {
          if (e.target.closest('.remove-vehicle')) {
            const vehicleItem = e.target.closest('.vehicle-item');
            if (vehicleItem) {
              vehicleItem.remove();

              // Mostrar botão de adicionar novamente
              addVehicleBtn.style.display = 'inline-block';

              // Esconder botão de remover se só sobrou 1 item
              const remainingItems = vehiclesContainer.querySelectorAll('.vehicle-item');
              if (remainingItems.length === 1) {
                const firstRemoveBtn = remainingItems[0].querySelector('.remove-vehicle');
                if (firstRemoveBtn) {
                  firstRemoveBtn.style.display = 'none';
                }
              }

              validateForm();
              calculatePrice(); // Recalcular preço
            }
          }
        });

        // Delegar eventos para mudanças nos selects de veículos
        vehiclesContainer.addEventListener('change', function(e) {
          if (e.target.name === 'composed_vehicles[]') {
            validateForm();
            calculatePrice(); // Recalcular preço quando veículo muda
          }
        });
      }
    }

    function createVehicleItem(order) {
      const div = document.createElement('div');
      div.className = 'vehicle-item mb-3';

      div.innerHTML = `
        <div class="row">
          <div class="col-md-10">
            <select name="composed_vehicles[]" class="form-select vehicle-select" required>
              <option value="">Selecione um veículo...</option>
              @foreach ($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}" data-plate="{{ $vehicle->plate }}">{{ $vehicle->plate }}
                  ({{ $vehicle->model }})
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-outline-danger btn-sm remove-vehicle">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>
      `;

      return div;
    }

    // Função para atualizar o progress indicator
    function updateProgress() {
      const progressBar = document.getElementById('progress-bar');
      let progress = 33; // Passo 1 sempre visível

      if (currentEntityType) {
        progress = 66; // Passo 2 preenchido
      }

      const configSection = document.getElementById('config-section');
      if (configSection && configSection.style.display !== 'none') {
        progress = 100; // Passo 3 visível
      }

      if (progressBar) {
        progressBar.style.width = progress + '%';
        progressBar.setAttribute('aria-valuenow', progress);
      }
    }

    // Função para mostrar ajuda
    function showHelp() {
      const helpText = `
        <div class="text-start">
          <h6><i class="fas fa-info-circle me-2"></i>Como criar uma solicitação:</h6>
          <ol class="mb-3">
            <li><strong>Passo 1:</strong> Selecione o tipo de pesquisa (Motorista, Veículo ou Composta)</li>
            <li><strong>Passo 2:</strong> Preencha os dados da entidade ou selecione uma existente</li>
            <li><strong>Passo 3:</strong> Configure as opções da pesquisa</li>
          </ol>

          <h6><i class="fas fa-lightbulb me-2"></i>Dicas:</h6>
          <ul class="mb-0">
            <li>Você pode digitar CPF/Placa ou selecionar de uma lista</li>
            <li>Use o botão "+" para cadastrar novos motoristas/veículos rapidamente</li>
            <li>Pesquisas compostas permitem 1-4 veículos por motorista</li>
            <li>O preço é calculado automaticamente baseado nas configurações</li>
          </ul>
        </div>
      `;

      // Usar SweetAlert2 se disponível, senão usar alert padrão
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Ajuda - Criar Solicitação',
          html: helpText,
          icon: 'info',
          confirmButtonText: 'Entendi!',
          confirmButtonColor: '#3085d6'
        });
      } else {
        alert(
          'Ajuda: Siga os passos indicados no formulário. Use os botões "+" para cadastrar novos motoristas/veículos rapidamente.'
        );
      }
    }

    // Funções para cadastro rápido
    function setupQuickCreateModals() {
      // Cadastro rápido de motorista
      const saveQuickDriverBtn = document.getElementById('saveQuickDriver');
      if (saveQuickDriverBtn) {
        saveQuickDriverBtn.addEventListener('click', function() {
          const form = document.getElementById('quickDriverForm');
          const formData = new FormData(form);

          fetch('/api/drivers/quick-create', {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
              },
              body: JSON.stringify(Object.fromEntries(formData)),
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                // Adicionar nova opção ao select
                const driverSelects = document.querySelectorAll(
                  'select[name="driver_select_id"], select[name="composed_driver_id"]');
                driverSelects.forEach(select => {
                  const option = new Option(`${data.driver.name} (${data.driver.cpf})`, data.driver.id);
                  option.setAttribute('data-cpf', data.driver.cpf);
                  select.add(option);
                  select.value = data.driver.id;
                });

                // Fechar modal e limpar formulário
                const modal = bootstrap.Modal.getInstance(document.getElementById('quickDriverModal'));
                modal.hide();
                form.reset();

                // Validar formulário
                validateForm();
              } else {
                alert('Erro ao criar motorista: ' + data.message);
              }
            })
            .catch(error => {
              console.error('Error:', error);
              alert('Erro ao criar motorista');
            });
        });
      }

      // Cadastro rápido de veículo
      const saveQuickVehicleBtn = document.getElementById('saveQuickVehicle');
      if (saveQuickVehicleBtn) {
        saveQuickVehicleBtn.addEventListener('click', function() {
          const form = document.getElementById('quickVehicleForm');
          const formData = new FormData(form);

          fetch('/api/vehicles/quick-create', {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
              },
              body: JSON.stringify(Object.fromEntries(formData)),
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                // Adicionar nova opção aos selects
                const vehicleSelects = document.querySelectorAll(
                  'select[name="vehicle_select_id"], select[name="composed_vehicles[]"]');
                vehicleSelects.forEach(select => {
                  const option = new Option(`${data.vehicle.plate} (${data.vehicle.model})`, data.vehicle.id);
                  option.setAttribute('data-plate', data.vehicle.plate);
                  select.add(option);
                  if (select.name === 'composed_vehicles[]') {
                    select.value = data.vehicle.id;
                  }
                });

                // Fechar modal e limpar formulário
                const modal = bootstrap.Modal.getInstance(document.getElementById('quickVehicleModal'));
                modal.hide();
                form.reset();

                // Validar formulário
                validateForm();
              } else {
                alert('Erro ao criar veículo: ' + data.message);
              }
            })
            .catch(error => {
              console.error('Error:', error);
              alert('Erro ao criar veículo');
            });
        });
      }
    }
  </script>
@endpush

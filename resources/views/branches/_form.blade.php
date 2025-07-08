<div class="d-flex justify-content-center">
    <div class="rounded-4 w-100" style="max-width: 1100px;">
        <p class="text-muted">
            Preencha os dados abaixo para {{ isset($branch) && $branch->exists ? 'editar' : 'criar' }} a filial.
        </p>
        <div class="row g-4">
            <!-- Empresa vinculada -->
            <div class="col-md-6 form-floating">
                <select name="enterprise_id" id="enterprise_id" class="form-select @error('enterprise_id') is-invalid @enderror" required>
                    <option value="">Selecione a empresa</option>
                    @foreach($enterprises as $enterprise)
                        <option value="{{ $enterprise->id }}"
                            @selected(old('enterprise_id', $branch->enterprise_id ?? request('enterprise_id')) == $enterprise->id)>
                            {{ $enterprise->name }}
                        </option>
                    @endforeach
                </select>
                <label for="enterprise_id">Empresa *</label>
                @error('enterprise_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 form-floating">
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                    name="name" id="name" placeholder="Nome"
                    value="{{ old('name', $branch->name ?? '') }}" required autocomplete="off">
                <label for="name">Nome da Filial *</label>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 form-floating">
                <input type="text" class="form-control @error('city') is-invalid @enderror"
                    name="city" id="city" placeholder="Cidade"
                    value="{{ old('city', $branch->city ?? '') }}" required>
                <label for="city">Cidade *</label>
                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3 form-floating">
                <input type="text" class="form-control @error('uf') is-invalid @enderror"
                    name="uf" id="uf" placeholder="UF"
                    value="{{ old('uf', $branch->uf ?? '') }}" required maxlength="2" style="text-transform:uppercase">
                <label for="uf">UF *</label>
                @error('uf') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3 form-floating">
                <input type="text" class="form-control @error('cep') is-invalid @enderror"
                    name="cep" id="cep" placeholder="CEP"
                    value="{{ old('cep', $branch->cep ?? '') }}">
                <label for="cep">CEP</label>
                @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 form-floating">
                <input type="text" class="form-control @error('address') is-invalid @enderror"
                    name="address" id="address" placeholder="Endereço"
                    value="{{ old('address', $branch->address ?? '') }}">
                <label for="address">Endereço</label>
                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-3 form-floating">
            <input type="text" class="form-control @error('district') is-invalid @enderror"
            name="district" id="district" placeholder="Bairro"
            value="{{ old('district', $branch->district ?? '') }}">
            <label for="district">Bairro</label>
            @error('district') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>


            <div class="col-md-3 form-floating">
                <input type="text" class="form-control @error('number') is-invalid @enderror"
                    name="number" id="number" placeholder="Número"
                    value="{{ old('number', $branch->number ?? '') }}">
                <label for="number">Número</label>
                @error('number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3 form-floating">
                <input type="text" class="form-control @error('complement') is-invalid @enderror"
                    name="complement" id="complement" placeholder="Complemento"
                    value="{{ old('complement', $branch->complement ?? '') }}">
                <label for="complement">Complemento</label>
                @error('complement') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3 form-floating">
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="active" @selected(old('status', $branch->status ?? '')=='active')>Ativa</option>
                    <option value="inactive" @selected(old('status', $branch->status ?? '')=='inactive')>Inativa</option>
                </select>
                <label for="status">Status *</label>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="d-flex gap-2 mt-4 justify-content-end">
            <button type="submit" class="btn btn-primary btn-lg px-4">Salvar</button>
            <a href="{{ route('branches.index') }}" class="btn btn-secondary btn-lg px-4">Cancelar</a>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <div class="p-4 p-md-5 rounded-4 w-100">
        <p class="text-muted">Preencha os dados abaixo para {{ isset($enterprise) && $enterprise->exists ? 'editar' : 'criar' }} a empresa.</p>
        <div class="row g-4">
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nome" value="{{ old('name', $enterprise->name ?? '') }}" required autocomplete="off">
                <label for="name">Nome *</label>
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control @error('cnpj') is-invalid @enderror" name="cnpj" id="cnpj" placeholder="CNPJ" value="{{ old('cnpj', $enterprise->cnpj ?? '') }}" required autocomplete="off">
                <label for="cnpj">CNPJ *</label>
                @error('cnpj') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control @error('state_registration') is-invalid @enderror" name="state_registration" id="state_registration" placeholder="Inscrição Estadual" value="{{ old('state_registration', $enterprise->state_registration ?? '') }}">
                <label for="state_registration">Inscrição Estadual</label>
                @error('state_registration') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Endereço" value="{{ old('address', $enterprise->address ?? '') }}" required>
                <label for="address">Endereço *</label>
                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 form-floating">
                <input type="text" class="form-control @error('number') is-invalid @enderror" name="number" id="number" placeholder="Número" value="{{ old('number', $enterprise->number ?? '') }}" required>
                <label for="number">Número *</label>
                @error('number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 form-floating">
                <input type="text" class="form-control @error('uf') is-invalid @enderror" name="uf" id="uf" placeholder="UF" value="{{ old('uf', $enterprise->uf ?? '') }}" required maxlength="2" style="text-transform:uppercase">
                <label for="uf">UF *</label>
                @error('uf') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 form-floating">
                <input type="text" class="form-control @error('complement') is-invalid @enderror" name="complement" id="complement" placeholder="Complemento" value="{{ old('complement', $enterprise->complement ?? '') }}">
                <label for="complement">Complemento</label>
                @error('complement') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 form-floating">
                <input type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" id="cep" placeholder="CEP" value="{{ old('cep', $enterprise->cep ?? '') }}" required>
                <label for="cep">CEP *</label>
                @error('cep') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 form-floating">
                <input type="text" class="form-control @error('district') is-invalid @enderror" name="district" id="district" placeholder="Bairro" value="{{ old('district', $enterprise->district ?? '') }}" required>
                <label for="district">Bairro *</label>
                @error('district') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-4 form-floating">
                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id="city" placeholder="Cidade" value="{{ old('city', $enterprise->city ?? '') }}" required>
                <label for="city">Cidade *</label>
                @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control @error('responsible_name') is-invalid @enderror" name="responsible_name" id="responsible_name" placeholder="Responsável" value="{{ old('responsible_name', $enterprise->responsible_name ?? '') }}">
                <label for="responsible_name">Responsável</label>
                @error('responsible_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 form-floating">
                <input type="email" class="form-control @error('responsible_email') is-invalid @enderror" name="responsible_email" id="responsible_email" placeholder="Email do Responsável" value="{{ old('responsible_email', $enterprise->responsible_email ?? '') }}">
                <label for="responsible_email">Email do Responsável</label>
                @error('responsible_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 form-floating">
                <input type="text" class="form-control @error('responsible_phone') is-invalid @enderror" name="responsible_phone" id="responsible_phone" placeholder="Telefone do Responsável" value="{{ old('responsible_phone', $enterprise->responsible_phone ?? '') }}">
                <label for="responsible_phone">Telefone do Responsável</label>
                @error('responsible_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 form-floating">
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="active" @selected(old('status', $enterprise->status ?? '')=='active')>Ativa</option>
                    <option value="inactive" @selected(old('status', $enterprise->status ?? '')=='inactive')>Inativa</option>
                </select>
                <label for="status">Status *</label>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="d-flex gap-2 mt-4 justify-content-end">
            <button type="submit" class="btn btn-primary btn-lg px-4">Salvar</button>
            <a href="{{ route('enterprises.index') }}" class="btn btn-secondary btn-lg px-4">Cancelar</a>
        </div>
    </div>
</div>

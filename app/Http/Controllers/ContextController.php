<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuditLogger;

class ContextController extends Controller
{
    public function select()
    {
        $user = auth()->user();
        $empresas = $user->enterprises()->orderBy('name')->get();

        // Só uma empresa: prossegue para filial ou já preenche tudo
        if ($empresas->count() === 1) {
            $empresa = $empresas->first();
            $filiais = $empresa->branches()->orderBy('name')->get();
            if ($filiais->count() === 1) {
                session([
                    'empresa_id' => $empresa->id,
                    'empresa_nome' => $empresa->name,
                    'filial_id' => $filiais->first()->id,
                    'filial_nome' => $filiais->first()->name,
                ]);
                return redirect()->intended('/dashboard');
            }
            session([
                'empresa_id' => $empresa->id,
                'empresa_nome' => $empresa->name,
            ]);
            return view('context.select-filial', compact('empresa', 'filiais'));
        }

        // Várias empresas: pede escolha
        return view('context.select-empresa', compact('empresas'));
    }

    public function setEmpresa(Request $request)
    {
        $empresaId = $request->input('empresa_id');
        $empresa = auth()->user()->enterprises()->findOrFail($empresaId);
        $filiais = $empresa->branches()->orderBy('name')->get();

        if ($filiais->count() === 1) {
            session([
                'empresa_id' => $empresa->id,
                'empresa_nome' => $empresa->name,
                'filial_id' => $filiais->first()->id,
                'filial_nome' => $filiais->first()->name,
            ]);
            AuditLogger::log('context_selected', null, [], [
                'empresa_id' => $empresa->id,
                'filial_id' => $filiais->first()->id,
            ]);
            return redirect()->intended('/dashboard');
        }

        // Pede escolha de filial
        session([
            'empresa_id' => $empresa->id,
            'empresa_nome' => $empresa->name,
        ]);
        AuditLogger::log('context_selected_empresa', null, [], [
            'empresa_id' => $empresa->id,
        ]);
        return view('context.select-filial', compact('empresa', 'filiais'));
    }

    public function setFilial(Request $request)
    {
        $empresaId = session('empresa_id');
        $empresa = auth()->user()->enterprises()->findOrFail($empresaId);
        $filialId = $request->input('filial_id');
        $filial = $empresa->branches()->findOrFail($filialId);

        session([
            'filial_id' => $filial->id,
            'filial_nome' => $filial->name,
        ]);
        AuditLogger::log('context_selected_filial', null, [], [
            'empresa_id' => $empresa->id,
            'filial_id' => $filial->id,
        ]);
        return redirect()->intended('/dashboard');
    }

    public function trocar()
    {
        session()->forget(['empresa_id', 'empresa_nome', 'filial_id', 'filial_nome']);
        AuditLogger::log('context_cleared', null, [], []);
        return redirect()->route('context.select');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $busca = $request->input('busca');

        $clientes = Cliente::query()
            ->when($busca, function ($query, $busca) {
                $query->where('nome', 'like', "%{$busca}%")
                      ->orWhere('email', 'like', "%{$busca}%")
                      ->orWhere('cidade', 'like', "%{$busca}%");
            })
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('clientes.index', compact('clientes', 'busca'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(ClienteRequest $request)
    {
        Cliente::create($request->validated());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $cliente->update($request->validated());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente removido com sucesso!');
    }

    /**
     * Consulta CEP via ViaCEP (substituto público à API dos Correios)
     * Rota AJAX chamada pelo frontend.
     */
    public function consultaCep(string $cep)
    {
        $cep = preg_replace('/\D/', '', $cep);

        if (strlen($cep) !== 8) {
            return response()->json(['error' => 'CEP inválido.'], 422);
        }

        try {
            $response = Http::timeout(5)->get("https://viacep.com.br/ws/{$cep}/json/");

            if ($response->failed() || isset($response->json()['erro'])) {
                return response()->json(['error' => 'CEP não encontrado.'], 404);
            }

            $dados = $response->json();

            return response()->json([
                'rua'    => $dados['logradouro'] ?? '',
                'bairro' => $dados['bairro']     ?? '',
                'cidade' => $dados['localidade'] ?? '',
                'estado' => $dados['uf']         ?? '',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao consultar o CEP.'], 500);
        }
    }
}

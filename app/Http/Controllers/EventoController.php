<?php
namespace App\Http\Controllers;

use App\Models\Evento;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::paginate(5);
        return view('eventos.index', compact('eventos'));
    }

    public function create()
    {
        return view('eventos.create');
    }

    public function store(Request $request)
    {
        try {
            // Valida os dados
            $validatedData = $request->validate([
                'nome' => 'required',
                'descricao' => 'required',
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date',
                'horario' => 'required',
                'local' => 'required',
                'contato' => '',
                'termo_autorizacao' => '',
                'observacao' => '',
            ]);

            // Adiciona o token aos dados validados
            $validatedData['token'] = Str::random(64);

            // Cria o evento com os dados validados
            Evento::create($validatedData);

            // Redireciona para a lista com mensagem de sucesso
            return redirect()->route('eventos.index')->with('success', 'Evento criado com sucesso!');

        } catch (ValidationException $e) {
            // Redireciona de volta com os erros de validação
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (Exception $ex) {
            // Redireciona de volta com mensagem de erro genérica
            return redirect()->back()->withErrors(['error' => 'Ocorreu um erro: ' . $ex->getMessage()])->withInput();
        }
    }

      /**
     * Exibir os detalhes de um evento específico.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\View\View
     */
    public function show(Evento $evento)
    {
        return view('eventos.show', compact('evento'));
    }

    public function edit(Evento $evento)
    {
        return view('eventos.edit', compact('evento'));
    }

    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'nome' => 'required',
            'descricao' => 'required',
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
            'horario' => 'required',
            'local' => 'required'
        ]);

        $evento->update($request->all());
        return redirect()->route('eventos.index')->with('success', 'Evento atualizado com sucesso!');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('eventos.index')->with('success', 'Evento excluído com sucesso!');
    }

    public function compartilhar($id)
    {
        // Busca o evento pelo ID
        $evento = Evento::findOrFail($id);

        // Retorna a view com os dados do evento
        return view('eventos.compartilhar', compact('evento'));
    }
}

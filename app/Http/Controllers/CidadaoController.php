<?php

namespace App\Http\Controllers;

use App\Cidadao;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use \Illuminate\Http\Response;
use \Illuminate\Support\Facades\Response as FacadeResponse;
use \Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ResponseObject;

class CidadaoController extends Controller
{
    public function index()
    {
        $cidadao = Cidadao::orderBy('nome')->get();
        return response()->json($cidadao,200);
    }

    public function store(Request $request, $cpf = 0)
    {   
        $is_edit =  $cpf == 0 ? false : true;
        $response = new ResponseObject;
        
        $validator = !$is_edit ? Validator::make($request->json()->all(), [
            'cpf'         => 'required|unique:cidadaos|max:15',
            'nome'        => 'required|max:50',
            'telefone'    => 'max:15',
            'email'       => 'max:50',
            'celular'     => 'max:15',
            'cep'         => 'required|max:8|min:8',
            'logradouro'  => 'max:50'
        ]) : Validator::make($request->json()->all(), [
            'cpf'         => 'required|max:15',
            'nome'        => 'required|max:50',
            'telefone'    => 'max:15',
            'email'       => 'max:50',
            'celular'     => 'max:15',
            'cep'         => 'required|max:8|min:8',
            'logradouro'  => 'max:50'
        ]);

        if ($validator->fails()) {
            $response->status = '400';
            $response->code = 'Erro';
            foreach ($validator->errors()->getMessages() as $item) {
                array_push($response->messages, $item);
            }
        }
        else
        {
            try {
                $cidadao = !$is_edit ? new Cidadao() : Cidadao::where('cpf','=',$cpf)->first();
                if(!$cidadao){
                    $response->status = '400';
                    $response->code = 'Cidadão não encontrado';
                    array_push($response->messages, $e->getMessage());
                    return FacadeResponse::json($response,400);    
                }

                $result = json_decode(file_get_contents('https://viacep.com.br/ws/'.$request->cep.'/json'), true);//$client->request('GET', 'https://viacep.com.br/ws/79700000/json/');
                
                $cidadao->nome          = $request->nome;
                $cidadao->cpf           = $request->cpf;
                $cidadao->telefone      = $request->telefone;
                $cidadao->email         = $request->email;
                $cidadao->celular       = $request->celular;
                $cidadao->cep           = $request->cep;
                $cidadao->logradouro    = $result['logradouro'] == null ? '' : $result['logradouro'];
                $cidadao->bairro        = $result['bairro'] == null ? '' : $result['bairro'];
                $cidadao->cidade        = $result['localidade'] == null ? '' : $result['localidade'];
                $cidadao->uf            = $result['uf'] == null ? '' : $result['uf'];
                $cidadao->save();
                $response = $cidadao; 
                $response->code = 200;   
           } catch (Exception $e) {
                $response->status = '400';
                $response->code = 400;
                array_push($response->messages, $e->getMessage());
                
            } catch (ErrorException $e) {
                $response->status = '400';
                $response->code = 400;
                array_push($response->messages, $e->getMessage());
            }
    
                    
        }

        return FacadeResponse::json($response);    
    }

    public function show($cpf)
    {
        $cidadao = Cidadao::where('cpf','=',$cpf)->first();
        return response()->json($cidadao,200);
    }

    public function delete($cpf)
    {
        $cidadao = Cidadao::where('cpf','=',$cpf)->delete();
        return response()->json('OK');
    }    
    
}

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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cidadao = Cidadao::orderBy('nome')->get();
        return response()->json($cidadao);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $cpf = 0)
    {   
        if($cpf !=0){
            return response()->json('EDITANDO');
        }

        $response = new ResponseObject;
        
        $validator = Validator::make($request->json()->all(), [
            'cpf'         => 'required|unique:cidadaos|max:15',
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
                $client = new Client();
                $result = json_decode(file_get_contents('https://viacep.com.br/ws/'.$request->cep.'/json'), true);//$client->request('GET', 'https://viacep.com.br/ws/79700000/json/');
                $cidadao = new Cidadao();
                $cidadao->nome = $request->nome;
                $cidadao->cpf = $request->cpf;
                $cidadao->telefone = $request->telefone;
                $cidadao->email = $request->email;
                $cidadao->celular = $request->celular;
                $cidadao->cep = $request->cep;
                $cidadao->logradouro  = $result['logradouro'];
                $cidadao->bairro      = $result['bairro'];
                $cidadao->cidade      = $result['localidade'];
                $cidadao->uf          = $result['uf'];
                $cidadao->save();
                $response = $cidadao;    
           } catch (Exception $e) {
                $response->status = '400';
                $response->code = 'Erro';
                array_push($response->messages, $e->getMessage());
                
            } catch (ErrorException $e) {
                $response->status = '400';
                $response->code = 'Erro';
                array_push($response->messages, $e->getMessage());
            }
    
                    
        }

        return FacadeResponse::json($response);    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cidadao  $cidadao
     * @return \Illuminate\Http\Response
     */
    public function show($cpf)
    {
        $cidadao = Cidadao::where('cpf','=',$cpf)->get();
        return response()->json($cidadao);
    }

    public function delete($cpf)
    {
        $cidadao = Cidadao::where('cpf','=',$cpf)->delete();
        return response()->json('OK');
    }

    public function edit($cpf){
        $cidadao = Cidadao::where('cpf','=',$cpf)->get();

        if(count($cidado > 0)){
            //edit
        } else {
            return response()->json('Cidadão não encontrado!');
        }
    }

    

    
}

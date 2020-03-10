<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CidadaoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testGetAll()
    {
        $response = $this->json('GET', '/api/cidadao');

        $response
            ->assertStatus(200);
    }

    public function testGetOne()
    {
        $response = $this->json('GET', '/api/cidadao/03105877193');

        $response
            ->assertStatus(200);
    }

    public function testeSave()
    {
        $this->json('POST', '/api/cidadao', [
                    "nome" => "ANA P SECCATTO",
                    "cpf" => "12345678900",
                    "telefone" => "6734671681",
                    "email" => "anap@gmail.com",
                    "celular" => "67996390394",
                    "cep" => "79700000"        
                ])->assertStatus(200);
    }

  

}


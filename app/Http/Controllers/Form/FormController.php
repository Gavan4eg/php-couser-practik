<?php

namespace App\Http\Controllers\Form;

use App\Http\Controllers\Controller;
use App\Http\Requests\Form\OrderRequest;

class FormController extends Controller
{
    public function send(OrderRequest $request)
    {
        $data = $request->validated();

        $row = [
          'name' => $data['name'],
          'phone' => $data['phone'],
          'email' => $data['email'],
          'telegram' => $data['telegram'],
        ];

        dd($data);
    }
}

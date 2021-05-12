<?php

namespace VirtualClickAuth;

use Illuminate\Support\Facades\Session;


final class VCAuth extends AbstractVCAuth
{


    public function validaToken()
    {

        $dadosRetorno = $this->validaViaServicoDeAutenticacao();

        if (isset($dadosRetorno->usuario)) {

            Session::put('usuario', $dadosRetorno->usuario);
        }

        return $dadosRetorno->autorizado;
    }
}

<?php

namespace VirtualClickAuth;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Session;

abstract class AbstractVCAuth implements VCAuthInterface
{

    protected $request;

    protected $token;

    public function __construct($request)
    {

        $this->request = $request;
        $this->getToken();
    }

    private function getToken()
    {

        $authorization = $this->request->header('Authorization');

        $this->token = str_replace('Bearer ', '', $authorization);
    }

    protected function validaViaServicoDeAutenticacao()
    {

        if (empty($this->token)) {
            $authIp = $this->request->server('REMOTE_ADDR');
            if (config('vcauth.vcAuthUseForwardedFor')) {
                $authIp = $this->request->server('HTTP_X_FORWARDED_FOR');
            }

            if ($this->comparaIp($authIp)) {
                return (object)[
                    'autorizado' => true,
                    'usuario' => null,
                ];
            }

            return (object)[
                'autorizado' => false,
                'usuario' => null,
            ];
        }

        $header = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer ' . config('vcauth.vcAuthToken'),
        ];

        $opcoes = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HEADER => 1,
            CURLOPT_URL => config('vcauth.vcAuthUrl') . '/' . $this->token,
            CURLOPT_HTTPHEADER => $header,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, $opcoes);
        $response = curl_exec($curl);

        $tamanhoHeader = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $dados = substr($response, $tamanhoHeader);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($statusCode != 200) {
            return (object)[
                'autorizado' => false,
                'usuario' => null,
            ];
        }

        $retorno = json_decode($dados);

        return $retorno->data;
    }

    protected function comparaIp($authIp)
    {

        $ipsLiberados = config('vcauth.ipsLiberados');

        if (in_array($authIp, $ipsLiberados)) {
            return true;
        }

        $authIExplode = explode('.', $authIp);
        $authIArray = [
            $authIExplode[0] . '.*.*.*',
            $authIExplode[0] . '.' . $authIExplode[1] . '.*.*',
            $authIExplode[0] . '.' . $authIExplode[1] . '.' . $authIExplode[2] . '.*',
        ];

        $diferencaArray = array_diff($authIArray, $ipsLiberados);

        if ($diferencaArray != $authIArray) {
            return true;
        }

        return false;
    }

}

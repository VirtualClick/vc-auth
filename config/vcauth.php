<?php

/**
 * ----------------------------------------------------------------------------------------------------------------
 * Virtual Click Autênticação config
 * ----------------------------------------------------------------------------------------------------------------
 *
 * Utiliz as achaves do .env para fazer suas configurações
 * VCAUTH_URL = URL do serviço de autenticação
 * VCAUTH_TOKEN = Token disponibilizado pelo serviço de autenticação (Para gerar veja a documentação do serviço)
 */

return [
    'vcAuthUrl' => env('VCAUTH_URL', 'http://localhost'),
    'vcAuthToken' => env('VCAUTH_TOKEN', '123456'),
    'vcAuthUseForwardedFor' => env('VCAUTH_USE_FORWARDED_FOR', false),
    'ipsLiberados' => ['127.0.0.1'],
];

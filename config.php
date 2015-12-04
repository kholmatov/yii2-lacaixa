<?php
/**
 * @copyright Copyright &copy; Erkin Kholmatov, https://github.com/kholmatov, ekholmatov@gmail.com - 2015
 * @package yii2-lacaixa
 * @version 1.0.0
 */
return [
    'params' => [
        // list of parameters
        'FUC'=>'', //Ds_Merchant_MerchantCode
        'TERMINAL'=>'001', //Ds_Merchant_Terminal
        'CURRENCY'=>'978', //Ds_Merchant_Currency
        'TRANSACTIONTYPE'=>'0',//DS_MERCHANT_TRANSACTIONTYPE
        'KC'=>'', //Clave secreta de encriptación
        'FORM_URL'=>'https://sis-t.redsys.es:25443/sis/realizarPago',//La URL de llamada del entorno de test es
        'URL'=>'',//DS_MERCHANT_MERCHANTURL
        'URLOK'=>'',//DS_MERCHANT_URLOK
        'URLKO'=>'',//DS_MERCHANT_URLKO
        'PAYMETHODS'=>'CD', //Ds_Merchant_PayMethods
        'VERSION'=>'HMAC_SHA256_V1'
    ],
];

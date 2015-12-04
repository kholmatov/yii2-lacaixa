<?php
/**
 * @copyright Copyright &copy; Erkin Kholmatov, https://github.com/kholmatov, ekholmatov@gmail.com - 2015
 * @package yii2-lacaixa
 * @version 1.0.0
 */

namespace kholmatov\lacaixa;
use yii\base\Widget;

class RedsysWDG extends Widget
{
    public function init()
    {
        parent::init();
        Yii::configure($this, require(__DIR__ . '/config.php'));
    }

    public function getFormData($id="5555",$amount="6000",$language="002", $pDesc=""){
        $result=RedsysWDG::setMyParameter($id,$amount,$language,$pDesc);
        return '<html lang="es">
            <head>
            </head>
            <body>
            <form name="frm" action="'.$result['form_url'].'" method="POST" target="_blank">
                Ds_Merchant_SignatureVersion <input type="text" name="Ds_SignatureVersion" value="'.$result['ds_signatureversion'].'"/></br>
                Ds_Merchant_MerchantParameters <input type="text" name="Ds_MerchantParameters" value="'.$result['ds_merchantparameters'].'"/></br>
                Ds_Merchant_Signature <input type="text" name="Ds_Signature" value="'.$result['ds_signature'].'"/></br>
                <input type="submit" value="Enviar" >
            </form>
            </body>
            </html>';
    }

    public function getFormDataJson($id="5555",$amount="6000",$language="002", $pDesc=""){
        $result=RedsysWDG::setMyParameter($id,$amount,$language,$pDesc);
        return json_encode($result);
    }

    public function checkData($version,$datos,$signatureRecibida){
        $miObj = new RedsysAPI();
        $firma = $miObj->createMerchantSignatureNotif($miObj->params['KC'],$datos);
        if ($firma === $signatureRecibida){
            return true;
        }else {
            return false;
         }
    }

    public function decodeData($data){
        $miObj = new RedsysAPI();
        $decodec = $miObj->decodeMerchantParameters($data);
        return $decodec;
    }

    public function setMyParameter($id,$amount,$language,$pDesc){
        if(strlen($pDesc) > 125) $pDesc = substr($pDesc,0,122).'...';
        $miObj = new RedsysAPI();
        //Se Rellenan los campos
        $miObj->setParameter("DS_MERCHANT_AMOUNT",$amount);
        $miObj->setParameter("DS_MERCHANT_ORDER",strval($id));
        $miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$miObj->params['FUC']);
        $miObj->setParameter("DS_MERCHANT_CURRENCY",$miObj->params['CURRENCY']);
        $miObj->setParameter("DS_MERCHANT_PRODUCTDESCRIPTION",$pDesc);
        $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$miObj->params['TRANSACTIONTYPE']);
        $miObj->setParameter("DS_MERCHANT_TERMINAL",$miObj->params['TERMINAL']);
        $miObj->setParameter("DS_MERCHANT_MERCHANTURL",$miObj->params['URL']);
        $miObj->setParameter("DS_MERCHANT_URLOK",$miObj->params['URLOK']);
        $miObj->setParameter("DS_MERCHANT_URLKO",$miObj->params['URLKO']);
        $miObj->setParameter("DS_MERCHANT_PAYMETHODS",$miObj->params['PAYMETHODS']);
        $miObj->setParameter("DS_MERCHANT_CONSUMERLANGUAGE",$language);

        $version = $miObj->params['VERSION'];
        $kc = $miObj->params['KC'];//Clave recuperada de CANALES
        // Se generan los parámetros de la petición
        $params = $miObj->createMerchantParameters();
        $signature = $miObj->createMerchantSignature($kc);

        $result = Array(
            'form_url'=>$miObj->params["FORM_URL"],
            'ds_signatureversion'=>$version,
            'ds_signature'=>$signature,
            'ds_merchantparameters'=>$params
        );

        return $result;
    }

}

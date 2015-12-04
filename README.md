Yii2 lacaixa Module
===============
Yii2 lacaixa module to integrate the payment gateway (TPV Virtual) Redsys to be integrated into virtual web shops that have been developed under Yii2.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist kholmatov/yii2-lacaixa "*"
```

or add

```
"kholmatov/yii2-lacaixa": "*"
```

to the require section of your `composer.json` file.


Usage
-----
Setting configuration file ```kholmatov/yii2-lacaixa/config.php```

Once the extension is installed, simply use it in your code by  :

```php
<?= \kholmatov\lacaixa\RedsysWDG::getFormData($DS_MERCHANT_ORDER,$DS_MERCHANT_AMOUNT,$languageCode,$ProductDescription); ?>
```

Put this example  code in any controller script for testing success url in action (URLOK): 

```php
    
    ...
    
    public function actionOk(){
        $get = Yii::$app->request->get();
        if(isset($get) && isset($get['Ds_SignatureVersion']) && isset($get['Ds_MerchantParameters']) && isset($get['Ds_Signature'])):
            
            $rs = \kholmatov\lacaixa\RedsysWDG::checkData($get['Ds_SignatureVersion'],$get['Ds_MerchantParameters'],$get['Ds_Signature']);
            if($rs){
                $rsParam = \kholmatov\lacaixa\RedsysWDG::decodeData($get['Ds_MerchantParameters']);
                $myParam = json_decode($rsParam,true);
                print_r($myParam);
                  ....
               }
        endif;

        //return $this->redirect(array('/'));
    }
    
    ...
    
   ```
    
    
Put this example  code in any controller script for testing cancel or error  url in action (URLKO): 

```php
    
    ...
    
    public function actionKo(){
       $get = Yii::$app->request->get();
          if(isset($get) && isset($get['Ds_SignatureVersion']) && isset($get['Ds_MerchantParameters']) && isset($get['Ds_Signature'])):
            $rs = \kholmatov\lacaixa\RedsysWDG::checkData($get['Ds_SignatureVersion'],$get['Ds_MerchantParameters'],$get['Ds_Signature']);
            if($rs){
                       $rsParam = RedsysWDG::decodeData($get['Ds_MerchantParameters']);
                       $myParam = json_decode($rsParam,true);
                       print_r($myParam);
                      ... 
            }
          endif;
       
          //return $this->redirect(array('/'));
    }
    
    ...
    
    ```
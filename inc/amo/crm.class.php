<?php
class AmoCRM {
    public $subdomain='managerprintaporterru';
    private $user_id = "44a331fb-2363-4ae2-8f61-00d08ce67734";
    private $user_secret = 'YsnRFDlZsWk1Azjb0XZkgRVEvvN9fOBhvXLIyUhVDmqthPhNTSoGu5ZOrEVTMdR3';
    private $user_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6Ijk4NmNmNzNiZDA3NjgzN2RjODBmYWZkNTA0YjVmMzE5YjRjNDU1NmNlMTA0M2Q5NDE4NjYwNzFiYzYwM2Y1YjFiY2M3YTM1ZDFiNWNhMDI5In0.eyJhdWQiOiI0NGEzMzFmYi0yMzYzLTRhZTItOGY2MS0wMGQwOGNlNjc3MzQiLCJqdGkiOiI5ODZjZjczYmQwNzY4MzdkYzgwZmFmZDUwNGI1ZjMxOWI0YzQ1NTZjZTEwNDNkOTQxODY2MDcxYmM2MDNmNWIxYmNjN2EzNWQxYjVjYTAyOSIsImlhdCI6MTczMDc0MjM1NCwibmJmIjoxNzMwNzQyMzU0LCJleHAiOjE3NjcxMzkyMDAsInN1YiI6IjExNDE3NDA2IiwiZ3JhbnRfdHlwZSI6IiIsImFjY291bnRfaWQiOjMxOTA2NjU0LCJiYXNlX2RvbWFpbiI6ImFtb2NybS5ydSIsInZlcnNpb24iOjIsInNjb3BlcyI6WyJwdXNoX25vdGlmaWNhdGlvbnMiLCJjcm0iLCJub3RpZmljYXRpb25zIl0sImhhc2hfdXVpZCI6Ijg2MzI3NTY4LTQzZGEtNGYxYi1iZjE0LTlmMTMyM2E4YjliMCIsImFwaV9kb21haW4iOiJhcGktYi5hbW9jcm0ucnUifQ.N9h5pelGKbMo2jDJhRT5PCeHs3Y6ZX7lZ-KlXLKQOeZNqCIKkGp4sM1kO0wFRef31aJDNlocUav2eAQbUTc9ke16JqGq3HFDSuMaEL1CdK5UR48YCl-7rHqaW8qupTnA9ZY4a3lMf0ipcI7SSdM4pfB8cNLIx59WJE-DmNwtPdZEgFAhjPMqncXkkaxr2q832zjdMnFGIzf16GHVHDBeF-YeJy8PNl9BHSkWOnYrRj52D8YSKvuhgebVqf-vWRC0yhZu43aXZjR3CH_-CkDldqIOOqtOtKCtpmqcekETAPiLVkHA9Zpj12K61CyZWPQGCGsbbCXZoiaOb0fKn2OuTA';
    
    function __construct(){
      $this->get_account();
    }
    
    function get_account(){
      $link='https://'.$this->subdomain.'.amocrm.ru/api/v4/account';

      $access_token = $this->user_token;
      $headers = [
          'Authorization: Bearer ' . $access_token
      ];
      $curl = curl_init();
      curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
      curl_setopt($curl,CURLOPT_URL, $link);
      curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl,CURLOPT_HEADER, false);
      curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
      curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
      $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
      $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);
      
      $code = (int)$code;
      $errors = [
          400 => 'Bad request',
          401 => 'Unauthorized',
          403 => 'Forbidden',
          404 => 'Not found',
          500 => 'Internal server error',
          502 => 'Bad gateway',
          503 => 'Service unavailable',
      ];
      
      try{
          if ($code < 200 || $code > 204) {
              throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
          }
      }
      catch(\Exception $e){
          die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
      }
      
      $out = json_decode($out, 1);
      
      return $out;
    }
    
    function get_deals($params = array()){
      $link='https://'.$this->subdomain.'.amocrm.ru/api/v4/leads';
      
      if (!empty($params['id'])){
        $link.='/'.$params['id'];
      }
      
      $access_token = $this->user_token;
      $headers = [
          'Authorization: Bearer ' . $access_token
      ];
      $curl = curl_init();
      curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
      curl_setopt($curl,CURLOPT_URL, $link);
      curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl,CURLOPT_HEADER, false);
      curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
      curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
      $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
      $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);
      
      $code = (int)$code;
      $errors = [
          400 => 'Bad request',
          401 => 'Unauthorized',
          403 => 'Forbidden',
          404 => 'Not found',
          500 => 'Internal server error',
          502 => 'Bad gateway',
          503 => 'Service unavailable',
      ];
      
      try{
          if ($code < 200 || $code > 204) {
              throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
          }
      }
      catch(\Exception $e){
          die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
      }
      
      $out = json_decode($out, 1);
      
      return $out;
    }
    
    function get_contacts($params = array()){
      $link='https://'.$this->subdomain.'.amocrm.ru/api/v4/contacts';
      
      if (!empty($params['id'])){
        $link.='/'.$params['id'];
      }

      $access_token = $this->user_token;
      $headers = [
          'Authorization: Bearer ' . $access_token
      ];
      $curl = curl_init();
      curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
      curl_setopt($curl,CURLOPT_URL, $link);
      curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl,CURLOPT_HEADER, false);
      curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
      curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
      $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
      $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);
      
      $code = (int)$code;
      $errors = [
          400 => 'Bad request',
          401 => 'Unauthorized',
          403 => 'Forbidden',
          404 => 'Not found',
          500 => 'Internal server error',
          502 => 'Bad gateway',
          503 => 'Service unavailable',
      ];
      
      try{
          if ($code < 200 || $code > 204) {
              throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
          }
      }
      catch(\Exception $e){
          die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
      }
      
      $out = json_decode($out, 1);
      
      return $out;
    }
    
    function get_companies($params = array()){
      $link='https://'.$this->subdomain.'.amocrm.ru/api/v4/companies';
      
      if (!empty($params['id'])){
        $link.='/'.$params['id'];
      }

      $access_token = $this->user_token;
      $headers = [
          'Authorization: Bearer ' . $access_token
      ];
      $curl = curl_init();
      curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
      curl_setopt($curl,CURLOPT_URL, $link);
      curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl,CURLOPT_HEADER, false);
      curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
      curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
      $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
      $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);
      
      $code = (int)$code;
      $errors = [
          400 => 'Bad request',
          401 => 'Unauthorized',
          403 => 'Forbidden',
          404 => 'Not found',
          500 => 'Internal server error',
          502 => 'Bad gateway',
          503 => 'Service unavailable',
      ];
      
      try{
          if ($code < 200 || $code > 204) {
              throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
          }
      }
      catch(\Exception $e){
          die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
      }
      
      $out = json_decode($out, 1);
      
      return $out;
    }
    
    function add_deal($params = array()){
      $params = array(
         array(
            "name"=> $params['name'],
            "price"=> $params['price'],
            "custom_fields_values"=>array(
                array(
                   "field_id"=>1124729,
                   "values"=>array(
                      array(
                         "value"=>$params['delivery']
                      )
                   )
                )
            ),
            "_embedded"=>array(
               "contacts"=>array(
                  array(
                     "first_name"=>$params['user_name'],
                     "responsible_user_id"=>11417406,
                     "updated_by"=>0,
                     "custom_fields_values"=>array(
                        array(
                           "field_id"=>1054041,
                           "values"=>array(
                              array(
                                 "enum_id"=>1233665,
                                 "value"=>$params['mail']
                              )
                           )
                        ),
                        array(
                           "field_id"=>1054039,
                           "values"=>array(
                              array(
                                 "enum_id"=>1233651,
                                 "value"=>$params['phone']
                              )
                           )
                        )
                     )
                  )
               )
            ),
            "created_at"=>time(),
            "responsible_user_id"=>11417406,
            "status_id"=>69222258,
            "request_id"=>11417406
         )
      );
      
      $link='https://'.$this->subdomain.'.amocrm.ru/api/v4/leads/complex';

      $access_token = $this->user_token;
      $headers = [
          'Authorization: Bearer ' . $access_token
      ];
      $curl = curl_init();
      curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
      curl_setopt($curl,CURLOPT_URL, $link);
      curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($params));
      curl_setopt($curl,CURLOPT_HEADER, false);
      curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
      curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
      $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
      $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);
      
      //$out = json_decode($out, 1);
      //return $out;
      
      $code = (int)$code;
      $errors = [
          400 => 'Bad request',
          401 => 'Unauthorized',
          403 => 'Forbidden',
          404 => 'Not found',
          500 => 'Internal server error',
          502 => 'Bad gateway',
          503 => 'Service unavailable',
      ];
      
      try{
          if ($code < 200 || $code > 204) {
              throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
          }
      }
      catch(\Exception $e){
          die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
      }
      
      $log = array(
        'date' => date('Y-m-d H:i:s'),
        'params' => $params,
        'results' => $out
      );
      //$this->save_log($log);
      
      $out = json_decode($out, 1);
      
      return $out;
    }
    
    function add_deal_note($params = array()){
      $params = array(
         array(
            "entity_id"=>$params['deal_id'],
            "note_type"=>"common",
            "created_by"=>11417406,
            "params"=>array(
                 "text"=>$params['text']  
            )
         )
      );
      
      $link='https://'.$this->subdomain.'.amocrm.ru/api/v4/leads/notes';

      $access_token = $this->user_token;
      $headers = [
          'Authorization: Bearer ' . $access_token
      ];
      $curl = curl_init();
      curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
      curl_setopt($curl,CURLOPT_URL, $link);
      curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($params));
      curl_setopt($curl,CURLOPT_HEADER, false);
      curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
      curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
      $out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
      $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      curl_close($curl);
      
      //$out = json_decode($out, 1);
      //return $out;
      
      $code = (int)$code;
      $errors = [
          400 => 'Bad request',
          401 => 'Unauthorized',
          403 => 'Forbidden',
          404 => 'Not found',
          500 => 'Internal server error',
          502 => 'Bad gateway',
          503 => 'Service unavailable',
      ];
      
      try{
          if ($code < 200 || $code > 204) {
              throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
          }
      }
      catch(\Exception $e){
          die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
      }
      
      $log = array(
        'date' => date('Y-m-d H:i:s'),
        'params' => $params,
        'results' => $out
      );
      //$this->save_log($log);
      
      $out = json_decode($out, 1);
      
      return $out;
    }
    
    function save_log($array = array()){
      $row = json_encode($array);
      
      $filename = __DIR__ . '/logs.txt';
      
      $text = file_get_contents($filename);
      file_put_contents($filename, $row . PHP_EOL . $text);
    }
}

$CRM = new AmoCRM;
?>
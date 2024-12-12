 <?php
  if (!empty($_REQUEST['key']) && $_REQUEST['key']==md5("secretkey")){
    require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
    
    require_once($_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/form-sender/send-mail.php');
    
    $form_id = $_REQUEST['form_id'];
    
    $save = get_field('save_letters', $form_id);
    $subject = get_field('letter_subject', $form_id);
    $text = nl2br(get_field('letter_text', $form_id));
    $success_url = get_field('success_url', $form_id);
    
    foreach ($_REQUEST as $key=>$value){
      $value = is_array($value) ? implode('; ', $value) : $value;
      $subject = str_replace('['.$key.']', $value, $subject);
      $text = str_replace('['.$key.']', $value, $text);
    }
    
    // Отправка письма
    $result = sendMail(get_field('form_mail', $form_id), $subject, $text);
    
    if (!empty(get_field('form_mail2', $form_id))){
      $mail2 = get_field('form_mail2', $form_id);
      $text2 = get_field('letter_text2', $form_id);
      $subject2 = get_field('letter_subject2', $form_id);
      foreach ($_REQUEST as $key=>$value){
        $mail2 = str_replace('['.$key.']', $value, $mail2);
        $text2 = str_replace('['.$key.']', $value, $text2);
        $subject2 = str_replace('['.$key.']', $value, $subject2);
      }
      
      $result2 = sendMail($mail2, $subject2, $text2);
    }
    
    // Сохранение писем в БД
    if (!empty($save)){
      $letter_id = wp_insert_post( array(
        'post_type'    => 'formarchive',
        'post_title'   => date('Y-m-d H:i:s')." - ".$subject,
        'post_status'  => 'private',
        'post_content' => $text
      ) );
      
      $field = 1;
      foreach ($_REQUEST as $key=>$val){
        add_post_meta($letter_id, 'formfield_'.$field, $val);
        $field++;
      }
    }
    
    // Telegram
    if (!empty(get_option('formsender_tg_status'))){
      $token = get_option('formsender_tg_token');
      $chat_id = get_option('formsender_tg_chat_id');
      
      $ch = curl_init();
      curl_setopt_array(
        $ch,
        array(
          CURLOPT_URL => 'https://api.telegram.org/bot' .$token. '/sendMessage',
          CURLOPT_POST => TRUE,
          CURLOPT_RETURNTRANSFER => TRUE,
          CURLOPT_TIMEOUT => 10,
          CURLOPT_POSTFIELDS => array(
            'chat_id' => $chat_id,
            'text' => strip_tags($text),
          ),
        )
      );
      $tg = curl_exec($ch);
    }
    
    // AMOCRM
    if (!empty(get_option('formsender_amo_status'))){
      require_once(__DIR__.'/inc/amo/crm.class.php');
      
      $params = array(
        'user_name' => $_REQUEST['user-name'],
        'name' => $subject,
        'price' => 0,
        'mail' => $_REQUEST['user-mail'],
        'phone' => '',
        'tags' => '',
        'delivery' => '',
      );
      $deal = $CRM->add_deal($params);
      
      if (!empty($deal[0]['id'])){
        $params = array(
          'deal_id' => $deal[0]['id'],
          'text' => nl2br(strip_tags($text)),
        );
        $deal_note = $CRM->add_deal_note($params);
      }
    }
    
    if ($result=='true'){
      $output = array(
        'result' => 'true',
        'message' => '<p>'.nl2br(get_field('success_text', $form_id)).'</p>',
        'redirect' => $success_url,
      );
    }
    else{
      $output = array(
        'result' => 'false',
        'message' => '<p>Извините. Произошла ошибка. '.$result.'</p>',
        'redirect' => '',
      );
    }
  }
  else{
    $output = array(
      'result' => 'false',
      'message' => '<p>Ошибка! Неверные параметры.</p>',
      'redirect' => '',
    );
  }
  
  echo json_encode($output, JSON_UNESCAPED_UNICODE );
?>
jQuery(document).ready(function(){
  smtp_settings();
  
  jQuery(".formsender-method").change(function(){
    smtp_settings();
  });
  
  // Генерируем и записываем в поле шорткод формы
  post_id = jQuery("#post_ID").val()
  jQuery("#acf-form_shortcode").val('[form id="'+post_id+'"]');
  
  
  // Выводим вкладки (табы) настроек отправки
  jQuery(".formsend-settings").after('<br><br><div class="form-tabs"><div class="tab-1" data-group="1">Отправка писем</div><div class="tab-2" data-group="2">Интеграция с Telegram</div><div class="tab-3" data-group="3">Интеграция с AMOCRM</div></div>');
  
  
  
  // Выводим вкладки (табы) настроек формы
  jQuery(".postbox-header").hide().before('<div class="form-tabs"><div class="tab-1" data-group="1">Форма</div><div class="tab-2" data-group="2">Письма</div><div class="tab-3" data-group="3">Письмо 2</div><div class="tab-4" data-group="4">Настройки</div></div>');
  
  // Нажатие вкладки, показать поля только выбранной группы
  jQuery(document).on("click", ".form-tabs div", function(){
    group = jQuery(this).data("group");
    showGroupFields(group);
  });
  
  function showGroupFields(group){
    jQuery(".form-tabs div").removeClass("active");
    jQuery(".field").hide();
    jQuery(".form-tabs .tab-"+group).addClass("active");
    jQuery(".group-"+group).show();
  }
  
  showGroupFields(1);
  
  
  // Выводим ссылку для добавления полей в форму
  jQuery("#acf-form_content").before('<p><a href="javascript:;" onClick="jQuery(\'.form-modal\').show()">Добавить поле</a></p>');

  modal_html = ''+
  '  <div class="form-modal">'+
  '    <div>'+
  '      <h2>Добавить поле</h2>'+
  '      <form>'+
  '        <table class="wp-list-table widefat ">'+
  '          <tr>'+
  '            <td>Тип поля</td>'+
  '            <td>'+
  '              <select id="field-type">'+
  '                <option value="text">Текстовое поле</option>'+
  '                <option value="email">Поле для e-mail</option>'+
  '                <option value="tel">Поле для телефона</option>'+
  '                <option value="textarea">Текстовая область</option>'+
  '                <option value="select">Выпадающий список</option>'+
  '                <option value="submit">Кнопка отправки</option>'+
  '              </select>'+
  '            </td>'+
  '          </tr>'+
  '          <tr>'+
  '            <td>Имя поля</td>'+
  '            <td><input type="text" id="field-name"></td>'+
  '          </tr>'+
  '          <tr>'+
  '            <td>Заполнитель поля</td>'+
  '            <td><input type="text" id="field-value"></td>'+
  '          </tr>'+
  '          <tr>'+
  '            <td>ID поля</td>'+
  '            <td><input type="text" id="field-id"></td>'+
  '          </tr>'+
  '          <tr>'+
  '            <td>Класс поля</td>'+
  '            <td><input type="text" id="field-class"></td>'+
  '          </tr>'+
  '          <tr>'+
  '            <td>Обязательное поле</td>'+
  '            <td><input type="checkbox" id="field-required"></td>'+
  '          </tr>'+
  '        </table>'+
  '        <input type="button" value="Закрыть" class="button button-default button-large closebtn">'+
  '        <input type="button" value="Добавить" class="button button-primary button-large" onClick="addFormField()">'+
  '      </form>'+
  '    </div>'+
  '  </div>';
  jQuery("#wpwrap").before(modal_html);
  
  // Открытие/закрытие модального окна
  jQuery(".callback-btn").click(function(){
    event.preventDefault();
    jQuery(".modal-callback").show();
  });
  jQuery(".form-modal .closebtn").click(function(){
    jQuery(".form-modal").hide();
  });
  jQuery(document).mouseup(function(e){
    var div = jQuery(".form-modal > div");
    if (!div.is(e.target) && div.has(e.target).length === 0){ 
      jQuery(".form-modal").hide();
    }
  });
  
  // Предпросмотр формы
  previewForm();
  jQuery("#acf-form_content").blur(function(){
    previewForm();
  });
});

// Показать/скрыть поля настройки SMTP-соединения
function smtp_settings(){
  method = jQuery(".formsender-method").val();
  
  if (method == 'smtp'){
    jQuery(".settings-smtp").show();
  }
  
  else{
    jQuery(".settings-smtp").hide();
  }
}

// Добавление поля в форму
function addFormField(){
  if (jQuery("#field-name").val().length<1){
    alert("Не заполнены обязательные поля");
    return;
  }
  
  let required = '';
  if (jQuery("#field-required").prop('checked')==true) required = 'required';
  
  switch (jQuery("#field-type").val()){
    case 'textarea':
      field = '<textarea name="'+jQuery("#field-name").val()+'" '+required+' placeholder="'+jQuery("#field-value").val()+'" id="'+jQuery("#field-id").val()+'" class="'+jQuery("#field-class").val()+'"></textarea>';
      break;
    case 'select':
      field = '<select name="'+jQuery("#field-name").val()+'" '+required+' id="'+jQuery("#field-id").val()+'" class="'+jQuery("#field-class").val()+'"></select>';
      break;
    case 'submit':
      field = '<input type="submit" name="'+jQuery("#field-name").val()+'" value="'+jQuery("#field-value").val()+'" id="'+jQuery("#field-id").val()+'" class="'+jQuery("#field-class").val()+'">';
      break;
    default:
      field = '<input type="'+jQuery("#field-type").val()+'" name="'+jQuery("#field-name").val()+'" '+required+' placeholder="'+jQuery("#field-value").val()+'" id="'+jQuery("#field-id").val()+'" class="'+jQuery("#field-class").val()+'">';
      break;
  }
  
  var html = jQuery('#acf-form_content').val();
  var position = document.getElementById('acf-form_content').selectionStart;
  var result =  html.slice(0, position) + field + html.slice(position);
  jQuery('#acf-form_content').val(result);
  
  jQuery(".form-modal").hide();
  
  previewForm();
}

// Предпросмотр формы
function previewForm(){
  let form_content = jQuery("#acf-form_content").val();
  form_content = form_content.replace(/required/gi, '');
  jQuery(".preview-block .acf-input").html(form_content);
}
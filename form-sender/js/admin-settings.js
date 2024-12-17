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
  jQuery("#acf-form_shortcode").after('<br><br><div class="form-tabs"><div class="tab-1" data-group="1">Форма</div><div class="tab-2" data-group="2">Письма</div><div class="tab-3" data-group="3">Письмо 2</div><div class="tab-4" data-group="4">Настройки</div></div>');
  
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
  '                <option value="-">--Выберите тип поля--</option>'+
  '                <option value="text">Текстовое поле</option>'+
  '                <option value="tel">Поле для телефона</option>'+
  '                <option value="email">Поле для e-mail</option>'+
  '                <option value="textarea">Текстовая область</option>'+
  '                <option value="select">Выпадающий список</option>'+
  '                <option value="radio">Радио кнопки</option>'+
  '                <option value="checkbox">Группа чекбоксов</option>'+
  '                <option value="file">Загрузка файла</option>'+
  '                <option value="hidden">Скрытое поле</option>'+
  '                <option value="accept">Согласие на обработку</option>'+
  '                <option value="submit">Кнопка отправки</option>'+
  '              </select>'+
  '            </td>'+
  '          </tr>'+
  '          <tr class="flied-property" data-for="text,tel,email,textarea,select,radio,checkbox,file,hidden,submit" style="display:none;">'+
  '            <td>Имя поля</td>'+
  '            <td><input type="text" id="field-name"></td>'+
  '          </tr>'+
  '          <tr class="flied-property" data-for="text,tel,email,textarea,select,radio,checkbox,file,hidden,accept" style="display:none;">'+
  '            <td>Подсказка для поля</td>'+
  '            <td><input type="text" id="field-alt"></td>'+
  '          </tr>'+
  '          <tr class="flied-property" data-for="text,tel,email,textarea,select,submit" style="display:none;">'+
  '            <td>Заполнитель поля</td>'+
  '            <td><input type="text" id="field-value"></td>'+
  '          </tr>'+
  '          <tr class="flied-property" data-for="select,radio,checkbox" style="display:none;">'+
  '            <td>Варианты ответа</td>'+
  '            <td><textarea id="field-options" rows="5" placeholder="Введите возможные варианты по одному на строку"></textarea></td>'+
  '          </tr>'+
  '          <tr class="flied-property" data-for="text,tel,email,textarea,select,radio,checkbox,file,hidden,submit" style="display:none;">'+
  '            <td>ID поля</td>'+
  '            <td><input type="text" id="field-id"></td>'+
  '          </tr>'+
  '          <tr class="flied-property" data-for="text,tel,email,textarea,select,radio,checkbox,file,hidden,accept,submit" style="display:none;">'+
  '            <td>Класс поля</td>'+
  '            <td><input type="text" id="field-class"></td>'+
  '          </tr>'+
  '          <tr class="flied-property" data-for="text,tel,email,textarea,select,radio,accept,checkbox" style="display:none;">'+
  '            <td>Обязательное поле</td>'+
  '            <td><input type="checkbox" id="field-required"></td>'+
  '          </tr>'+
  '          <tr class="flied-property" data-for="file" style="display:none;">'+
  '            <td>Разрешенные типы файлов</td>'+
  '            <td><textarea id="field-types" rows="2" placeholder="Перечислите расширения файлов через запятую"></textarea></td>'+
  '          </tr>'+
  '          <tr class="flied-property" data-for="file" style="display:none;">'+
  '            <td>Выбор нескольких файтов</td>'+
  '            <td><input type="checkbox" id="field-multiple"></td>'+
  '          </tr>'+
  '        </table>'+
  '        <input type="button" value="Закрыть" class="button button-default button-large closebtn">'+
  '        <input type="button" value="Добавить" class="button button-primary button-large" onClick="addFormField()">'+
  '      </form>'+
  '    </div>'+
  '  </div>';
  jQuery("#wpwrap").before(modal_html);
  
  // Показать нужный пабор свойств в модальном окне в соответствии с выбранным типом поля
  jQuery(document).on("change", "#field-type", function(e) {
    type = jQuery("#field-type").val();
    jQuery(".form-modal .flied-property").hide();
    jQuery(".form-modal .flied-property").each(function(){
      prop_for = jQuery(this).data("for");
      if (prop_for.indexOf(type)>-1){
        jQuery(this).show();
      }
    });
  });
  
  // Открытие/закрытие модального окна
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
  //if (jQuery("#field-name").val().length<1){
  //  alert("Не заполнены обязательные поля");
  //  return;
  //}
  
  let required = '';
  if (jQuery("#field-required").prop('checked')==true) required = 'required';
   
  switch (jQuery("#field-type").val()){
    case 'textarea':
      field = '<label>\n';
      if (jQuery("#field-alt").val().length>0){
        field += '  <p>'+jQuery("#field-alt").val()+'</p>\n';
      }
      field += '  <textarea name="'+jQuery("#field-name").val()+'" '+required+' placeholder="'+jQuery("#field-value").val()+'" id="'+jQuery("#field-id").val()+'" class="'+jQuery("#field-class").val()+'"></textarea>\n';
      field += '</label>\n';
      break;
      
    case 'select':
      field = '<label>\n';
      if (jQuery("#field-alt").val().length>0){
        field += '  <p>'+jQuery("#field-alt").val()+'</p>\n';
      }
      field +='  <select name="'+jQuery("#field-name").val()+'" '+required+' id="'+jQuery("#field-id").val()+'" class="'+jQuery("#field-class").val()+'">\n';
      if (jQuery("#field-value").val().length>0){
        field += '    <option value="">'+jQuery("#field-value").val()+'</option>\n';
      }
      options = jQuery("#field-options").val().split("\n");
      for (o in options){
        field += '    <option value="'+options[o]+'">'+options[o]+'</option>\n';
      }
      field += '  </select>\n';
      field += '</label>\n';
      break;
      
    case 'radio':
      field = '<div>\n';
      if (jQuery("#field-alt").val().length>0){
        field += '  <p>'+jQuery("#field-alt").val()+'</p>\n';
      }
      options = jQuery("#field-options").val().split("\n");
      for (o in options){
        field += '  <label><input type="radio" name="'+jQuery("#field-name").val()+'" value="'+options[o]+'" '+required+' placeholder="'+jQuery("#field-value").val()+'" id="'+jQuery("#field-id").val()+'" class="'+jQuery("#field-class").val()+'"> '+options[o]+'</label>\n';
      }
      field += '</div>\n';
      break;
      
    case 'checkbox':
      field = '<div>\n';
      if (jQuery("#field-alt").val().length>0){
        field += '  <p>'+jQuery("#field-alt").val()+'</p>\n';
      }
      options = jQuery("#field-options").val().split("\n");
      for (o in options){
        field += '  <label><input type="checkbox" name="'+jQuery("#field-name").val()+'[]" value="'+options[o]+'" class="'+jQuery("#field-class").val()+'"> '+options[o]+'</label>\n';
      }
      field += '</div>\n';
      break;
      
    case 'accept':
      field = '<label>\n';
      field += '  <input type="checkbox" name="accept" value="1" '+required+' class="'+jQuery("#field-class").val()+'"> '+jQuery("#field-alt").val()+'\n';
      field += '</label>\n';
      break;
      
    case 'file':
      field = '<label>\n';
      field += '  <input type="file" name="'+jQuery("#field-name").val()+'[]" class="'+jQuery("#field-class").val()+'"';
      if (jQuery("#field-types").val().length>0){
        field += ' accept="'+jQuery("#field-types").val()+'"';
      }
      if (jQuery("#field-multiple").prop('checked')==true){
        field += ' multiple="true"';
      }
      field += '>\n';
      field += '</label>\n';
      break;
      
    case 'submit':
      field = '<input type="submit" name="'+jQuery("#field-name").val()+'" value="'+jQuery("#field-value").val()+'" id="'+jQuery("#field-id").val()+'" class="'+jQuery("#field-class").val()+'">\n';
      break;
      
    default:
      field = '<label>\n';
      if (jQuery("#field-alt").val().length>0){
        field += '  <p>'+jQuery("#field-alt").val()+'</p>\n';
      }
      field += '  <input type="'+jQuery("#field-type").val()+'" name="'+jQuery("#field-name").val()+'" '+required+' placeholder="'+jQuery("#field-value").val()+'" id="'+jQuery("#field-id").val()+'" class="'+jQuery("#field-class").val()+'">\n';
      field += '</label>\n';
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
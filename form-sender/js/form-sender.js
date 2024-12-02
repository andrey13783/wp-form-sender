$(document).ready(function(){
	// Оправка формы
	$(".submit").click(function(){
		event.preventDefault();
		form = $(this).closest("form");
		submitForm(form);
	});
});

error_text = "";
// Валидация формы
function validateForm(form){
	result = true;
	form.find("[required]").removeClass("error-input");
	form.find("[required]").each(function(){
		if ($(this).val().length<3){
			$(this).addClass("error-input");
			result = false;
			//console.log($(this).attr("name"));
			error_text = "<p>Заполнены не все обязательные поля.</p>";
		}
		if (($(this).hasClass("phone-number")) && ($(this).val().indexOf("+")<0)){
			result = false;
			error_text = "<p>Укажите корректный номер телефона с кодом страны.</p>";
		}
	});
	return result;
}

// Оправка формы
function submitForm(form){
	$(form).find(".form-result").html("<p>Подождите..</p>");
	validated = validateForm(form);
	if (validated==true){
		form_data = form.serialize();
		$.ajax({
			type: "POST",
			url: '/wp-content/plugins/form-sender/form-send.php',
			data: form_data,
			success: function(data){
			console.log(data);
				obj = JSON.parse(data);
				if (obj.result=="true"){
					$(form).find("input, select").prop("disabled","true")
				}
				$(form).find(".form-result").html(obj.message);
			},
			error:	function(xhr, str){
				$(form).find(".form-result").html("<p>Возникла ошибка: " + xhr.responseCode+"</p>");
			}
		});
	}
	else{
		$(form).find(".form-result").html(error_text);
	}
}
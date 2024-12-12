$(document).ready(function(){
	// Оправка формы
	$(".contact-form input[type='submit']").click(function(){
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
		type = $(this).attr("type");
		if ((type=='checkbox' || type=='radio') && $(this).prop("checked")!=true){
			$(this).addClass("error-input");
			result = false;
			console.log($(this).attr("name")+" - "+$(this).prop("checked"));
			error_text = "<p>Есть ошибки при заполнении формы.</p>";
		}
		if ((type=='text' || type=='tel' || type=='email') && $(this).val().length<3){
			$(this).addClass("error-input");
			result = false;
			console.log($(this).attr("name")+" - "+$(this).val());
			error_text = "<p>Заполнены не все обязательные поля.</p>";
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
					$(form).find("input, textarea, select").prop("disabled","true");
				}
				$(form).find(".form-result").html(obj.message);
				if (obj.redirect.length>0){
					location.href = obj.redirect;
				}
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
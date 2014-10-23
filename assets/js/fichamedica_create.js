$(document).ready(function(){
		
	$("#diagnosticosE").select2({
		minimumInputLength: 2,
		multiple: true,
		ajax: {
			url: "/fichamedica/getDiagnosticosE",
			dataType: 'json',
			quietMillis: 100,
			data: function (term, page) {
				return {
					q: term
				};
			},
			results: function (data, page) {
				return { results: data };
			}
		}
	});

	$("#diagnosticosF").select2({
		minimumInputLength: 2,
		multiple: true,
		ajax: {
			url: "/fichamedica/getDiagnosticosF",
			dataType: 'json',
			quietMillis: 100,
			data: function (term, page) {
				return {
					q: term
				};
			},
			results: function (data, page) {
				return { results: data };
			}
		}
	});
		
	// datepicker
	
	var dx = moment(minDatex, "YYYY-MM-DD");
	
	$('#datetimepicker1').datetimepicker({
		language:'es', 
		pickTime: false,
		defaultDate: dx,
		maxDate: moment(),
		minDate: dx		
	});
	
	// * datepicker
	
	// validator

	
	$('#newP_form').validate({
		lang: 'es',
        rules: {
            td: {
				required: true,
				minlength: 1
            }
        },
		messages: { 
            td: "Seleccione al menos un tipo."
		},
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
		submitHandler: function(form) {
			//$(form).ajaxSubmit();
			//form.submit();
			//alert("caca");
			
			//extra validates
			
			//check DNI
			
			var suspend = false;
			
			$.ajax({
				url: "/pacientes/checkDNI",
				data: { stringQuery: $("#dni").val() },
				dataType: "json",
				async: false,
				type: "POST",
				success: function(data) {
					if(data.length) {
						alert("DNI ya existente.");
						suspend = true;
					}
				}
			});
			
			if (!suspend) {
				
					dataString = $("#newP_form").serialize();
			 
					$.ajax({
						type: "POST",
						url: "/pacientes/save",
						data: dataString,			 
						success: function(data){
							data ? (window.location.href = "/pacientes/") : "";
							// window.location.href = data.link;
							
						}
			 
					});
			 
					
			 
			}
			
		}
    });
	
	// * validator
	
	
	
});
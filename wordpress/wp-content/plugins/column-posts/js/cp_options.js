jQuery(function($) {
	$('#cp_include').keyup(function(event){
		if ($(this).val() == '') {
			$('input[type=radio][value="custom"]').attr('disabled','disabled');
			if ($('input[type=radio][value="custom"]').is(':checked')) $('input[type=radio][value="ID"]').attr('checked','checked');
		} else $('input[type=radio][value="custom"]').removeAttr('disabled');
	});
	
	if ($('input[id=cp_thumb]').is(':checked') == false) {
		$('.form-table:eq(2) tr').eq(5).hide();
		$('.form-table:eq(2) tr').eq(6).hide();
		$('.form-table:eq(3) tr').eq(5).hide();
	}
	if ($('input[id=cp_excerpt]').is(':checked') == false) {
		$('.form-table:eq(3) tr').eq(3).hide();
		$('.form-table:eq(3) tr').eq(4).hide();
	}

	$('input[id=cp_thumb]').click(function () {
		if ($('input[id=cp_thumb]').is(':checked') == true) {
			$('.form-table:eq(2) tr').eq(5).show();
			$('.form-table:eq(2) tr').eq(6).show();
			$('.form-table:eq(3) tr').eq(5).show();
		}
		else{
			$('.form-table:eq(2) tr').eq(5).hide();
			$('.form-table:eq(2) tr').eq(6).hide();
			$('.form-table:eq(3) tr').eq(5).hide();
		}
	});

	$('input[id=cp_excerpt]').click(function () {
		if ($('input[id=cp_excerpt]').is(':checked') == true) {
			$('.form-table:eq(3) tr').eq(3).show();
			$('.form-table:eq(3) tr').eq(4).show();
		}
		else{
			$('.form-table:eq(3) tr').eq(3).hide();
			$('.form-table:eq(3) tr').eq(4).hide();
		}
	});
});

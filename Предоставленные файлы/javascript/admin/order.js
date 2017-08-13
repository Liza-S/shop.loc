$(function(){
	$('.paid').on('change', paidForOrder);
})

function paidForOrder(){
	var id = $(this).data('orderid');
	var $self = $(this);

	$.ajax({
		type: 'POST',
		url: id + '/paid/',
		success: function() {
			$self.parents('div').eq(0).html('Да');
		}
	});
}
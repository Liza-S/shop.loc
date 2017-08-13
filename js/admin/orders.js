$(function(){
	$('.reject').on('click', reject);
	$('.done').on('click', done);
	$('.delete').on('click', deleteOrder);
	$('.archive').on('click', archiveOrder);
})

function reject(e) {
	e.preventDefault();
	var orderId = $(this).data('orderid');
	//alert(orderId);
	var rejectOrdConf = confirm("Вы действительно хотите отклонить этот заказ?");
	if (rejectOrdConf == true) {
	
		$.ajax({
			type: 'POST',
			url: '/admin/move_rejected',
			data: {'id':orderId},
			success: function (data){
				//console.log(e);
				$(e.target).parents('tr').remove();
			}
		});
	}
}

function done(e) {
	e.preventDefault();
	var orderId = $(this).data('orderid');
	//alert(orderId);
	var doneOrdConf = confirm("Вы действительно хотите выполнить этот заказ?");
	if (doneOrdConf == true) {
	
		$.ajax({
			type: 'POST',
			url: '/admin/move_done',
			data: {'id':orderId},
			success: function (data){
				//console.log(e);
				$(e.target).parents('tr').remove();
			}
		});
	}
}

function deleteOrder(e) {
	e.preventDefault();
	var orderId = $(this).data('orderid');
	//alert(orderId);
	var doneOrdConf = confirm("Вы действительно хотите удалить этот заказ?");
	if (doneOrdConf == true) {
	
		$.ajax({
			type: 'POST',
			url: '/admin/move_deleted',
			data: {'id':orderId},
			success: function (data){
				//console.log(e);
				$(e.target).parents('tr').remove();
			}
		});
	}
}

function archiveOrder(e) {
	e.preventDefault();
	var orderId = $(this).data('orderid');
	//alert(orderId);
	var doneOrdConf = confirm("Отправить этот заказ в архив?");
	if (doneOrdConf == true) {
	
		$.ajax({
			type: 'POST',
			url: '/admin/move_archived',
			data: {'id':orderId},
			success: function (data){
				//console.log(e);
				$(e.target).parents('tr').remove();
			}
		});
	}
}
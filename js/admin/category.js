$(function(){
	$('.deleteCategory').on('click', confirmCategoryDel);
	$('.changeCategoryName').on('click', createInputName);
	$('.hideCategory').on('click', hide_showCategory);
	$('.changeCategoryURL').on('click', createInputURL);
})

function hide_showCategory(e) {
	e.preventDefault();
	var categoryId = $(this).data('categoryid');
	//var category = $(this).parents('tr').find('.categoryName').text();
	var $that = $(this);
	if ($(this).data('action') == 'hide') {
		$.ajax({
					type: 'POST',
					url: '/admin/hide_category',
					data: {'id':categoryId},
					success: function (data){
						console.log(data);
						$that.data('action', 'show').text('Показать');
						$(e.target).text("Показать");
					}
			});	
	}
	else if ($(this).data('action') == 'show') {
		$.ajax({
					type: 'POST',
					url: '/admin/show_category',
					data: {'id':categoryId},
					success: function (data){
						console.log(data);
						$that.data('action', 'hide').text('Скрыть');
						$(e.target).text("Скрыть");
					}
			});	
	}
}

function confirmCategoryDel(e){
	e.preventDefault();
	var category = $(this).parents('tr').find('.categoryName').text();
	var delCatConf = confirm("Вы действительно хотите удалить " + category + "?");
	var categoryId = $(this).data('categoryid');
	//alert(categoryId);
	if (delCatConf == true) {
		
		$.ajax({
			type: 'POST',
			url: '/admin/delete_category',
			data: {'id':categoryId},
			success: function (data){
				//console.log(e);
				$(e.target).parents('tr').remove();
			}
		});

	}


}

function createInputName(e){
	e.preventDefault();

	var categoryId = $(this).data('categoryid');
	var $elCatName = $(this).parents('tr').find('.categoryName');
	var $input = $("<input type='text' name='name' value='" + $elCatName.text() + "' style='width: 100%;' autofocus>");
	var oldName = $elCatName.text();

	$elCatName.html($input);
	$input.select();

	$input.on('focusout', sendNewName(categoryId, oldName, $elCatName))

	function sendNewName(categoryId, oldName, $elCatName){


		return function(){
			//var url = categoryId + '/edit/';
			var newName = $(this).val();

			if(newName != oldName) {

				console.log(categoryId);

				$.ajax({
					type: 'POST',
					url: '/admin/change_category_name',
					data: {'newName': newName, 'id':categoryId},
					success: function(newName) {
						console.log(newName);
						$elCatName.text(newName);
					}
				});
			} else $elCatName.html(oldName);
			
		}

		
	}

}

function createInputURL(e){
	e.preventDefault();

	var categoryId = $(this).data('categoryid');
	var $elCatURL = $(this).parents('tr').find('.categoryURL');
	var $input = $("<input type='text' name='name' value='" + $elCatURL.text() + "' style='width: 100%;' autofocus>");
	var oldURL = $elCatURL.text();

	$elCatURL.html($input);
	$input.select();

	$input.on('focusout', sendNewURL(categoryId, oldURL, $elCatURL))

	function sendNewURL(categoryId, oldURL, $elCatURL){


		return function(){
			//var url = categoryId + '/edit/';
			var newURL = $(this).val();

			if(newURL != oldURL) {

				console.log(categoryId);

				$.ajax({
					type: 'POST',
					url: '/admin/change_category_url',
					data: {'newURL': newURL, 'id':categoryId},
					success: function(newName) {
						console.log(newURL);
						$elCatURL.text(newURL);
					}
				});
			} else $elCatURL.html(oldURL);
			
		}

		
	}

}
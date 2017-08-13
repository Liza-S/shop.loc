$(function(){
	$('.deleteCategory').on('click', confirmCategoryDel);
	$('.changeCategoryName').on('click', createInput);
})

function confirmCategoryDel(e){

	var category = $(this).parents('tr').find('.categoryName').text();

	return confirm("Вы действительно хотиет удалть " + category + "?");


}

function createInput(e){
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
			var url = categoryId + '/edit/';
			var newName = $(this).val();

			if(newName != oldName) {
				$.ajax({
					type: 'POST',
					url: url,
					data: {'newName': newName},
					success: function(newName) {
						$elCatName.html(newName);
					}
				});
			} else $elCatName.html(oldName);
			
		}

		
	}

}
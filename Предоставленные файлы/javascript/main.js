$(function(){
	$('#search_form').on('submit', function(e){
		e.preventDefault();

		var action = $(this).attr('action');
		var search_str = $(this).find("input[name='search_str']").val();
		location.href = action + '/' + search_str + '/';

		return false;
	})
})
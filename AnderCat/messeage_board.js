$(document).ready(() => {
  $('form').submit((e) => {
  	e.preventDefault();
  	const content = $(e.target).find('textarea[name=message]').val();
  	const parentId = $(e.target).find('input[name=parent_id]').val();
  	$.ajax({
    	type: "POST",
    	url: "handle_post.php",
    	data:{
    	  content:content,
    	  parent_id:parentId
    	},
    	success:(resp) => {
    		console.log('res:',resp);
    	}
  })
  $('.comments').on('click', '.delete_btn',(e) => {
    const id = $(e.target).attr('data-id')

    
    }).done((msg) => {
    	$(e.target)
    })
  })

})
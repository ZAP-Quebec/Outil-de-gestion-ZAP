function displayBooks(response){
	response = JSON.parse(response);
	$("#booksResponse").html('');
	var booksHtml = '<div id="books">';
	for(var i in response.books){
		booksHtml += '<h3><a href="#">'+response.books[i].title+'</a></h3><div>written by'+response.books[i].author+'</div>';
	}
	booksHtml += '</div>'
	$("#booksResponse").append(booksHtml);
	$("#booksResponse #books").accordion({"active":"none", "collapsible" : "true"});
}

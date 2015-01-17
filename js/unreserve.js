$(function(){
$('input[value=unreserve]').click(function(){
$.post('php/reserved.php', {unreserve:$(this).attr("name"),gid:document.getElementById('gameid').value}, function(data){
alert(data);
});
return false;
});
});
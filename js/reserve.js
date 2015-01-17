$(function(){
$('input[value=reserve]').click(function(){
$.post('php/reserved.php', {reserve:$(this).attr("name"),gid:document.getElementById('gameid').value}, function(data){
alert(data);
});
return false;
});
});
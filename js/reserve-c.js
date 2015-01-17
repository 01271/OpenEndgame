$(function(){$("input[value=reserve],input[value=unreserve]").click(function(){$.post("php/reserved.php",{reserve:$(this).attr("name")},function(a){alert(a)});return!1})});

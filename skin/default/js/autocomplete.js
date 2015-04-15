/**
 * tổng so ngươi cho theo nhom
 */
function Sumplay(id_game, id_groups){
	var id_group = id_groups.split(' ')
	var url = "http://localhost/ciao88/public/javajson.php?type=1&id_game="+id_game+"&id_group="+id_group+"&zone_name=p1&jsoncallback=?";
	$.getJSON(url, function(data){
			$("#id1").html(data.total);         
        });
}
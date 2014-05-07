<?php // получить все сеансы
/*$data = json_decode(
            file_get_contents(
                API_ROOT.'halls/cinema/get.php'
            ), true);*/
require_once FILES_ROOT.'includes/_rest/actions.php'; //var_dump(getHallsByCinema());
?>
<table class="user_table">
    <tr>
        <th colspan="3">
            Кинотеатр, зал, количество мест
        </th>
    </tr>
<?php
foreach(getHallsByCinema() as $cinema=>$hall_array):
?>
	<tr>
    	<td colspan="2"><?php echo $cinema;?></td>
    <tr>
<?php
	foreach($hall_array as $id=>$data):
?>
	<tr>
		<td><a href="hall/<?php echo $id;?>"><?php echo $data[0];?></a></td>
        <td><?php echo $data[1];?></td>
	</tr>
<?	endforeach;
endforeach;?>
</table>
<?
	//json_encode($json, JSON_FORCE_OBJECT)
	require_once('helper.php');
	$json = array();
	
	$value = 0.0;
	//validate range
	if(is_float_string(clear_txt(trim($_POST['id'])))){
		$value = clear_txt(trim($_POST['id']));
	} else {
		//make error
	}
	
	//get_json_offer($value);
	$json = get_json_pro($value);
	
	echo json_encode($json);
/*
{
	"profile":
		[
			{
				"profileName":"",
				"image":"",
				"address":"",
				"phone":"",
				"category":"",
				"openTime":"",
				"closeTime":"",
				"Daysoff1":"",
				"Daysoff2":"",
				"website":"",
				"ShopId":""
			}
		]
}
*/
?>
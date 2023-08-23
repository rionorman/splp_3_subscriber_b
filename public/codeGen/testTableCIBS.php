<?php
$v_table = $_POST["p_table"];
$v_db = $_POST["p_db"];
$v_controller = $_POST["p_controller"];

require_once("connectSQLI.php");
if($v_table != "" ){
	$mySqlTbl = "select * from ".$v_table." limit 1";

	//get fields name
	$resultSqlTbl = mysqli_query($con,$mySqlTbl);
	$fieldCountTbl = mysqli_field_count($con,$resultSqlTbl)+2;
	$i=0;
	while($fieldTbl = mysqli_fetch_field($resultSqlTbl)){
	   $fieldName[$i] = strtolower($fieldTbl->name);
	   $paramName[$i] = "p_".strtolower($fieldTbl->name);
	   $variableName[$i] = "v_".strtolower($fieldTbl->name);
	   $i++;
	}
	//---------------------------------------------------------------------------------------------------------
	//Controller
	$listController="class ".$v_controller." extends CI_Controller {\n".
	"public $"."data 	= 	array();\n".
	"public function __construct(){\n".
	"	parent::__construct();\n".
	"	$"."this->load->helper('url');\n".
	"	$"."this->load->helper('form');\n".
	"	$"."this->load->model('M".$v_controller."');\n".
	"}";

	$listController.="\n\n";

	$listController.="function index(){\n".
	"	$"."this->data['".strtolower($v_controller)."_list'] = $"."this->M".$v_controller."->getAll_".strtolower($v_controller)."();\n".
	"	$"."this->data['main_content']= '".strtolower($v_controller)."/view_".strtolower($v_controller)."';\n".
	"	$"."this->load->view('view_main',$"."this->data);\n".
	"}\n";

	$listController.="\n\n";

	$listController.="function ".strtolower($v_controller)."_form_insert(){\n".
	"	$"."this->data['main_content']= '".strtolower($v_controller)."/view_".strtolower($v_controller)."_form';\n".
	"	$"."this->data['row']=null;\n".
	"	$"."this->data['action']='insert';\n".
	"	$"."this->load->view('view_main',$"."this->data);\n".
	"}\n";

	$listController.="\n\n";

	$listController.="function ".strtolower($v_controller)."_form_update(){\n".
	"	$"."this->data['row'] = $"."this->M".$v_controller."->get_".strtolower($v_controller)."($"."this->uri->segment(3));\n".
	"	$"."this->data['main_content']= '".strtolower($v_controller)."/view_".strtolower($v_controller)."_form';\n".
	"	$"."this->data['action']='update';\n".
	"	$"."this->load->view('view_main',$"."this->data);\n".
	"}\n";

	$listController.="\n\n";

	$listController.="function ".strtolower($v_controller)."_form_delete(){\n".
	"	$"."this->data['row'] = $"."this->M".$v_controller."->get_".strtolower($v_controller)."($"."this->uri->segment(3));\n".
	"	$"."this->data['main_content']= '".strtolower($v_controller)."/view_".strtolower($v_controller)."_form';\n".
	"	$"."this->data['action']='delete';\n".
	"	$"."this->load->view('view_main',$"."this->data);\n".
	"}\n";

	$listController.="\n\n";

	$listController.="function ".strtolower($v_controller)."_manage(){\n".
	"	$"."action = $"."_POST['action'];\n".
	"	if($"."action=='insert'){\n".
	"		$"."this->M".$v_controller."->add_".strtolower($v_controller)."();\n".
	"	}\n".
	"	if($"."action=='update'){\n".
	"		$"."this->M".$v_controller."->update_".strtolower($v_controller)."();\n".
	"	}\n".
	"	if($"."action=='delete'){\n".
	"		$"."this->M".$v_controller."->delete_".strtolower($v_controller)."();\n".
	"	}\n".
	"	$"."this->data['main_content']= '".strtolower($v_controller)."_view';\n".
	"	redirect('".strtolower($v_controller)."');\n".
	"}\n}\n";

	//end Controler
	//-------------------------------------------------------------------------------------------

	//-------------------------------------------------------------------------------------------
	//Model

	$listModel="class M".$v_controller." extends CI_Model{\n".
	"function __construct(){\n".
	"	parent::__construct();\n".
	"	$"."v_date = date(\"Y-m-d H:i:s\");\n".
	"}\n";

	$listModel.="\n\n";

	$listModel.="function get_".strtolower($v_controller)."($"."id".strtolower($v_controller)."){\n".
	"	$"."data = array();\n".
	"	$"."options = array('id".strtolower($v_controller)."' => $"."id".strtolower($v_controller).");\n".
	"	$"."Q = $"."this->db->get_where('$v_table',$"."options,1);\n".
	"		if ($"."Q->num_rows() > 0){\n".
	"			$"."data = $"."Q->row_array();\n".
	"		}\n".
	"	$"."Q->free_result();\n".
	"	return $"."data;\n".
	"}\n";

	$listModel.="\n\n";

	$listModel.="function getAll_".strtolower($v_controller)."(){\n".
	"	$"."sql = 'select ";
	for($i=0;$i<count($fieldName);$i++){
		$listModel .= $fieldName[$i].",";
	}
	$listModel = substr($listModel, 0, -1)."\n";
	$listModel.=" from $v_table';\n".
	"	$"."data = array();\n".
	"	$"."Q = $"."this->db-> query($"."sql);\n".
	"	if ($"."Q->num_rows() > 0){\n".
	"		foreach ($"."Q->result_array() as $"."row){\n".
	"			$"."data[] = $"."row;\n".
	"		}\n".
	"	}\n".
	"	$"."Q-> free_result();\n".
	"	return $"."data;\n".
	"}\n";

	$listModel.="\n\n";

	$listModel.="function add_".strtolower($v_controller)."(){\n".
	"	$"."v_date = date('Y-m-d H:i:s');\n".
	"	$"."username = $"."this->session-> userdata('username');\n";
	$listModel.="	$"."sql = 'insert into $v_table(";
	for($i=0;$i<count($fieldName);$i++){
		$listModel .= $fieldName[$i].",";
	}
	$listModel = substr($listModel, 0, -1).") ";
	$listModel.=" values(";
	for($i=0;$i<count($fieldName);$i++){
		$listModel .= "?,";
	}
	$listModel = substr($listModel, 0, -1);
	$listModel.=")';\n";
	$listModel.="	$"."this->db->query($"."sql, array(";
	for($i=0;$i<count($fieldName);$i++){
		$listModel .= "$"."_POST['".$fieldName[$i]."'],";
	}
	$listModel = substr($listModel, 0, -1);
	$listModel.="));\n";
	$listModel.="}\n";

	$listModel.="\n\n";

	$listModel.="function update_".strtolower($v_controller)."(){\n".
	"	$"."v_date = date('Y-m-d H:i:s');\n".
	"	$"."username = $"."this->session-> userdata('username');\n";
	$listModel.="	$"."sql = 'update $v_table set ";
	for($i=0;$i<count($fieldName);$i++){
		$listModel .= $fieldName[$i]."=?,";
	}

	$listModel = substr($listModel, 0, -1);
	$listModel.=" where ".$fieldName[0]."=? ';\n";

	$listModel.="	$"."this->db->query($"."sql, array(";
	for($i=0;$i<count($fieldName);$i++){
		$listModel .= "$"."_POST['".$fieldName[$i]."'],";
	}
	$listModel = substr($listModel, 0, -1);
	$listModel.="));\n";
	$listModel.="}\n";

	$listModel.="\n\n";

	$listModel.="function delete_".strtolower($v_controller)."(){\n".
	"	$"."sql='delete from $v_table where id".strtolower($v_controller)."=?';\n".
	"	$"."this->db->query($"."sql, array($"."_POST['id".strtolower($v_controller)."']));\n".
	"}\n}\n";

	//end Model
	//-------------------------------------------------------------------------------------------


	//-------------------------------------------------------------------------------------------
	//View
	$listView .="<div class=\"panel panel-primary\">\n";
    $listView .="	<div class=\"panel-heading\"> Data ".$v_controller."</div>\n";
    $listView .="		<div class=\"panel-body\">\n";
    $listView .="			<div class=\"table-responsive\">\n";
	$listView .="<table class=\"table table-striped table-hover \">\n";
	$listView .="<thead>\n";
	$listView .="<tr>\n";
	for($i=0;$i<count($fieldName);$i++){
	$listView .="		&lt;th&gt;".$fieldName[$i]."&lt;/th&gt;\n";
	}
	$listView .="		&lt;th&gt;&lt;?php echo anchor('".strtolower($v_controller)."/".strtolower($v_controller)."_form_insert/', '<span class=\"glyphicon glyphicon-plus\" aria-hidden=\"true\"></span>')?&gt;&lt;/th&gt;\n";
	$listView .="</tr>\n";
	$listView .="</thead>\n";
	$listView .="<tbody>\n";
	$listView .="&lt?php\n".
	"	$"."i=1;\n".
	"	foreach($".strtolower($v_controller)."_list as $"."row): \n".
	"	?&gt;\n";

	$listView.="<tr>\n";
	for($i=0;$i<count($fieldName);$i++){
		$listView .="		&lt;td&gt;&lt;?=$"."row['".$fieldName[$i]."']?&gt;&lt;/td&gt;\n";
	}
	$listView.="<td align=\"center\">\n".
	"	&lt;?php echo anchor('".strtolower($v_controller)."/".strtolower($v_controller)."_form_update/'.$"."row['".$fieldName[0]."'], '<span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span>')?&gt;\n".
	"	&lt;?php echo anchor('".strtolower($v_controller)."/".strtolower($v_controller)."_form_delete/'.$"."row['".$fieldName[0]."'], '<span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span>')?&gt;\n".
	"</td>\n";
	$listView .="</tr>\n";
	$listView .="&lt;?php endforeach ?&gt;\n";
	$listView .="</tbody>\n";
	$listView .="</table>\n";
	$listView .="		</div>\n";
	$listView .="	</div>\n";
	$listView .="</div>\n";

	//end View
	//-------------------------------------------------------------------------------------------

	//-------------------------------------------------------------------------------------------

	//form
	$listForm="&lt;script&gt;\n".
	"function button_cancel(){\n".
	"	location.replace('&lt;?php echo base_url();?&gt;"."index.php/".strtolower($v_controller)."');\n".
	"}\n".
	"&lt;/script&gt;\n";
	$listForm .="<div class=\"panel panel-primary\">\n";
    $listForm .="	<div class=\"panel-heading\"> Data ".$v_controller."</div>\n";
    $listForm .="		<div class=\"panel-body\">\n";

	$listForm.="&lt;?=form_open('".strtolower($v_controller)."/".strtolower($v_controller)."_manage','class=\"form-horizontal\"')?&gt;\n";

	$listForm.="&lt;?php if($"."action==\"insert\"){?&gt;\n";

	for($i=0;$i<count($fieldName);$i++){
	$listForm .="<div class=\"form-group\">\n".
	"	<label class=\"col-sm-2 control-label\">$fieldName[$i]</label>\n".
	"	<div class=\"col-sm-10\">\n".
	"	   <input class=\"form-control\" type=\"text\" name=\"$fieldName[$i]\" value=\"\">\n".
	"       </div>\n".
	"</div>\n";
	}

	$listForm .="<div class=\"form-group\">\n".
	"	<div class=\"col-sm-offset-2 col-sm-10\">\n".
	"		&lt;?=form_hidden('action',$"."action)?&gt;\n".
	"		<button type=\"submit\" class=\"btn btn-primary\">Insert</button>\n".
	"		<button type=\"button\" class=\"btn btn-primary\" onclick=\"button_cancel()\">Cancel</button>\n".
	"	</div>\n".
	"</div>\n";

	$listForm.="&lt;?php }if($"."action==\"update\"){?&gt;\n";
	for($i=0;$i<count($fieldName);$i++){
	$listForm .="<div class=\"form-group\">\n".
	"	<label class=\"col-sm-2 control-label\">$fieldName[$i]</label>\n".
	"	<div class=\"col-sm-10\">\n".
	"	   <input class=\"form-control\" type=\"text\" name=\"$fieldName[$i]\" value=\"&lt;?php echo $"."row['".$fieldName[$i]."']?&gt;\"&gt;\n".
	"       </div>\n".
	"</div>\n";
	}

	$listForm .="<div class=\"form-group\">\n".
	"	<div class=\"col-sm-offset-2 col-sm-10\">\n".
	"		&lt;?=form_hidden('action',$"."action)?&gt;\n".
	"		&lt;?=form_hidden('".$fieldName[0]."',$"."row['$fieldName[0]'])?&gt;\n".
	"		<button type=\"submit\" class=\"btn btn-primary\">Update</button>\n".
	"		<button type=\"button\" class=\"btn btn-primary\" onclick=\"button_cancel()\">Cancel</button>\n".
	"	</div>\n".
	"</div>\n";

	$listForm.="&lt;?php }if($"."action==\"delete\"){?&gt;\n";
	for($i=0;$i<count($fieldName);$i++){
	$listForm .="<div class=\"form-group\">\n".
	"	<label class=\"col-sm-2 control-label\">$fieldName[$i]</label>\n".
	"	<div class=\"col-sm-10\">\n".
	"	   &lt;?php echo $"."row['".$fieldName[$i]."']?&gt;\n".
	"       </div>\n".
	"</div>\n";
	}

	$listForm .="<div class=\"form-group\">\n".
	"	<div class=\"col-sm-offset-2 col-sm-10\">\n".
	"		&lt;?=form_hidden('action',$"."action)?&gt;\n".
	"		&lt;?=form_hidden('".$fieldName[0]."',$"."row['$fieldName[0]'])?&gt;\n".
	"		<button type=\"submit\" class=\"btn btn-primary\">Delete</button>\n".
	"		<button type=\"button\" class=\"btn btn-primary\" onclick=\"button_cancel()\">Cancel</button>\n".
	"	</div>\n".
	"</div>\n";

	$listForm .="&lt;?php }?&gt;\n";

	$listForm .="</form>\n";
	$listForm .="	</div>\n";
	$listForm .="</div>\n";

	//end form
	//--------------------------------------------------------------------------------------------

}


?>
<form action="#" method="post">
Nama DB : <input type="text" name="p_db" value="<?=$v_db?>"><br>
Nama Table : <input type="text" name="p_table" value="<?=$v_table?>"><br>
Controller : <input type="text" name="p_controller" value="<?=$v_controller?>"><br>
		<input type="Submit" value="Submit">

</form>
<b>Controller</b> <br>
<textarea rows="20" cols="150">
&lt;?php
<?=$listController?>
?&gt;
</textarea>

<br><b>Model</b> <br>
<textarea rows="20" cols="150">
&lt;?php
<?=$listModel?>
?&gt;
</textarea>

<br><b>View</b> <br>
<textarea rows="20" cols="150">

<?=$listView?>

</textarea>

<br><b>Form</b> <br>
<textarea rows="20" cols="150">

<?=$listForm?>

</textarea>

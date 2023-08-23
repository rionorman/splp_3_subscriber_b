<?php
$v_table = $_POST["p_table"];
$v_db = $_POST["p_db"];
$v_controller = $_POST["p_controller"];

$myPDO = new PDO('sqlite:../database/database.sqlite');

if ($v_table != "") {
	$mySqlTbl = "select * from " . $v_table . " limit 1";

	//get fields name
	$resultSqlTbl = $myPDO->query($mySqlTbl);
	$fieldCountTbl = $resultSqlTbl->columnCount() + 2;

	for ($i = 0; $i < $resultSqlTbl->columnCount(); $i++) {
		$col = $resultSqlTbl->getColumnMeta($i);
		$fieldName[$i] = strtolower($col['name']);
		$paramName[$i] = "p_" . strtolower($col['name']);
		$variableName[$i] = "v_" . strtolower($col['name']);
	}

	//----------------------------------------------------------------------
	//Web Routing
	$web = "Route::resource('" . strtolower($v_controller) . "', " . $v_controller . "Controller::class);\n";
	$web .= "Route::get('/" . strtolower($v_controller) . "/{id" . strtolower($v_controller) . "}/delete', [" . $v_controller . "Controller::class,'delete']);\n\n";

	// $web .= "Route::get('/".strtolower($v_controller)."', '".$v_controller."Controller@index');\n";
	// $web .= "Route::get('/".strtolower($v_controller)."/insert', '".$v_controller."Controller@insert');\n";
	// $web .= "Route::get('/".strtolower($v_controller)."/{id".strtolower($v_controller)."}/update', '".$v_controller."Controller@update');\n";
	// $web .= "Route::get('/".strtolower($v_controller)."/{id".strtolower($v_controller)."}/delete', '".$v_controller."Controller@delete');\n";
	// $web .= "Route::get('/".strtolower($v_controller)."/{id".strtolower($v_controller)."}/detail', '".$v_controller."Controller@detail');\n";
	// $web .= "Route::post('/".strtolower($v_controller)."/manage', '".$v_controller."Controller@manage');\n";


	//----------------------------------------------------------------------
	//Controller
	$listController = "namespace App\Http\Controllers;\n\n";

	// $listController .= "//use Illuminate\Support\Facades\DB;\n\n";

	$listController .= "use App\\Models\\" . $v_controller . ";\n";
	$listController .= "use Illuminate\Http\Request;\n\n";

	$listController .= "class " . $v_controller . "Controller extends Controller {\n\n";

	$listController .= "public function index(){\n" .
		"	$" . "rows = " . $v_controller . "::all();\n" .
		"	return view('" . strtolower($v_controller) . "/" . strtolower($v_controller) . "list',['rows' => $" . "rows]);\n" .
		"}\n";

	$listController .= "\n";

	$listController .= "public function create(){\n" .
		"	return view('" . strtolower($v_controller) . "/" . strtolower($v_controller) . "form',['action' => 'insert']);\n" .
		"}\n\n";

	$listController .= "public function store(Request $" . "request" . "){\n";
	$listController .= "		$" . strtolower($v_controller) . " = new " . $v_controller . ";\n";
	for ($i = 0; $i < count($fieldName); $i++) {
		$listController .= "		$" . strtolower($v_controller) . " -> " . $fieldName[$i] . " = $" . "request -> " . $fieldName[$i] . ";\n";
	}
	$listController .= "		$" . strtolower($v_controller) . " -> save();\n";
	$listController .= "	return redirect('/" . strtolower($v_controller) . "');\n";
	$listController .= "	}\n\n";

	$listController .= "public function show($" . "id" . strtolower($v_controller) . "){\n" .
		"	$" . strtolower($v_controller) . " = " . $v_controller . "::find($" . "id" . strtolower($v_controller) . ");\n" .
		"	return view('" . strtolower($v_controller) . "/" . strtolower($v_controller) . "form',['row' => $" . strtolower($v_controller) . ",'action' => 'detail']);\n" .
		"}\n\n";

	$listController .= "public function edit($" . "id" . strtolower($v_controller) . "){\n" .
		"	$" . strtolower($v_controller) . " = " . $v_controller . "::find($" . "id" . strtolower($v_controller) . ");\n" .
		"	return view('" . strtolower($v_controller) . "/" . strtolower($v_controller) . "form',['row' => $" . strtolower($v_controller) . ",'action' => 'update']);\n" .
		"}\n\n";

	$listController .= "public function update(Request $" . "request" . "){\n";
	$listController .= "		$" . strtolower($v_controller) . " = " . $v_controller . "::find($" . "request -> " . $fieldName[0] . ");\n";
	for ($i = 0; $i < count($fieldName); $i++) {
		$listController .= "		$" . strtolower($v_controller) . " -> " . $fieldName[$i] . " = $" . "request -> " . $fieldName[$i] . ";\n";
	}
	$listController .= "		$" . strtolower($v_controller) . " -> save();\n";
	$listController .= "	return redirect('/" . strtolower($v_controller) . "');\n";
	$listController .= "	}\n\n";

	$listController .= "public function delete($" . "id" . strtolower($v_controller) . "){\n" .
		"	$" . strtolower($v_controller) . " = " . $v_controller . "::find($" . "id" . strtolower($v_controller) . ");\n" .
		"	return view('" . strtolower($v_controller) . "/" . strtolower($v_controller) . "form',['row' => $" . strtolower($v_controller) . ",'action' => 'delete']);\n" .
		"}\n\n";

	$listController .= "public function destroy($" . "id" . strtolower($v_controller) . "){\n";
	$listController .= "		$" . strtolower($v_controller) . " = " . $v_controller . "::find($" . $fieldName[0] . ");\n";
	$listController .= "		$" . strtolower($v_controller) . " -> delete();\n" .
		"	return redirect('/" . strtolower($v_controller) . "');\n" .
		"}\n";

	$listController .= "}";
	//end Controler
	//----------------------------------------------------------------------

	//----------------------------------------------------------------------
	//Model
	$listModel = "namespace App\Models;\n\n";
	$listModel .= "use Illuminate\\Database\\Eloquent\\Model;\n\n";
	$listModel .= "class " . $v_controller . " extends Model\n{\n";
	$listModel .= "	public $" . "primaryKey  = 'id" . strtolower($v_controller) . "';\n";
	$listModel .= "	protected $" . "table = 'tb_" . strtolower($v_controller) . "';\n}";
	//end Model
	//---------------------------------------------------------------------


	//-----------------------------------------------------------------------
	//View
	$listView = "<div class=\"card\">\n";
	$listView .= "<h5 class=\"card-header\"> Data " . $v_controller . "</h5>\n";
	$listView .= "		<div class=\"card-body\">\n";
	$listView .= "			<div class=\"table-responsive\">\n";
	$listView .= "<table class=\"table table-striped table-hover \">\n";
	$listView .= "<thead class=\"thead-dark\">\n";
	$listView .= "<tr>\n";
	for ($i = 0; $i < count($fieldName); $i++) {
		$listView .= "		&lt;th&gt;" . ucfirst($fieldName[$i]) . "&lt;/th&gt;\n";
	}
	$listView .= "		&lt;th&gt;&lt;a href=\"{{asset('/')}}" . strtolower($v_controller) . "/create\"&gt; &lt;i class=\"fas fa-plus\"&gt;&lt;/i&gt;&lt;/a&gt;&lt;/th&gt;\n";
	$listView .= "</tr>\n";
	$listView .= "</thead>\n";
	$listView .= "<tbody>\n";
	$listView .= "@php ($" . "no = 1)\n";
	$listView .= "@foreach ($" . "rows as $" . "row)\n";
	$listView .= "<tr>\n";
	for ($i = 0; $i < count($fieldName); $i++) {
		$listView .= "		&lt;td&gt;{{ $" . "row['" . $fieldName[$i] . "'] }}&lt;/td&gt;\n";
	}
	$listView .= "<td align=\"center\">\n";
	$listView .= "&lt;a href=\"{{asset('/')}}" . strtolower($v_controller) . "/{{ $" . "row-&gt;id" . strtolower($v_controller) . " }}\"&gt;&lt;i class=\"fas fa-info-circle\"&gt;&lt;/i&gt;&lt;/a&gt;\n";
	$listView .= "&lt;a href=\"{{asset('/')}}" . strtolower($v_controller) . "/{{ $" . "row-&gt;id" . strtolower($v_controller) . " }}/edit\"&gt;&lt;i class=\"far fa-edit\"&gt;&lt;/i&gt;&lt;/a&gt;\n";
	$listView .= "&lt;a href=\"{{asset('/')}}" . strtolower($v_controller) . "/{{ $" . "row-&gt;id" . strtolower($v_controller) . " }}/delete\"&gt;&lt;i class=\"far fa-trash-alt\"&gt;&lt;/i&gt;&lt;/a&gt;\n";
	$listView .= "</td>\n";
	$listView .= "</tr>\n";
	$listView .= "@endforeach\n";
	$listView .= "</tbody>\n";
	$listView .= "</table>\n";
	$listView .= "		</div>\n";
	$listView .= "	</div>\n";
	$listView .= "</div>\n";

	//end View
	//-------------------------------------------------------------------------------------------

	//-------------------------------------------------------------------------------------------

	//form
	$listForm = "&lt;script&gt;\n" .
		"function button_cancel(){\n" .
		"	location.replace(\"{{ asset('/') }}" . strtolower($v_controller) . "\");\n" .
		"}\n" .
		"&lt;/script&gt;\n";
	$listForm .= "<div class=\"card\">\n";
	$listForm .= "<h5 class=\"card-header\"> Data " . $v_controller . "</h5>\n";
	$listForm .= "		<div class=\"card-body\">\n";
	// <form class="form-horizontal" action="{{ asset('/') }}blog/manage" method="post">
	// $listForm .="<form class=\"form-horizontal\" action=\"{{ asset('/') }}".strtolower($v_controller)."/manage\" method=\"post\">\n";
	// $listForm.="&lt;?=form_open('".strtolower($v_controller)."/".strtolower($v_controller)."_manage','class=\"form-horizontal\"')?&gt;\n";
	$listForm .= "@if($" . "action == 'insert')\n";
	$listForm .= "<form class=\"form-horizontal\" action=\"{{ asset('/') }}" . strtolower($v_controller) . "\" method=\"post\">\n";
	for ($i = 0; $i < count($fieldName); $i++) {
		$listForm .= "<div class=\"mb-3 row\">\n" .
			"	<label for=\"$fieldName[$i]\" class=\"col-sm-2 col-form-label\">" . ucfirst($fieldName[$i]) . "</label>\n" .
			"	<div class=\"col-sm-10\">\n" .
			"	   <input class=\"form-control\" type=\"text\" name=\"$fieldName[$i]\" value=\"\">\n" .
			"       </div>\n" .
			"</div>\n";
	}

	$listForm .= "<div class=\"mb-3\">\n" .
		"	<div class=\"offset-sm-2 col-sm-10\">\n" .
		"		&lt;input type = \"hidden\" name = \"action\" value = \"{{ $" . "action }}\"&gt;\n" .
		"		<button type=\"submit\" class=\"btn btn-primary\">Insert</button>\n" .
		"		<button type=\"button\" class=\"btn btn-secondary\" onclick=\"button_cancel()\">Cancel</button>\n" .
		"	</div>\n" .
		"</div>\n";
	$listForm .= "{{ csrf_field() }}\n";
	$listForm .= "</form>\n";
	$listForm .= "@elseif($" . "action == 'update')\n";
	$listForm .= "<form class=\"form-horizontal\" action=\"{{ asset('/') }}" . strtolower($v_controller) . "/{{ $" . "row->id" . strtolower($v_controller) . " }}\" method=\"post\">\n";
	for ($i = 0; $i < count($fieldName); $i++) {
		$listForm .= "<div class=\"mb-3 row\">\n" .
			"	<label for=\"$fieldName[$i]\" class=\"col-sm-2 col-form-label\">" . ucfirst($fieldName[$i]) . "</label>\n" .
			"	<div class=\"col-sm-10\">\n" .
			"	   <input class=\"form-control\" type=\"text\" name=\"$fieldName[$i]\" value=\"{{ $" . "row->" . $fieldName[$i] . " }}\"&gt;\n" .
			"       </div>\n" .
			"</div>\n";
	}

	$listForm .= "<div class=\"mb-3 row\">\n" .
		"	<div class=\"offset-sm-2 col-sm-10\">\n" .
		"		@method(\"PATCH\")\n" .
		"		&lt;input type = \"hidden\" name = \"action\" value = \"{{ $" . "action }}\"&gt;\n" .
		"		&lt;input type = \"hidden\" name = \"" . "id" . strtolower($v_controller) . "\" value = \"{{ $" . "row->id" . strtolower($v_controller) . " }}\"&gt;\n" .
		"		<button type=\"submit\" class=\"btn btn-warning\">Update</button>\n" .
		"		<button type=\"button\" class=\"btn btn-secondary\" onclick=\"button_cancel()\">Cancel</button>\n" .
		"	</div>\n" .
		"</div>\n";
	$listForm .= "{{ csrf_field() }}\n";
	$listForm .= "</form>\n";
	$listForm .= "@elseif($" . "action == 'delete')\n";
	$listForm .= "<form class=\"form-horizontal\" action=\"{{ asset('/') }}" . strtolower($v_controller) . "/{{ $" . "row->id" . strtolower($v_controller) . " }}\" method=\"post\">\n";
	for ($i = 0; $i < count($fieldName); $i++) {
		$listForm .= "<div class=\"mb-3 row\">\n" .
			"	<label for=\"$fieldName[$i]\" class=\"col-sm-2 control-label\">" . ucfirst($fieldName[$i]) . "</label>\n" .
			"	<div class=\"col-sm-10\">\n" .
			"	   {{ $" . "row->" . $fieldName[$i] . " }}\n" .
			"       </div>\n" .
			"</div>\n";
	}

	$listForm .= "<div class=\"mb-3 row\">\n" .
		"	<div class=\"offset-sm-2 col-sm-10\">\n" .
		"		@method(\"DELETE\")\n" .
		"		&lt;input type = \"hidden\" name = \"action\" value = \"{{ $" . "action }}\"&gt;\n" .
		"		&lt;input type = \"hidden\" name = \"" . "id" . strtolower($v_controller) . "\" value = \"{{ $" . "row->id" . strtolower($v_controller) . " }}\"&gt;\n" .
		"		<button type=\"submit\" class=\"btn btn-danger\">Delete</button>\n" .
		"		<button type=\"button\" class=\"btn btn-secondary\" onclick=\"button_cancel()\">Cancel</button>\n" .
		"	</div>\n" .
		"</div>\n";
	$listForm .= "{{ csrf_field() }}\n";
	$listForm .= "</form>\n";
	$listForm .= "@elseif($" . "action == 'detail')\n";
	for ($i = 0; $i < count($fieldName); $i++) {
		$listForm .= "<div class=\"mb-3 row\">\n" .
			"	<label for=\"$fieldName[$i]\" class=\"col-sm-2 control-label\">" . ucfirst($fieldName[$i]) . "</label>\n" .
			"	<div class=\"col-sm-10\">\n" .
			"	   {{ $" . "row->" . $fieldName[$i] . " }}\n" .
			"       </div>\n" .
			"</div>\n";
	}

	$listForm .= "<div class=\"mb-3 row\">\n" .
		"	<div class=\"offset-sm-2 col-sm-10\">\n" .
		"		<button type=\"button\" class=\"btn btn-secondary\" onclick=\"button_cancel()\">Back</button>\n" .
		"	</div>\n" .
		"</div>\n";


	$listForm .= "@endif\n";
	$listForm .= "	</div>\n";
	$listForm .= "</div>\n";

	//end form
	//--------------------------------------------------------------------------------------------

}


?>
<form action="#" method="post">
	Nama DB : <input type="text" name="p_db" value="<?= $v_db ?>"><br>
	Nama Table : <input type="text" name="p_table" value="<?= $v_table ?>"><br>
	Controller : <input type="text" name="p_controller" value="<?= $v_controller ?>"><br>
	<input type="Submit" value="Submit">

</form>
<b>Routing</b> <br>Diletakkan pada file web.php untuk routing.<br>
<textarea rows="20" cols="150">
<?= $web ?>
</textarea>

<br><b>Controller</b> <br>
<textarea rows="20" cols="150">
&lt;?php
<?= $listController ?>
</textarea>

<br><b>Model</b> <br>
<textarea rows="15" cols="150">&lt;?php
<?= $listModel ?></textarea>

<br><b>View</b> <br>
<textarea rows="30" cols="150">
@extends('layouts.app')

@section('title')
  Data <?= $v_controller ?>&nbsp;
@endsection

@section('content')
<div class="container">
<?= $listView ?>
</div>
@endsection

</textarea>

<br><b>Form</b> <br>
<textarea rows="30" cols="150">
@extends('layouts.app')

@section('title')
  Data <?= $v_controller ?>&nbsp;
@endsection

@section('content')
<div class="container">
<?= $listForm ?>
</div>
@endsection

</textarea>

<br><b>Script</b> <br>
<textarea rows="30" cols="150">
	<!-- Google icons -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</textarea>
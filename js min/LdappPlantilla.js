var id="NULL";$(document).ready(function(){$("#frmPlantilla :input").prop("disabled",!0),$("#btnLogin").click(function(){Connect()&&($("#frmPlantilla :input").prop("disabled",!1),$("#grupo").selectpicker("refresh"),$("#ambiente").selectpicker("refresh"),$("#accion").selectpicker("refresh"),$("#accion option").val("Agregar"))}),$("#aplicacion").on("change",function(){getGroupsByAppName()})});function DisableForm(){$("#frmPlantilla").children(":input").attr("disabled","disabled")}function EnableForm(){$("#frmPlantilla").children(":input").removeAttr("disabled")}function Send(){alert("Send();")}
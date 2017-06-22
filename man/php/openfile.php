<?php
/*主站 管理中心 */
header("Content-type: text/html; charset=utf-8;");
require('./checkreferer.php');
$file_path = "../".base64_decode($_GET["dir"]);
if(file_exists($file_path)){
$file=file_get_contents($file_path);
$file=htmlspecialchars($file);
?>
<!DOCTYPE HTML>
<html>
<head> 
<title>代码编辑</title>
<link href="/man/js/codemirror/lib/codemirror.css" rel="stylesheet" type="text/css">
<link href="/man/js/codemirror/theme/monokai.css" rel="stylesheet" type="text/css">
<link href="/man/js/codemirror/addon/display/fullscreen.css" rel="stylesheet" type="text/css">

<!-- 引入CodeMirror核心文件 -->
<script type="text/javascript" src="/man/js/codemirror/lib/codemirror.js"></script>

<!-- CodeMirror支持不同语言，根据需要引入JS文件 -->
<!-- 因为HTML混合语言依赖Javascript、XML、CSS语言支持，所以都要引入 -->
<script type="text/javascript" src="/man/js/codemirror/mode/javascript/javascript.js"></script>
<script type="text/javascript" src="/man/js/codemirror/mode/xml/xml.js"></script>
<script type="text/javascript" src="/man/js/codemirror/mode/css/css.js"></script>
<script type="text/javascript" src="/man/js/codemirror/mode/htmlmixed/htmlmixed.js"></script>

<!-- 下面分别为显示行数、括号匹配和全屏插件 -->
<script type="text/javascript" src="/man/js/codemirror/addon/selection/active-line.js"></script>
<script type="text/javascript" src="/man/js/codemirror/addon/edit/matchbrackets.js"></script>
<script type="text/javascript" src="/man/js/codemirror/addon/display/fullscreen.js"></script>

<script type="text/javascript" src="/ppf/js/jquery-1.min.js"></script>
</head>
<body>
<textarea name="code" id="code" style="width:100%;height:100%;">
<?php echo $file ?>
</textarea>
<input type="hidden" id="filedir" value="<?php echo $file_path ?>"/>
<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,     // 显示行数
        indentUnit: 4,         // 缩进单位为4
        styleActiveLine: true, // 当前行背景高亮
        matchBrackets: true,   // 括号匹配
        mode: 'htmlmixed',     // HMTL混合模式
        lineWrapping: true,    // 自动换行
        theme: 'monokai'      // 使用monokai模版
    });
    editor.setOption("extraKeys", {
        // Tab键换成4个空格
        Tab: function(cm) {
            var spaces = Array(cm.getOption("indentUnit") + 1).join(" ");
            cm.replaceSelection(spaces);
        },
        // F11键切换全屏
        "F11": function(cm) {
            cm.setOption("fullScreen", !cm.getOption("fullScreen"));
        },
        // Esc键退出全屏
        "Esc": function(cm) {
            if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
        }
    });
	editor.setSize('auto', 'auto');
	
	function savefile(index){
		$.post("../srv/file.php",{tpl:"savefile",dir:$("#filedir").val(),file:editor.getValue()},function(d){
			if(d=="ok"){
				parent.layer.msg("保存成功");
				//parent.layer.close(index);
			}else{
				parent.layer.msg("保存失败");
			}
		})
	}
</script>
</body>
<?php
}
?>
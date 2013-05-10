<?php
  header('Content-Type: text/html; charset=utf-8');
	include 'header.php';
	require 'function.php'; 
	
	$php_dir=dirname(__FILE__);
	$php_file = basename(__FILE__);

	$method=isset($_GET['method'])?$_GET['method']:null;
	
	switch($method){
		case 'edit':
			$filename = isset($_GET['filename'])?$_GET['filename']:null;
			echo '<h1>编辑文件：</h1><hr/>';
			echo '<form method="post" action="'.$php_file.'?method=edit" >';
			echo   '<textarea rows="10" cols="50" name="content">';
			echo		file_get_contents($php_dir.'/upload/'.$filename);
			echo   '</textarea>';
			echo   '<input type="hidden" name="filename" value="'.$filename.'" />';
			echo   '<input type="submit" name="submit" value="提交" />';
			echo   '<a href="index.php" style="padding-left:20px;">返回</a>';
			echo '</form>';
			
			//编辑文件
			if(isset($_POST['submit'])){
				$content = isset($_POST['content'])?$_POST['content']:null;
				$filename = isset($_POST['filename'])?$_POST['filename']:null;
				file_put_contents('upload/'.$filename,$content);
				echo '保存成功！<a href="index.php" style="padding-left:20px;">返回</a>';
				echo '<h3>文件当前内容为：</h3><hr/>';
				echo  file_get_contents($php_dir.'/upload/'.$filename);
			}
			break;
		default:
			echo '<h1>上传文件</h1><hr/>';
			echo '<form action="'.$php_file.'" method="post" enctype="multipart/form-data">';
			echo '<label for="file">上传文件</label>';
			echo '<input type="file" name="file" id="file" />';
			echo '<input type="submit" name="submit" value="提交" /><br />';
			echo '</form>';
			
			//判断提交成功否
			echo '<br />';
			if(isset($_POST['submit'])){
				if($_FILES["file"]["type"]=="text/plain"){
					if ($_FILES["file"]["error"] > 0){
					  	$html="上传错误".$_FILES["file"]["error"];
					}else{
						
					   	move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]); 
						//move_uploaded_file($_FILES["file"]["tmp_name"], iconv("UTF-8","gb2312", "upload/" . $_FILES["file"]["name"])); 
						//move_uploaded_file($_FILES["file"]["tmp_name"], mb_convert_encoding("upload/" . $_FILES["file"]["name"]),"UTF-8","gb2312"); 
						$html="上传成功！";
					}
				}else{
					$html="非法文件";}
				echo $html;
			}
			
			//提交的全部文件
			echo '<br /><h3>提交的文件：</h3><hr />';
			$dir = "./upload/";
			$text = glob($dir . "*.txt");
			foreach($text as $txt)
			{
				echo $txt . '<a href="'.$php_file.'?method=edit&filename='.substr($txt,9).'">编辑</a><br/>';
			}
			break;	
	}


	include 'footer.php';
?> 
    

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
	if(isset($css_files)):
		foreach($css_files as $file): ?>
		<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php endforeach; endif; ?>
</head>
<body>
    <div>
		<a href='<?php echo site_url('Backoffice/users')?>'>Users</a> |
		<a href='<?php echo site_url('Backoffice/questions')?>'>Questions</a> |
		<a href='<?php echo site_url('Backoffice/greetings')?>'>Greetings</a> |
		<a href='<?php echo site_url('Backoffice/expressions')?>'>Expressions</a> |
		<a href='<?php echo site_url('Backoffice/answers')?>'>Answers</a> |
	</div>


<body>
	<div style='height:20px;'></div>  
    <div style="padding: 10px">
		<?php if(isset($output)) echo $output; ?>
    </div>
    <?php 
		if(isset($js_files)): 
			foreach($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; 
			endif;?>


</body>
</html>
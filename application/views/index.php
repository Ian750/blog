<!DOCTYPE html>
<html>
<title>學生</title>
<body>
<!--GET表單傳遞資料-->
<h2><?php echo $title ?></h2>

	<?php foreach ($all_student as $student): ?>

	        <h3><?php echo $student['name'] ?></h3>
	        <div class="main">
	                <?php echo $student['intro'] ?>
	        </div>
	        <p><a href="students/<?php echo $student['number'] ?>">View article</a></p>

	<?php endforeach ?>
	
</body>
</html>
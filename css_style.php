<link rel="stylesheet" href="style/bootstrap.min.css" />
<link rel="stylesheet" href="style/style.css" />
<?php 
if(isAdmin()) echo '<!--ADMIN MODE-->
<link rel="stylesheet" href="style/admin.css" />
<!--END ADMIN-->'; 
?>
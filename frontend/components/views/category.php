<?php

use yii\Helpers\Html;

?>
<div class="sidebar" id="sidebar-responsive">
<?php	
    foreach($categories as $category)
    {
        echo $category;
    }
?>
</div>
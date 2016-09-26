<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// echo "<pre>";print_r($result);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Elasticsearch</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
<!-- Search Box -->
<div class="container">
    <form method="get">
        <div class="search-box-top">
				<span class="header">
					Elasticsearch Search :
				</span>
            <input type="text"
                   id="search_suggestion"
                   name="q"
                   placeholder="Enter your keyword here . . ."
                   size="40"
                   value="<?php if($this->input->get('q') != '') echo strip_tags($this->input->get('q')); ?>" />
            <button type="submit">Go</button>
        </div>
    </form>
    <?php if($this->input->get('q') != '') :
//            echo "<pre>";print_r($data);
        ?>

        <div class="content">
            <?php foreach ($data as $row) :
                $pid = $row['_source']['Pid'];
                $product_name = $row['_source']['ProductName'];
                $description = $row['_source']['Description'];
                $category_id = $row['_source']['CategoryId'];
                $category_name = $row['_source']['CategoryName'];
                $attributes = $row['_source']['Attributes'];
                $image_url = $row['_source']['ImageUrl'];
                ?>
                <!-- Filter  -->
                <div class="filter">
                    <?php foreach ($attributes as $attribute) :
                        $attr_id = $attribute['AttributeId'];
                        $attr_name = $attribute['AttributeName'];
                        ?>
                        <div>
                            <?php echo $attr_id; ?>
                            <?php echo $attr_name; ?>
                            >
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- End Filter -->
                <!-- Product List -->
                <div class="product">
                    <div>
                        <img src="<?php echo $image_url; ?>" width="100%" />
                        <div class="title">
                            <b><?php echo $product_name;?></b>
                            <br>
                            <?php echo $description;?>
                            <?php echo $category_name;?>
                        </div>
                    </div>
                </div>
                <!-- End Product List -->
<!--                <div style="clear:both;"></div>-->
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>

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
                   class="search"
                   value="<?php if($this->input->get('q') != '') echo strip_tags($this->input->get('q')); ?>" />
            <button type="submit">Go</button>
        </div>
    </form>
    <?php if($this->input->get('q') != '') :
//            echo "<pre>";print_r($data);
        ?>

        <div class="content">
            <!-- Search Filter -->
            <div class="search-filter">
                <!-- Category -->
                <?php if(isset($AllCategories_filter)) : ?>
                    <div class="category-filter">
                        <h2>Categories</h2>
                        <?php foreach ($AllCategories_filter as $category) :
                            $category_id = $category['key'];
                            $category_name = $category['CategoryName']['buckets'][0]['key'];
                            $count = $category['doc_count'];
                            ?>
                            <a href="#">
                                <p>
                                    <?php echo $category_name;?> (<?php echo $count;?>)
                                </p>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <!-- End Category -->
                <!-- Brand -->
                <div class="brand-filter">
                    <h2>Brands</h2>
                    <?php foreach ($AllBrands_filter as $category) :
                        $brandId = $category['key'];
                        $brand_name = $category['BrandName']['buckets'][0]['key'];
                        $count = $category['doc_count'];
                        ?>
                        <a href="#">
                            <p>
                                <?php echo $brand_name;?> (<?php echo $count;?>)
                            </p>
                        </a>
                    <?php endforeach; ?>
                </div>
                <!-- End Brand -->
                <!-- Size -->
                <?php if(isset($size_attribute)) : ?>
                    <h2>Size</h2>
                    <div class="attribute-filter">
                        <?php foreach ($size_attribute['data'] as $size) :
                            $id = $size_attribute['key'];
                            $name = $size['key'];
                            $count = $size['doc_count'];
                            ?>
                            <div>
                                <input type="checkbox"
                                       class="attr-checkbox"
                                       id="attr-<?php echo $id; ?>">
                                <label for="attr-<?php echo $id; ?>">
                                    <?php echo strtoupper($name); ?> (<?php echo $count;?>)
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <!-- End Size -->
                <!-- Color -->
                <?php if(isset($color_attribute)) : ?>
                    <h2>Color</h2>
                    <div class="attribute-filter">
                        <?php foreach ($color_attribute['data'] as $color) :
                            $id = $color_attribute['key'];
                            $name = $color['key'];
                            $count = $color['doc_count'];
                            ?>
                            <div>
                                <input type="checkbox"
                                       class="attr-checkbox"
                                       id="attr-<?php echo $id; ?>">
                                <label for="attr-<?php echo $id; ?>">
                                    <?php echo ucfirst($name); ?> (<?php echo $count;?>)
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <!-- End Color -->
            </div>
            <!-- End Search Filter -->

            <!-- Product List -->
            <div class="products-list">
                <?php foreach ($data as $row) :
                    $pid = $row['_source']['Pid'];
                    $brand_name = $row['_source']['BrandName'];
                    $product_name = $row['_source']['ProductName'];
                    $description = $row['_source']['Description'];
                    $attributes = $row['_source']['Attributes'];
                    $image_url = $row['_source']['ImageUrl'];
                    ?>

                    <div class="product">
                        <div>
                            <img src="<?php echo $image_url; ?>" width="100%" />
                            <div class="title">
                                <b><?php echo $brand_name;?></b>
                                <br>
                                <?php echo $product_name;?>
                            </div>
                        </div>
                    </div>

    <!--                <div style="clear:both;"></div>-->
                <?php endforeach; ?>
            </div>
            <!-- End Product List -->
        </div>
    <?php endif; ?>
</body>
</html>

<?php 

echo $header; 
//pre($post_info);

?>

<h1><?php echo $heading; ?></h1>
<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <?php foreach($langs as $lang) {?>
              <img src="<?php echo HTTP_SERVER . 'imgs/flags/' . $lang['img'] ?> "> 
              <input type="text" name="post_details[<?php echo $lang['lang_id']; ?>][title]" value="<?php echo $post_info['post_details'][$lang["lang_id"]]['title']; ?>" placeholder="title" alt= "<?php echo $lang['name']; ?>" title = "<?php echo $lang['name']; ?>">
              
              <?php if ( is_array($error_title) && array_key_exists($lang['lang_id'], $error_title)) { ?>
              <span style="color:red;"><?php  echo $error_title[$lang['lang_id']]?></span>
              <?php } ?><br>
              <textarea name="post_details[<?php echo $lang['lang_id']; ?>][content]"   cols="38" rows="18"><?php echo $post_info['post_details'][$lang["lang_id"]]['content']; ?></textarea>
              <?php if ( is_array($error_content) && array_key_exists($lang['lang_id'], $error_content)) { ?>
              <span style="color:red;"><?php  echo $error_content[$lang['lang_id']]?></span>
              <?php } ?><br><br><br><br>
    <?php } ?>
   
    <select name="cate_details[1][cate_id]">
        
    <?php foreach ($categories as $category){ ?>
          <option  value="<?php echo $category['cate_id'] ?>" <?php echo (isset($post_info) && $category["cate_id"] == $post_info["cat_id"]) ? "selected": null; ?> ><?php echo $category['name'] ?></option> 
    <?php  } ?>
        
    </select>
    <input type="submit">
</form>
<?php    
echo $footer;
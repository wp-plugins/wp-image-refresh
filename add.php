<?php
global $wpdb;
include_once dirname(__FILE__) . '/functions.php';

$success = '';
@$id = $_REQUEST['id'];
$error = '';
$tablename = $wpdb->prefix . "image_refresh";


if ($id) {
    $detail = $wpdb->get_results("SELECT * FROM $tablename where id_pk = $id", OBJECT);
}

$filename = '';
$data = array();
if (isset($_POST["save"]) || isset($_POST["exit"])) {
    //$slideTitle = mysql_real_escape_string($_POST['slideTitle']);
	$slideTitle = $_POST['slideTitle'];

    $slideImage = $_POST['path'];

    if ($slideTitle == '') {
        $error[] = "Please enter image title";
    }


    if (empty($detail) && empty($slideImage)) {
        $error[] = "Please select image to upload";
    }
    $ext = end(explode('.', $slideImage));
    $allowed = array('jpg', 'jpeg', 'png');

    if (!in_array($ext, $allowed)) {
        $error[] = "Only jpg and png files are allowed";
    }

    if (!$error) {
        if (!empty($slideImage)) {
            if (!$id) {
                $sortorder = $wpdb->get_results("SELECT MAX(slideOrder) as max FROM $tablename", OBJECT);
                if (!empty($sortorder[0]->max)) {
                    $sort = $sortorder[0]->max + 1;
                } else {
                    $sort = 1;
                }
            } else {
                $sort = $detail[0]->slideOrder;
            }

            $filename = $slideImage;
        } elseif (!empty($detail[0]->slideImage)) {
            $filename = $detail[0]->slideImage;
            $sort = $detail[0]->slideOrder;
        }

        $data = array(
            'slideTitle' => $slideTitle,
            'slideText' => '',
            'slideImage' => $filename,
            'slideOrder' => $sort
        );

        if (!$error) {
            if ($id) {
                $where = array(
                    'id_pk' => $id
                );
                $wpdb->update($tablename, $data, $where);
                $success = "Image updated successfully";
                
            } else {
                $wpdb->insert($tablename, $data);
                $success = "Image added successfully";
            }
            
            if(isset($_POST["exit"])){
                   $_SESSION['msg'] =  $success;
                   wp_redirect(get_option('siteurl').'/wp-admin/admin.php?page=wp_image_refresh');
            }
        }
    }
}
$img_path = '';
if ($id) {
    $detail = $wpdb->get_results("SELECT * FROM $tablename where id_pk = $id", OBJECT);
    $img_path = $detail[0]->slideImage;
}
?>


        <div class="wpwrap">
        <h2 id="add-new-user"> <?php if($id){ echo "Edit Image";} else{ echo "Add New Image";} ?></h2>

        <?php if(!empty($success)){ echo '<div class="updated success" id="message"><p>'.$success.'</p></div>'; } ?>

        <?php
        if(!empty($error)){
        if(is_array($error)){
                for($i=0; $i<count($error); $i++){
                        echo  '<div class="updated error" id="message"><p>'.$error[$i]."</div><br>";
                        }
        }else { echo '<div class="error">'.$error.'</div>';}

        }?>
        
        <div id="ajax-response"></div>

        <form class="validate" id="slidercreate" name="slidercreate" method="post" action="" enctype="multipart/form-data">
        <table class="form-table">
	<tbody>
	<tr class="form-field form-required">
		<th scope="row"><label for="slideTitle">Image Title <span class="description">(required)</span></label></th>
		<td><input style="width: 64%;" type="text" aria-required="true" value="<?php if(!empty($detail[0]->slideTitle)){ echo $detail[0]->slideTitle;} ?>" id="slideTitle" name="slideTitle"><br><span class="slideTitle" style="color:red;"></span></td>
	</tr>

	
	<tr class="form-field form-required">
		<th scope="row"><label for="slideImage">Upload Image<span class="description">(required)</span></label></th>
		<td>Paste image url
		<input type="text" name="path" class="image_path" value="<?php echo $img_path; ?>" id="image_path">
		or select from media library
		<input type="button"  value="Select" class="button-primary" id="upload_image"/>
		<br><span class="slideImage" style="color:red;"></span>
		</td>
		<input type="hidden" id="slideedit" value="<?php if(!empty($detail[0]->id_pk)){ echo $detail[0]->id_pk;} ?>">
	</tr>
	
	<tr class="form-field form-required">
	<th></th>
	<td><?php if(!empty($img_path)){ echo '<img src="'.$img_path.'">'; } ?>
	</td>
	</tr>
	
	</tbody>
        </table>
            
        <p class="submit">
            <input type="submit" name="save" value="Save and Continue" class="button button-primary" id="createusersub" name="createuser">
            <input type="submit" name="exit" value="Save and Exit" class="button button-primary" id="createusersub" name="createuser">
        </p>
        
        </form>
        </div>

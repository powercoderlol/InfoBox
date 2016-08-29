<?php
/*
Plugin Name: Info Box
Plugin URI: http://vk.com/coderlol
Description: Implement simple box with custom style: fonts, background image, title and content. Embadded editor is TinyMCE
Version: 0.1
Author: coderlol
Author URI: http://vk.com/coderlol
*/


define('INFOBOX_ABSPATH', plugin_dir_path(__FILE__) );


function coderlol_info_box_add_admin_pages() {
	//Add a new submenu under Options
	add_menu_page('Info Box','Info Box','manage_options','infobox','','dashicons-analytics');
	add_submenu_page('infobox','Create a Box','Create a Box','manage_options','infobox', 'coderlol_info_box_option_subpage_0');
	add_submenu_page('infobox', 'Change a Box', 'Change a Box', 'manage_options', 'change_infobox', 'coderlol_info_box_option_subpage_2');
}

/* OPTIONS PAGE EVENTS
****************************************************************/

function coderlol_info_box_option_subpage_0() {

	global $wpdb;
	global $post;
	global $note_desk_template;
	global $preview;
	$preview = 'false';
	$table_info_box = $wpdb->prefix . "coderlol_info_box";

	//$coderlol_note_color = "#";



/**

PREVIEW BUTTON EVENT BEGIN

*/
	if ( isset($_POST['coderlol_preview_note_btn']) )
	{

		$preview = 'true';
		//$coderlol_note_color = "#";
		$coderlol_title = $_POST['coderlol_title'];
		$coderlol_content = stripslashes($_POST['coderlol_content']);
		$coderlol_category = $_POST['coderlol_category'];
		$coderlol_color = $coderlol_note_color.$_POST['coderlol_note_color'];
		$coderlol_color_transfer = $_POST['coderlol_note_color'];
		$coderlol_title_height = $_POST['coderlol_note_fontsize'];
		$coderlol_note_rotation = $_POST['coderlol_note_rotation'];
		$coderlol_grad = $_POST['grad'];
		if ($coderlol_grad == 'on') { $coderlol_grad='1'; } else { $coderlol_grad = '0'; }
		$coderlol_grad_color = $coderlol_note_color.$_POST['coderlol_note_color_grad'];
		$coderlol_grad_position = $_POST['coderlol_grad_position'];

		if ($coderlol_category == 'Прочее') {
			$coderlol_category = '0';
		}
		else {
			$coderlol_category = '1';
		}


		$note_atts = array(
			"title" => $coderlol_title,
			"content" => $coderlol_content,
			"category" => $coderlol_category,
			"color" => $coderlol_color,
			"font_size" => $coderlol_font_size,
			"note_rotation" => $coderlol_note_rotation,
			"grad" => $coderlol_grad,
			"grad_color" => $coderlol_grad_color,
			"grad_position" => $coderlol_grad_position,
			"update_date" => ''
		);


		$curr_date_object = new DateTime();
		//$curent_date = $curr_date_object->format('d.m.Y');

		echo generate_note_preview($note_atts, $curr_date_object);

		coderlol_info_box_ui_subpage_0($coderlol_title, $coderlol_content, $coderlol_category, $coderlol_color_transfer, $coderlol_font_size, $coderlol_note_rotation, $coderlol_grad, $coderlol_grad_color, $coderlol_grad_position, '0','','');



	}
/**

PREVIEW BUTTON EVENT END

*/

	if ( isset($_POST['coderlol_create_info_box_btn']) )
	{

		//$color_prefix = '#';

		$coderlol_title = $_POST['coderlol_info_box_title'];
		$coderlol_content = stripslashes($_POST['coderlol_info_box_content']);
		$coderlol_title_height = $_POST['coderlol_info_box_fontsize'];
		$coderlol_title_img = $_POST['url_info_box_title_bg'];

		$coderlol_title_color = $color_prefix.$_POST['coderlol_info_box_title_color'];
		$coderlol_title_color_grad = $color_prefix.$_POST['coderlol_info_box_title_color_grad'];
				
					
		$coderlol_title_color_grad_pos = $_POST['coderlol_info_box_title_grad_position'];
					
		
		$coderlol_content_img = $_POST['url_info_box_content_bg'];

		$coderlol_content_color = $color_prefix.$_POST['coderlol_info_box_content_color'];
		$coderlol_content_color_grad = $color_prefix.$_POST['coderlol_info_box_content_color_grad'];
		
		
		$coderlol_content_color_grad_pos = $_POST['coderlol_info_box_content_grad_position'];


		if ($coderlol_title_color_grad_pos == '') { $coderlol_title_color_grad = ''; }

		if ($coderlol_content_color_grad_pos == '') { $coderlol_content_color_grad = ''; }

		$wpdb->insert
					(
						$table_info_box,
						array(	'title' => $coderlol_title,
								'content' => $coderlol_content,
								'heightTitle' => $coderlol_title_height,

								'titleImgUrl' => $coderlol_title_img,
								'colorTitle' => $coderlol_title_color,
								'gradColorTitle' => $coderlol_title_color_grad,
								'gradPositionTitle' => $coderlol_title_color_grad_pos, 

								'contentImgUrl' => $coderlol_content_img,
								'colorContent' => $coderlol_content_color,
								'gradColorContent' => $coderlol_content_color_grad,
								'gradPositionContent' => $coderlol_content_color_grad_pos)
					);

		update_option('coderlol_last_box', mysql_insert_id());


		/*$info_box_template = create_info_box_template();
		$fp = fopen( INFOBOX_ABSPATH . 'template_info_box.html','w+');
		$test = fwrite($fp, $info_box_template);
		fclose($fp);
		*/

		//if ($test) echo 'success create new note<br>';
		//else echo 'failed create new note<br>';
		


		//echo $note_desk_template;
		//note_desk_publishing($template);
		/*$fp = fopen('js/template.html', 'r');
		if ($fp)
		{
			while(!feof($fp))
			{
				$mytext = fgets($fp, 999);
				echo $mytext;
			}
		}
		else echo 'fail';
		fclose($fp);*/


	}

	/*$note_desk_template = create_note_desk_template();
	$fp = fopen( NOTEDESK_ABSPATH . 'template.html','w+');
	$test = fwrite($fp, $note_desk_template);

	//if ($test) echo 'success load database<br>';
	//else echo 'failed load database<br>';
	fclose($fp);
	*/


	if ($preview == 'false' ) { coderlol_info_box_ui_subpage_0('','','100','E6E6E6','', '', '', 'E6E6E6', '', '','','0'); }

		

}


function coderlol_info_box_option_subpage_2() {

	global $wpdb;
	$table_info_box = $wpdb->prefix . "coderlol_info_box";

	if ( isset($_POST['coderlol_update_box_btn']))
	{
		$box_id = $_POST['coderlol_get_box'];
		update_option('coderlol_last_mod_box', $box_id);
		$result_row = mysql_query("SELECT * FROM ".$table_info_box." WHERE id=".$box_id);
		$res = mysql_fetch_array($result_row, MYSQL_ASSOC);

		coderlol_info_box_ui_subpage_0($res['title'], $res['content'], $res['heightTitle'], $res['colorTitle'], $res['gradColorTitle'], $res['gradPositionTitle'], $res['titleImgUrl'], $res['colorContent'], $res['gradColorContent'], $res['gradPositionContent'], $res['contentImgUrl'], '1');

	}
	elseif ( isset($_POST['coderlol_create_info_box_btn']) )
	{
		$coderlol_title = $_POST['coderlol_info_box_title'];
		$coderlol_content = stripslashes($_POST['coderlol_info_box_content']);
		$coderlol_title_height = $_POST['coderlol_info_box_fontsize'];
		$coderlol_title_img = $_POST['url_info_box_title_bg'];

		$coderlol_title_color = $color_prefix.$_POST['coderlol_info_box_title_color'];
		$coderlol_title_color_grad = $color_prefix.$_POST['coderlol_info_box_title_color_grad'];
				
					
		$coderlol_title_color_grad_pos = $_POST['coderlol_info_box_title_grad_position'];
					
		
		$coderlol_content_img = $_POST['url_info_box_content_bg'];

		$coderlol_content_color = $color_prefix.$_POST['coderlol_info_box_content_color'];
		$coderlol_content_color_grad = $color_prefix.$_POST['coderlol_info_box_content_color_grad'];
		
		
		$coderlol_content_color_grad_pos = $_POST['coderlol_info_box_content_grad_position'];

		//echo $coderlol_title_img;

		if ($coderlol_title_color_grad_pos == '') { $coderlol_title_color_grad = ''; }

		if ($coderlol_content_color_grad_pos == '') { $coderlol_content_color_grad = ''; }

		$wpdb->update
					(
						$table_info_box,

						array(	'title' => $coderlol_title,
								'content' => $coderlol_content,
								'heightTitle' => $coderlol_title_height,

								'titleImgUrl' => $coderlol_title_img,
								'colorTitle' => $coderlol_title_color,
								'gradColorTitle' => $coderlol_title_color_grad,
								'gradPositionTitle' => $coderlol_title_color_grad_pos, 

								'contentImgUrl' => $coderlol_content_img,
								'colorContent' => $coderlol_content_color,
								'gradColorContent' => $coderlol_content_color_grad,
								'gradPositionContent' => $coderlol_content_color_grad_pos
							),

						array(	
								'ID' => get_option('coderlol_last_mod_box') 
							)
					);

		coderlol_info_box_ui_subpage_2();
	}
	else
	{
		coderlol_info_box_ui_subpage_2();
	}
}



/*****************************************************************/

/* CREATE UI FOR MAIN ADMIN PAGE
/* TinyMCE editor settings
****************************************************************/
/*******************************************************SETTINGS PAGE FOR CREATE NOTE***********************************/
/**

UI SUBPAGE CREATE NOTE
*/
function coderlol_info_box_ui_subpage_0($title, $content_box, $heightTitle, $colorTitle, $gradColorTitle, $gradPositionTitle, $titleImgUrl, $colorContent, $gradColorContent, $gradPositionContent, $contentImgUrl, $update)
{
$settings = array ('convert_urls' => true, 'relative_urls' => false, 'remove_script_host' => false, 'document_base_url' => 'base_path()', 'forced_root_block' => 'br');
$editor_id = 'coderlol_info_box_content';

if ($update == '1')
{
	$action = '?page=change_infobox&updated_box=true';
	$formaction = '?page=change_infobox&preview_box=true';
	$last_box = get_option('coderlol_last_mod_box');
}
elseif ($update == '2')
{
	//reserved
}
elseif ($update == '0')
{
	$action = '?page=infobox&created_box=true';
	$formaction = '?page=infobox&preview_box=true';
	$last_box = get_option('coderlol_last_box');
	$last_box = $last_box+1;
}
?>
	<h2>Create a Box</h2>
	<p>Автор плагина: <a href="https://www.vk.com/coderlol">Поляков Иван</a>
	<div id='coderlol_commondesk_subpage_0'>
	<form id='coderlol-create-info-box' name="coderlol_create-info-box" method="post" action='<?php echo $action ?>' >
		<hr noshade size="3"></hr>
		<label><h3>Шорткод:</h3></label>
			<p>					
				<input  type='text' class='coderlol-note-text' value='[coderlol_info_box id=<?php echo $last_box ?> /]' disabled>
			</p>
		<hr noshade size="3"></hr>
		<label><h3>Заголовок блока:</h3></label>
			<p>					
				<input id='coderlol_info_box_title' name='coderlol_info_box_title' type='text' class='coderlol-note-text' value=<?php echo "'".$title."'" ?>>
			</p>
		<hr noshade size="3"></hr>
		<label><h3>Содержимое:</h3></label>
			<div style="width: 50%">
			<?php 	/*<p>					
					<textarea id='coderlol_content' name='coderlol_content' type='text' class='coderlol-note-textarea'></textarea>
					</p>*/
					$content = $content_box;
					wp_editor( $content, $editor_id, $settings);
			?>
			</div>
		<label><h3>Высота блока заголовка:</h3></label>
    		<p>
    			<input id='coderlol_info_box_fontsize' type='number' name='coderlol_info_box_fontsize' min='100' max='500' value=<?php echo "'".$heightTitle."'" ?> class='coderlol-note-text'>
    		</p>
		<hr noshade size="3"></hr>
    	<label><h3>Блок заголовка:</h3></label>
    		<p>
    			<label><h4>Изображение:</h4></label>
    			<input type="text" id='url_info_box_title_bg' name='url_info_box_title_bg' style='width: 100%; margin-bottom: 10px;' value=<?php echo "'".$titleImgUrl."'" ?> >
				<input value='Выбрать изображение или загрузить новое' id='upload_image_url_info_box' type='button' class='button button-primary upload-btn'>
				<label><h4>Или укажите цвет: </h4></label>
    			<input id='coderlol_info_box_title_color' name='coderlol_info_box_title_color' class='jscolor' style='width: 50%' value=<?php echo "'".$colorTitle."'" ?>>
    			<input id='coderlol_info_box_title_color_grad' name='coderlol_info_box_title_color_grad' class='jscolor' value=<?php echo "'".$gradColorTitle."'" ?> >
    			<select id='coderlol_info_box_title_grad_position' name='coderlol_info_box_title_grad_position' type='text' style='visibility: hidden; position: absolute;' >
    				<option value="" <?php if ($gradPositionTitle==NULL) echo 'selected' ?> >Choose position</option>
    				<option value="to top" <?php if ($gradPositionTitle=="to top") echo 'selected' ?> >Снизу вверх</option>
    				<option value="to left" <?php if ($gradPositionTitle=="to left") echo 'selected' ?> >Справа налево</option>
    				<option value="to bottom" <?php if ($gradPositionTitle=="to bottom") echo 'selected' ?> >Сверху вниз</option>
    				<option value="to right" <?php if ($gradPositionTitle=="to right") echo 'selected' ?> >Слева направо</option>
    				<option value="to top left" <?php if ($gradPositionTitle=="to top left") echo 'selected' ?> >От правого нижнего угла к левому верхнему</option>
    				<option value="to top right" <?php if ($gradPositionTitle=="to top right") echo 'selected' ?> >От левого нижнего угла к правому верхнему</option>
    				<option value="to bottom left" <?php if ($gradPositionTitle=="to bottom left") echo 'selected' ?> >От правого верхнего угла к левому нижнему</option>
    				<option value="to bottom right" <?php if ($gradPositionTitle=="to bottom right") echo 'selected' ?> >От левого верхнего угла к правому нижнему</option>
    			</select>
    		</p>
    		<p>
    			<input id='grad_info_box_title' name='grad_info_box_title' type="checkbox" <?php if ($gradColorTitle != NULL) echo "checked"; ?> >
    			Градиент
    		</p>
    	<hr noshade size="3"></hr>
    	<label><h3>Блок контента:</h3></label>
    		<p>
    			<label><h4>Изображение:</h4></label>
    			<input type="text" id='url_info_box_content_bg' name='url_info_box_content_bg' style='width: 100%; margin-bottom: 10px;' value=<?php echo "'".$contentImgUrl."'" ?> >
				<input value='Выбрать изображение или загрузить новое' id='upload_image_info_box' type='button' class='button button-primary upload-btn'>
				<label><h4>Или укажите цвет: </h4></label>
    			<input id='coderlol_info_box_content_color' name='coderlol_info_box_content_color' class='jscolor' style='width: 50%' value=<?php echo "'".$colorContent."'" ?>>
    			<input id='coderlol_info_box_content_color_grad' name='coderlol_info_box_content_color_grad' class='jscolor' value=<?php echo "'".$gradColorContent."'" ?> >
    			<select id='coderlol_info_box_content_grad_position' name='coderlol_info_box_content_grad_position' type='text' style='visibility: hidden; position: absolute;' >
    				<option value="" <?php if ($gradPositionContent==NULL) echo 'selected' ?> >Choose position</option>
    				<option value="to top" <?php if ($gradPositionContent=="to top") echo 'selected' ?> >Снизу вверх</option>
    				<option value="to left" <?php if ($gradPositionContent=="to left") echo 'selected' ?> >Справа налево</option>
    				<option value="to bottom" <?php if ($gradPositionContent=="to bottom") echo 'selected' ?> >Сверху вниз</option>
    				<option value="to right" <?php if ($gradPositionContent=="to right") echo 'selected' ?> >Слева направо</option>
    				<option value="to top left" <?php if ($gradPositionContent=="to top left") echo 'selected' ?> >От правого нижнего угла к левому верхнему</option>
    				<option value="to top right" <?php if ($gradPositionContent=="to top right") echo 'selected' ?> >От левого нижнего угла к правому верхнему</option>
    				<option value="to bottom left" <?php if ($gradPositionContent=="to bottom left") echo 'selected' ?> >От правого верхнего угла к левому нижнему</option>
    				<option value="to bottom right" <?php if ($gradPositionContent=="to bottom right") echo 'selected' ?> >От левого верхнего угла к правому нижнему</option>
    			</select>
    		</p>
    		<p>
    			<input id='grad_info_box_content' name='grad_info_box_content' type="checkbox" <?php if ($gradColorContent != NULL) echo "checked"; ?> >
    			Градиент
    		</p>
    		<p id='grad_ops'></p>
    		<hr noshade size="3"></hr>
			<p>
				<input id='coderlol_create_info_box_btn' name='coderlol_create_info_box_btn' type='submit' class='coderlol-create-note-btn' value='Сохранить блок'>
			</p>
			<!--
			<p>
				<input id='coderlol_preview_info_box_btn' name='coderlol_preview_info_box_btn' type='submit' class='coderlol-preview-note-btn' value='Предпросмотр блока' formaction='<?php echo $formaction ?>'>
			</p>
			-->
	</form>

	</div>
<?php
	if ($update != '0')
	{
		//coderlol_ui_subpage_2_1_embadded();
	}
}



/*******************************************************SETTINGS PAGE FOR CHANGING BOX***********************************/

function coderlol_info_box_ui_subpage_2()
{
	$settings = array ('convert_urls' => true, 'relative_urls' => false, 'remove_script_host' => false, 'document_base_url' => 'base_path()');
	$editor_id = 'coderlol_content';
	global $wpdb;
	$table_info_box = $wpdb->prefix . "coderlol_info_box";
	//$result = mysql_query("SELECT title FROM wp_coderlol_notes");
	$result = mysql_query("SELECT id, title FROM ".$table_info_box." ORDER BY id DESC");
	
?>
	<h2>Change a Box</h2>
	<p>Автор плагина: <a href="https://www.vk.com/coderlol">Поляков Иван</a>
	<div>
	<form id='coderlol_update_box' name='coderlol_update_box' method='post' action='?page=change_infobox'>
		<label><h3>Выберите блок по заголовку:</h3></label>
		<p>
		<select id='coderlol_get_box' name='coderlol_get_box' type='text' class='coderlol-note-select-btn-settings' size="3">
			<?php
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

					$box_title_value = $row['title'];
					
					echo("<option value='".$row['id']."'>".$row['id'].".  ".$box_title_value."  [coderlol_info_box id=".$row['id']." /]</option>");
				}
			?>
		</select>
		</p>
		<p>
			<input id='coderlol_update_box_btn' name='coderlol_update_box_btn' type='submit' class='coderlol-create-note-btn' value='Изменить блок'>
		</p>
		<!--
		<p>
			<input id='coderlol_delete_note_btn' name='coderlol_delete_note_btn' type='submit' class='coderlol-delete-note-btn' value='Удалить заметку' formaction='?page=commondesk_change_note&deleted=true'>
		</p>
		-->
	</form> 
	
	</div>
<?php
	//coderlol_ui_subpage_2_1();
}



function create_info_box_template($id)
{
	global $wpdb;

	$table_info_box = $wpdb->prefix . "coderlol_info_box";

	$color_prefix = '#';

	$result_array = mysql_query("SELECT * FROM ".$table_info_box." WHERE id=".$id);

	$result = mysql_fetch_array($result_array, MYSQL_ASSOC);


	/**
		TITLE
	*/

	if ( ($result['titleImgUrl'] == null) and ($result['gradColorTitle'] == null) )
	{
		$curr_title_style = "background-color: ".$color_prefix.$result['colorTitle']."; ";
	}
	elseif ( ($result['titleImgUrl'] == null) and ($result['gradColorTitle'] != null) )
	{
		$curr_title_style = "background: linear-gradient(".$result['gradPositionTitle'].", ".$color_prefix.$result['colorTitle'].", ".$color_prefix.$result['gradColorTitle']."); ";
	}
	else 
	{
		$curr_title_style = "background-image: url(".$result['titleImgUrl']."); ";
	}

	$curr_title_style = $curr_title_style."height: ".$result['heightTitle']."px; ";

	/**
		CONTENT
	*/

	if ( ($result['contentImgUrl'] == null) and ($result['gradColorContent'] == null) )
	{
		$curr_content_style = "background-color: ".$color_prefix.$result['colorContent']."; ";
	}
	elseif ( ($result['contentImgUrl'] == null) and ($result['gradColorContent'] != null) )
	{
		$curr_content_style = "background: linear-gradient(".$result['gradPositionContent'].", ".$color_prefix.$result['colorContent'].", ".$color_prefix.$result['gradColorContent']."); ";
	}
	else 
	{
		$curr_content_style = "background-image: url(".$result['contentImgUrl']."); ";
	}

	$template = '<div class="coderlol-info-box"><div class="coderlol-info-box-title" style="'.$curr_title_style.'"><div class="coderlol-new-title-box">' . $result['title'] . '</div></div><div class="coderlol-info-box-content" style="'.$curr_content_style.'">' .info_box_auto_br(do_shortcode($result['content'])).'</div></div>';

	return $template;

}





function info_box_auto_br( $pee, $br = true ) {
	$pre_tags = array();

	if ( trim($pee) === '' )
		return '';

	// Just to make things a little easier, pad the end.
	$pee = $pee . "\n";

	/*
	 * Pre tags shouldn't be touched by autop.
	 * Replace pre tags with placeholders and bring them back after autop.
	 */
	if ( strpos($pee, '<pre') !== false ) {
		$pee_parts = explode( '</pre>', $pee );
		$last_pee = array_pop($pee_parts);
		$pee = '';
		$i = 0;

		foreach ( $pee_parts as $pee_part ) {
			$start = strpos($pee_part, '<pre');

			// Malformed html?
			if ( $start === false ) {
				$pee .= $pee_part;
				continue;
			}

			$name = "<pre wp-pre-tag-$i></pre>";
			$pre_tags[$name] = substr( $pee_part, $start ) . '</pre>';

			$pee .= substr( $pee_part, 0, $start ) . $name;
			$i++;
		}

		$pee .= $last_pee;
	}
	// Change multiple <br>s into two line breaks, which will turn into paragraphs.
	$pee = preg_replace('|<br\s*/?>\s*<br\s*/?>|', "\n\n", $pee);

	$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';

	// Add a single line break above block-level opening tags.
	$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);

	// Add a double line break below block-level closing tags.
	$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);

	// Standardize newline characters to "\n".
	$pee = str_replace(array("\r\n", "\r"), "\n", $pee);

	// Find newlines in all elements and add placeholders.
	$pee = wp_replace_in_html_tags( $pee, array( "\n" => " <!-- wpnl --> " ) );

	// Collapse line breaks before and after <option> elements so they don't get autop'd.
	if ( strpos( $pee, '<option' ) !== false ) {
		$pee = preg_replace( '|\s*<option|', '<option', $pee );
		$pee = preg_replace( '|</option>\s*|', '</option>', $pee );
	}

	/*
	 * Collapse line breaks inside <object> elements, before <param> and <embed> elements
	 * so they don't get autop'd.
	 */
	if ( strpos( $pee, '</object>' ) !== false ) {
		$pee = preg_replace( '|(<object[^>]*>)\s*|', '$1', $pee );
		$pee = preg_replace( '|\s*</object>|', '</object>', $pee );
		$pee = preg_replace( '%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee );
	}

	/*
	 * Collapse line breaks inside <audio> and <video> elements,
	 * before and after <source> and <track> elements.
	 */
	if ( strpos( $pee, '<source' ) !== false || strpos( $pee, '<track' ) !== false ) {
		$pee = preg_replace( '%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee );
		$pee = preg_replace( '%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee );
		$pee = preg_replace( '%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee );
	}

	// Remove more than two contiguous line breaks.
	$pee = preg_replace("/\n\n+/", "\n\n", $pee);

	// Split up the contents into an array of strings, separated by double line breaks.
	$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);

	// Reset $pee prior to rebuilding.
	$pee = '';

	// Rebuild the content as a string, wrapping every bit with a <p>.
	foreach ( $pees as $tinkle ) {
		$pee .= '' . trim($tinkle, "\n") . "\n";
	}

	// Under certain strange conditions it could create a P of entirely whitespace.
	$pee = preg_replace('|<p>\s*</p>|', '', $pee);

	// Add a closing <p> inside <div>, <address>, or <form> tag if missing.
	$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);

	// If an opening or closing block element tag is wrapped in a <p>, unwrap it.
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);

	// In some cases <li> may get wrapped in <p>, fix them.
	$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee);

	// If a <blockquote> is wrapped with a <p>, move it inside the <blockquote>.
	$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
	$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);

	// If an opening or closing block element tag is preceded by an opening <p> tag, remove it.
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);

	// If an opening or closing block element tag is followed by a closing <p> tag, remove it.
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);

	// Optionally insert line breaks.
	if ( $br ) {
		// Replace newlines that shouldn't be touched with a placeholder.
		$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee);

		// Normalize <br>
		$pee = str_replace( array( '<br>', '<br/>' ), '<br />', $pee );

		// Replace any new line characters that aren't preceded by a <br /> with a <br />.
		$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee);

		// Replace newline placeholders with newlines.
		$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
	}

	// If a <br /> tag is after an opening or closing block tag, remove it.
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);

	// If a <br /> tag is before a subset of opening or closing block tags, remove it.
	$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
	$pee = preg_replace( "|\n</p>$|", '</p>', $pee );

	// Replace placeholder <pre> tags with their original content.
	if ( !empty($pre_tags) )
		$pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);

	// Restore newlines in all elements.
	if ( false !== strpos( $pee, '<!-- wpnl -->' ) ) {
		$pee = str_replace( array( ' <!-- wpnl --> ', '<!-- wpnl -->' ), "\n", $pee );
	}

	return $pee;
}


/***************************SHORTCODE FOR DESK***************************/
function coderlol_info_box( $atts) {

	extract( shortcode_atts( array(
		'id' => '',
	), $atts ) );
	//$template = create_note_desk_template();

	return create_info_box_template($id);
}
/***************************SHORTCODE FOR DESK***************************/

function info_box_install() {	

	global $wpdb;

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	$table_info_box = $wpdb->prefix . 'coderlol_info_box';

	$sql =
	"
		CREATE TABLE IF NOT EXISTS " .$table_info_box. " (
			`id` INT(11) NOT NULL AUTO_INCREMENT,
			`title` VARCHAR(64) NULL DEFAULT NULL,
			`content` LONGTEXT NULL,
			`fontSize` CHAR(2) NOT NULL DEFAULT '20',
			`colorTitle` CHAR(6) NOT NULL DEFAULT 'FFFFFF',
			`gradColorTitle` CHAR(6) NULL DEFAULT NULL,
			`gradPositionTitle` CHAR(20) NULL DEFAULT NULL,
			`titleImgUrl` CHAR(200) NULL DEFAULT NULL,
			`colorContent` CHAR(6) NOT NULL DEFAULT 'FFFFFF',
			`gradColorContent` CHAR(6) NULL DEFAULT NULL,
			`gradPositionContent` CHAR(20) NULL DEFAULT NULL,
			`contentImgUrl` VARCHAR(200) NULL DEFAULT NULL,
			PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;

	";

	dbDelta($sql);

	add_option('coderlol_last_box', '');
	add_option('coderlol_last_mod_box', '');

}

function info_box_uninstall() {

	global $wpdb;

	$table_notes = $wpdb->prefix . 'coderlol_notes';

	$sql = 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'coderlol_info_box';

	//$wpdb->query($sql);
	
	remove_shortcode('coderlol_info_box');
}

function register_info_box_admin_styles_scripts() {

	/*STYLES*/
	wp_register_style( 'coderlol-info-box-admin', plugin_dir_url(__FILE__) .'css/info_box_admin.css' );
	wp_enqueue_style( 'coderlol-info-box-style-admin' );

	/*FOR PREVIEW*/
	wp_register_style( 'coderlol-info-box-style', plugin_dir_url(__FILE__) .'css/info_box.css' );
	wp_enqueue_style( 'coderlol-info-box-style' );

	wp_enqueue_style('thickbox');
	/*SCRIPTS*/
	wp_register_script('coderlol-info-box-script-admin', plugin_dir_url(__FILE__) .'js/info_box_admin.js' );
	wp_enqueue_script( 'coderlol-info-box-script-admin', array('jquery'));

	wp_register_script('jscolor-info-box', plugin_dir_url(__FILE__) .'js/jscolor.js' );
	wp_enqueue_script( 'jscolor-info-box');

	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');

}

function register_info_box_styles_scripts() {

	/*STYLES*/
	wp_register_style( 'info-box-style', plugin_dir_url(__FILE__) .'css/info_box.css' );
	wp_enqueue_style( 'info-box-style' );
	/*SCRIPTS*/
	wp_register_script('info-box-script', plugin_dir_url(__FILE__) .'js/info_box.js' );
	wp_enqueue_script( 'info-box-script', array('jquery'));
}

/*
function success_creating_note() {
	if( isset($_GET['created']) ) 
	{
		if($_GET['created'] == 'true' ) 
		{
	?>
			<div class="notice notice-success is-dismissible">
				<p><h2>БЛОК УСПЕШНО СОЗДАН</h2></p>
			</div>
	<?php
		} else {

		}
	}
}


function success_updating_note() {
	if( isset($_GET['updated']) ) 
	{
		if($_GET['updated'] == 'true' ) 
		{
	?>
			<div class="notice notice-info is-dismissible">
				<p><h2>БЛОК УСПЕШНО ОБНОВЛЕН</h2></p>
			</div>
	<?php
		} else {

		}
	}

	if( isset($_GET['desk_updated']) ) 
	{
		if($_GET['desk_updated'] == 'true' ) 
		{
	?>
			<div class="notice notice-info is-dismissible">
				<p><h2>НАСТРОЙКИ ДОСКИ УСПЕШНО ОБНОВЛЕНЫ</h2></p>
			</div>
	<?php
		} else {

		}
	}

	if( isset($_GET['preview']) ) 
	{
		if($_GET['preview'] == 'true' ) 
		{
	?>
			<div class="notice notice-info is-dismissible">
				<p><h2>ПРЕДПРОСМОТР</h2></p>
			</div>
	<?php
		} else {

		}
	}

}

function success_deleting_note() {
	if( isset($_GET['deleted']) ) 
	{
		if($_GET['deleted'] == 'true' ) 
		{
	?>
			<div class="notice notice-error is-dismissible">
				<p><h2>БЛОК УСПЕШНО УДАЛЕН</h2></p>
			</div>
	<?php
		} else {

		}
	}
}
*/

register_activation_hook(__FILE__, 'info_box_install');
register_deactivation_hook(__FILE__,'info_box_uninstall');

add_action('wp_enqueue_scripts', 'register_info_box_styles_scripts');
add_action('admin_enqueue_scripts','register_info_box_admin_styles_scripts');
add_action('admin_menu', 'coderlol_info_box_add_admin_pages');


/*
add_action('admin_notices','success_creating_note');
add_action('admin_notices','success_deleting_note');
add_action('admin_notices','success_updating_note');
*/

add_filter( 'the_content', 'do_shortcode', 11);

add_shortcode( 'coderlol_info_box', 'coderlol_info_box');


?>
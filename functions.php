<?php
/* 
Author: William Paceley
Theme: Gig Service
*/

//disable the admin bar
show_admin_bar(false);

//!----This sets the expiration date by using a Gravity Forms Hook-----!

function after_gig_submit($entry){
	$post_id = $entry["post_id"];
	
	$date = get_post_meta( $post_id, 'Date', true );
	
	set_expiration($post_id, $date);
}

function set_expiration($id, $date) {

	// 'm/d/Y' is the format of my GF date field
    $formatted_date = DateTime::createFromFormat('m/d/Y', $date);

    $month	 = intval($formatted_date->format('m'));
    $day 	 = intval($formatted_date->format('d'));
    $year 	 = intval($formatted_date->format('y'));

	//Manually set post to expire at the end of the day.
    $hour 	 = 23;
    $minute  = 59;

    $ts = get_gmt_from_date("$year-$month-$day $hour:$minute:0",'U');
	
	$opts = array(
		'expireType' => 'draft',
		'id' => $id
	);

    _scheduleExpiratorEvent($id, $ts, $opts);
}

//Add the action hooks for each form that can post gigs
add_action('gform_after_submission_1', 'after_gig_submit', 1);
add_action('gform_after_submission_4', 'after_gig_submit', 1);
add_action('gform_after_submission_5', 'after_gig_submit', 1);

//!-----Gravity Forms - Dynamic Population-----!

//Student Email
add_filter( 'gform_field_value_student_email', 'populate_email' );
//Current User Email
add_filter( 'gform_field_value_user_email', 'populate_email' );
//Author Email
add_filter('gform_field_value_author_email', 'populate_post_author_email');
//Client Email
add_filter('gform_field_value_client_email', 'populate_client_email');
//First name
add_filter( 'gform_field_value_student_first', 'populate_first_name' );
//Last name
add_filter( 'gform_field_value_student_last', 'populate_last_name' );
//Post title
add_filter( 'gform_field_value_post_title', 'populate_post_title' );

function populate_email(){
	if ( is_user_logged_in() ) {
 		global $userdata;
		return $userdata->user_email;
	}
}

function populate_first_name(){
	if ( is_user_logged_in() ) {
 		global $userdata;
		return $userdata->first_name;
	}
}

function populate_last_name(){
	if ( is_user_logged_in() ) {
 		global $userdata;
		return $userdata->last_name;
	}
}

function populate_post_author_email($value){
    global $post;

    $author_email = get_the_author_meta('email', $post->post_author);

    return $author_email;
}

function populate_client_email() {
	global $post;
	
	$client_email = get_post_meta( $post->ID, 'Client Email', true );
	
	return $client_email;
}

function populate_post_title() {
	global $post;
	
	$post_title = get_the_title($post->ID);
	
	return $post_title;
}

//function to print 'delete' (read: draft) button
function show_delete_button(){
	Global $post;
	//only print if client or admin
	if (current_user_can('edit_published_posts')){
	echo '
		<form action="" method="POST" name="front_end_publish" onsubmit="return confirm(\'Are you sure you want to delete this gig?\');"><input id="pid" type="hidden" name="pid" value="'.$post->ID.'" />
		<input id="FE_PUBLISH" type="hidden" name="FE_PUBLISH" value="FE_PUBLISH" />
		<input id="submit" type="submit" name="submit" value="Delete"/></form>';
	}
}

//function to update post status
function change_post_status($post_id,$status){
	$current_post = get_post( $post_id, 'ARRAY_A' );
	$current_post['post_status'] = $status;
	wp_update_post($current_post);
}

if (isset($_POST['FE_PUBLISH']) && $_POST['FE_PUBLISH'] == 'FE_PUBLISH'){
	if (isset($_POST['pid']) && !empty($_POST['pid'])){
		change_post_status((int)$_POST['pid'],'draft');
	}
}

//Pre-written code from Gravity Wiz to allow GF post preview
/**
* Better Pre-submission Confirmation
* http://gravitywiz.com/2012/08/04/better-pre-submission-confirmation/
*/

class GWPreviewConfirmation {

    private static $lead;

    function init() {

        add_filter('gform_pre_render', array('GWPreviewConfirmation', 'replace_merge_tags'));
        add_filter('gform_replace_merge_tags', array('GWPreviewConfirmation', 'product_summary_merge_tag'), 10, 3);

    }

    public static function replace_merge_tags($form) {

        $current_page = isset(GFFormDisplay::$submission[$form['id']]) ? GFFormDisplay::$submission[$form['id']]['page_number'] : 1;
        $fields = array();

        // get all HTML fields on the current page
        foreach($form['fields'] as &$field) {

            // skip all fields on the first page
            if(rgar($field, 'pageNumber') <= 1)
                continue;

            $default_value = rgar($field, 'defaultValue');
            preg_match_all('/{.+}/', $default_value, $matches, PREG_SET_ORDER);
            if(!empty($matches)) {
                // if default value needs to be replaced but is not on current page, wait until on the current page to replace it
                if(rgar($field, 'pageNumber') != $current_page) {
                    $field['defaultValue'] = '';
                } else {
                    $field['defaultValue'] = self::preview_replace_variables($default_value, $form);
                }
            }

            // only run 'content' filter for fields on the current page
            if(rgar($field, 'pageNumber') != $current_page)
                continue;

            $html_content = rgar($field, 'content');
            preg_match_all('/{.+}/', $html_content, $matches, PREG_SET_ORDER);
            if(!empty($matches)) {
                $field['content'] = self::preview_replace_variables($html_content, $form);
            }

        }

        return $form;
    }

    /**
    * Adds special support for file upload, post image and multi input merge tags.
    */
    public static function preview_special_merge_tags($value, $input_id, $merge_tag, $field) {
        
        // added to prevent overriding :noadmin filter (and other filters that remove fields)
        if( !$value )
            return $value;
        
        $input_type = RGFormsModel::get_input_type($field);
        
        $is_upload_field = in_array( $input_type, array('post_image', 'fileupload') );
        $is_multi_input = is_array( rgar($field, 'inputs') );
        $is_input = intval( $input_id ) != $input_id;
        
        if( !$is_upload_field && !$is_multi_input )
            return $value;

        // if is individual input of multi-input field, return just that input value
        if( $is_input )
            return $value;
            
        $form = RGFormsModel::get_form_meta($field['formId']);
        $lead = self::create_lead($form);
        $currency = GFCommon::get_currency();

        if(is_array(rgar($field, 'inputs'))) {
            $value = RGFormsModel::get_lead_field_value($lead, $field);
            return GFCommon::get_lead_field_display($field, $value, $currency);
        }

        switch($input_type) {
        case 'fileupload':
            $value = self::preview_image_value("input_{$field['id']}", $field, $form, $lead);
            $value = self::preview_image_display($field, $form, $value);
            break;
        default:
            $value = self::preview_image_value("input_{$field['id']}", $field, $form, $lead);
            $value = GFCommon::get_lead_field_display($field, $value, $currency);
            break;
        }

        return $value;
    }

    public static function preview_image_value($input_name, $field, $form, $lead) {

        $field_id = $field['id'];
        $file_info = RGFormsModel::get_temp_filename($form['id'], $input_name);
        $source = RGFormsModel::get_upload_url($form['id']) . "/tmp/" . $file_info["temp_filename"];

        if(!$file_info)
            return '';

        switch(RGFormsModel::get_input_type($field)){

            case "post_image":
                list(,$image_title, $image_caption, $image_description) = explode("|:|", $lead[$field['id']]);
                $value = !empty($source) ? $source . "|:|" . $image_title . "|:|" . $image_caption . "|:|" . $image_description : "";
                break;

            case "fileupload" :
                $value = $source;
                break;

        }

        return $value;
    }

    public static function preview_image_display($field, $form, $value) {

        // need to get the tmp $file_info to retrieve real uploaded filename, otherwise will display ugly tmp name
        $input_name = "input_" . str_replace('.', '_', $field['id']);
        $file_info = RGFormsModel::get_temp_filename($form['id'], $input_name);

        $file_path = $value;
        if(!empty($file_path)){
            $file_path = esc_attr(str_replace(" ", "%20", $file_path));
            $value = "<a href='$file_path' target='_blank' title='" . __("Click to view", "gravityforms") . "'>" . $file_info['uploaded_filename'] . "</a>";
        }
        return $value;

    }

    /**
    * Retrieves $lead object from class if it has already been created; otherwise creates a new $lead object.
    */
    public static function create_lead( $form ) {
        
        if( empty( self::$lead ) ) {
            self::$lead = RGFormsModel::create_lead( $form );
            self::clear_field_value_cache( $form );
        }
        
        return self::$lead;
    }

    public static function preview_replace_variables($content, $form) {

        $lead = self::create_lead($form);

        // add filter that will handle getting temporary URLs for file uploads and post image fields (removed below)
        // beware, the RGFormsModel::create_lead() function also triggers the gform_merge_tag_filter at some point and will
        // result in an infinite loop if not called first above
        add_filter('gform_merge_tag_filter', array('GWPreviewConfirmation', 'preview_special_merge_tags'), 10, 4);

        $content = GFCommon::replace_variables($content, $form, $lead, false, false, false);

        // remove filter so this function is not applied after preview functionality is complete
        remove_filter('gform_merge_tag_filter', array('GWPreviewConfirmation', 'preview_special_merge_tags'));

        return $content;
    }

    public static function product_summary_merge_tag($text, $form, $lead) {

        if(empty($lead))
            $lead = self::create_lead($form);

        $remove = array("<tr bgcolor=\"#EAF2FA\">\n                            <td colspan=\"2\">\n                                <font style=\"font-family: sans-serif; font-size:12px;\"><strong>Order</strong></font>\n                            </td>\n                       </tr>\n                       <tr bgcolor=\"#FFFFFF\">\n                            <td width=\"20\">&nbsp;</td>\n                            <td>\n                                ", "\n                            </td>\n                        </tr>");
        $product_summary = str_replace($remove, '', GFCommon::get_submitted_pricing_fields($form, $lead, 'html'));

        return str_replace('{product_summary}', $product_summary, $text);
    }
    
    public static function clear_field_value_cache( $form ) {
        
        if( ! class_exists( 'GFCache' ) )
            return;
            
        foreach( $form['fields'] as &$field ) {
            if( GFFormsModel::get_input_type( $field ) == 'total' )
                GFCache::delete( 'GFFormsModel::get_lead_field_value__' . $field['id'] );
        }
        
    }

}

GWPreviewConfirmation::init();

//Customize login message to be more intuitive for users
function custom_login_message() {
	$message = "<strong>Students</strong>: To register, please login below with your NetID and Password.<br /><br /> <strong>Clients </strong>: Looking for musicians? You can register <a href=\"http://www.esm.rochester.edu/iml/blog/register-client/\" style=\"text-decoration:none;\">here</a>.";
	return $message;
}

add_filter('login_message', 'custom_login_message');

//Adds custom ESM logo to login page
function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/site-login-logo.png);
			background-size: 283px 177px;
            padding-bottom: 5px;
			height: 177px;
			width: 283px;

        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

//Makes login ESM logo redirect to homepage (instead of wp.org)
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Your Site Name and Info';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

//This is used to enqueue any custom JS that we want to use.
function gigservice_scripts() {
	wp_enqueue_script( 'search', get_stylesheet_uri() . '/../js/search.js', array('jquery'), false );
}

add_action( 'wp_enqueue_scripts', 'gigservice_scripts' );
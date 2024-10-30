<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://personic.ai
 * @since      1.0.0
 *
 * @package    Facebook_Chatbot
 * @subpackage Facebook_Chatbot/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Facebook_Chatbot
 * @subpackage Facebook_Chatbot/admin
 * @author     personic <vivek@personic.ai>
 */
class Facebook_Chatbot_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Facebook_Chatbot_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Facebook_Chatbot_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/facebook-chatbot-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Facebook_Chatbot_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Facebook_Chatbot_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/facebook-chatbot-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function send_notification( $post_id ) {
	    $post     = get_post($post_id);
	    $post_url = get_permalink( $post_id );
	    $post_title = get_the_title( $post_id ); 
	    $type="image";
	    try{
	    	$image_url = wp_get_attachment_url(get_post_thumbnail_id($post_id));
	    	if($image_url=="0"){
	    		$type="text";
	    		$image_url="";	
	    	}
	    }catch(Exception $ex){
	    	$type="text";
	    	$image_url="";
	    }
	    $option = get_option('facebook-chatbot');
	    $url = 'http://personic.com/api/facebook/post';  
	    $post_data = array(
	         'link' => $post_url,
	         'title'=> $post_title,
	         'type'=> $type,
	         'autopost' => $option["autopost"], 
	         'image_url'=>$image_url,
	         'html'=>$post);
	    $result = wp_remote_post( $url, array( 'body' => $post_data ) );
	}

	/**
	* Register the administration menu for this plugin into the WordPress Dashboard menu.
	*
	* @since 1.0.0
	*/
	 
	public function add_plugin_admin_menu() {
		add_options_page( 'Chatbot for Facebook Options Settings', 'Chatbot for Facebook', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page'));
	}
	 
	/**
	* Add settings action link to the plugins page.
	*
	* @since 1.0.0
	*/
	 
	public function add_action_links( $links ) {
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
			'<a href="http://personic.com/wordpress/faq">' . __('FAQ', $this->plugin_name) . '</a>'
		);
		return array_merge( $settings_link, $links );
	}
	 
	/**
	* Render the settings page for this plugin.
	*
	* @since 1.0.0
	*/
	 
	public function display_plugin_setup_page() {
		include_once( 'partials/facebook-chatbot-admin-display.php' );
	}

	public function set_default_content( $content ) {
		$options = get_option("facebook-chatbot");
	    $content = '<table style="border: 1px solid #cccccc;">
			<tr>
			  <td style="width: 10%;border:none;"><a href="https://m.me/'.$options["fbid"].'"><img src="https://assets.materialup.com/uploads/78fac9bb-4db8-4b9d-ae0b-bcd8360ed88d/icon285x285.jpeg" height="38px"></a></td>
			  <td style="border:none;"><a href="https://m.me/'.$options["fbid"].'" style="text-decoration:none">Click here to get updates via Facebook Messenger</a></td>
			</tr>
			<tr>
			  <td style="width: 4%;border:none;"></td>
			  <td style="border:none;"><a style="font-size: 10px;float: left;margin-top: -3%;" href="http://personic.com">Powered by Personic</a></td>
			</tr>
		</table>';
	    return $content;
	}

	public function register_fbcb_settings() {
		//register our settings
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}


	public function validate($input) {
	    // All checkboxes inputs        
	    $valid = array();
	    //Quote title
	    $valid['name'] = (isset($input['name']) && !empty($input['name'])) ? $input['name'] : false;
	    $valid['website'] = (isset($input['website']) && !empty($input['website'])) ? $input['website'] : false;
	    $valid['email'] = (isset($input['email']) && !empty($input['email'])) ? $input['email'] : false;
	    $valid['autopost'] = (isset($input['autopost']) && !empty($input['autopost'])) ? 1 : 0;
	    $valid['widget_code'] = (isset($input['widget_code']) && !empty($input['widget_code'])) ? 1 : 0;
	    $valid['previous_post'] = (isset($input['previous_post']) && !empty($input['previous_post'])) ? 1 : 0;
	    $valid['error']="false";
	    //return 1;
	    $url = 'http://personic.com/wordpress/brand/create';  
	    $post_data = $valid; 
	    $result = wp_remote_post( $url, array( 'body' => $post_data ) );
	    $result = json_decode($result["body"], true);
	    if($result["success"]==true){
	    	if($result["account_exist"]=="false"){
	    		add_settings_error($this->plugin_name, 'success', "Please check your email inbox for login credential on http://personic.com", 'updated');
	    	}else if($result["account_exist"]=="true"){
	    		add_settings_error($this->plugin_name, 'success', "Account is successfully updated", 'updated');
	    	}
			add_action( 'admin_notices', 'my_error_notice' );
	    	$valid['fb_alreadyexist']= $result["fb_alreadyexist"];
	    	if($result["fb_alreadyexist"]=="false"){
	    		$valid['fbid']="Your account is setup or you haven't connected your facebook page with your blog";
	    	}else{
	    		$valid['fbid']= $result["fbid"];
	    		$this->send_data_backend();
	    	}
	    	return $valid;
		}else{
			$valid['error'] ="true";
			$valid['fb_alreadyexist']= $result["fb_alreadyexist"];
	        if($result["fb_alreadyexist"]=="false"){
	    		$valid['fbid']="Looks like, either your account is completely setuped or you not connected your facebook page with your blog";
	    	}else{
	    		$valid['fbid']= $result["fbid"];
	    		$this->send_data_backend();
	    	}
	        add_settings_error($this->plugin_name, 'message', "There are few issues in the form submissions:", 'error');
	        add_settings_error($this->plugin_name, 'getError', "*Errors:".$result["message"], 'error');
			return $valid;
		}
	}

	function send_data_backend(){
		$args = array(
			'post_type' => 'post',
			'order'=>'DESC',
			'posts_per_page' => 5,
			'date_query' => array(
				array(
					'after' => '-30 days',
					'column' => 'post_date',
				),
			),
			'paged' => 1
		);
		$recent_posts = get_posts( $args, ARRAY_A );
		
		foreach ( $recent_posts as $getpost ){
			// LOOP CONTENT HERE
			$post_id = $getpost->ID;
			$post     = $getpost;
		    $post_url = get_permalink( $post_id );
		    $post_title = get_the_title( $post_id ); 
		    $type="image";
		    try{
		    	$image_url = wp_get_attachment_url(get_post_thumbnail_id($post_id));
		    	if($image_url=="0"){
		    		$type="text";
		    		$image_url="";	
		    	}
		    }catch(Exception $ex){
		    	$type="text";
		    	$image_url="";
		    }
		    $option = get_option('facebook-chatbot');
		    $url = 'http://personic.com/api/facebook/post';  
		    $post_data = array(
		         'link' => $post_url,
		         'title'=> $post_title,
		         'type'=> $type,
		         'autopost' => $option["autopost"], 
		         'image_url'=>$image_url,
		         'prev_posted'=>"true",
		         'html'=>$post);
		    $result = wp_remote_post( $url, array( 'body' => $post_data ) );

		} 
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_version() {
		return $this->version;
	}
}

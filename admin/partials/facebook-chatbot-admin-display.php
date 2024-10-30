<div class="container" style="padding: 35px;margin-top: 37px;"> 
	<div class="row" style="background: #fff;padding: 2%;"> 
		<div class="navbar-header" style="display: -webkit-box;">
			<div class="logo-header" style="width: 80%;">
				<a class="navbar-brand" href="http://personic.com"> <img class="img-reponsive" alt="logo" src="<?php echo plugins_url( 'images/logo.png', __FILE__ ); ?>"></a> 
			</div>
			<div>
				<ul class="nav navbar-nav navbar-right" style="overflow: hidden;">
					<li style="display: inline;margin: 0 10px;font-size: 14px;"><a href="mailto:support@personic.com" style="text-decoration: none;">Email Us</a></li>
					<li style="display: inline;margin: 0 10px;font-size: 14px;"><a href="http://personic.com/wordpress/faq" style="text-decoration: none;" target="_blank">FAQ</a></li>
					<li style="display: inline;margin: 0 10px;font-size: 14px;"><a href="https://m.me/454604061543401" target="_blank" style="text-decoration: none;">Chat</a></li>
				</ul>
			</div>
		</div>
	</div>
	<hr/>
	<div class="wrap" style="padding: 22px;background: #fff;margin: 0 !important;">
		<h1>Chatbot for Facebook Settings</h1>
		<hr/>
		<div id="connectwithfacebook" style="padding:10px;">
			<?php
				$options = get_option($this->plugin_name);
			?>
			<?php 
				if(!$options["email"]) {
			 ?>
	        	<p style="color: red">Please enter your email address to get started</p>
        	<?php 
	        	}else{
        	 ?>
        		<h3><b style="color: red">Connect your Facebook page with your account to finish the setup</b>
        		<a href="http://personic.com/wordpress/facebook-connect?auth=<?php echo wp_rand(1000,1000000); ?>personicwrdps-<?php echo esc_attr( get_option('facebook-chatbot')['email'] ); ?>&id=<?php echo wp_rand(1000,1000000);?>" target="_blank" style="color: royalblue">Click here to proceed</a></h3>
	        <?php } ?>
			
		</div>
		<hr/>
		<form method="post" action="options.php" remote="true" id="wordpressForm">
		    <?php
    			settings_fields($this->plugin_name);
    			do_settings_sections($this->plugin_name);
    			$options = get_option($this->plugin_name);
			?>
		    <table class="form-table">
		         
		        <tr valign="top">
		        <th scope="row">Email</th>
		        <td><input type="text" name="<?php echo $this->plugin_name; ?>[email]" value="<?php echo esc_attr( get_option('facebook-chatbot')['email'] ); ?>" /></td>
		        
		        </tr>
		        
		        <tr valign="top">
		        <th scope="row">Website/blog url</th>
		        <td><p><?php echo esc_attr( get_site_url() ); ?></p><input type="hidden" name="<?php echo $this->plugin_name; ?>[website]" value="<?php echo esc_attr( get_site_url() ); ?>" /></td>
		        </tr>
		        <tr valign="top">
		        <th scope="row">Facebook Page ID</th>
		        <td><p><?php echo esc_attr( get_option('facebook-chatbot')['fbid']==null ? "Your account is not connected to your facebook page" : get_option('facebook-chatbot')['fbid']); ?></p></td>
		        </tr>

		        <tr valign="top">
		        <th scope="row">Auto Post to Facebook<div class="tooltip">&nbsp;?&nbsp;<span class="tooltiptext">When you publish a new post to your WordPress site, your Chatbot for Facebook will inform your subscribers of your new post.</span></div></th>
		        <td><input type="checkbox" name="<?php echo $this->plugin_name; ?>[autopost]" value="1" <?php checked($options["autopost"], 1); ?>/></td>
		        </tr>
		        <tr valign="top">
		        <th scope="row">Include widget code in blog post<div class="tooltip">&nbsp;?&nbsp;<span class="tooltiptext">At the bottom of your posts, there will be a widget allowing users to subscribe to your Facebook Chatbot for updates with a powered by Personic link.</span></div></th>
		        <td><input type="checkbox" checked name="<?php echo $this->plugin_name; ?>[widget_code]" value="1" <?php checked($options["widget_code"], 1); ?> /></td>
		        </tr>
		        <tr>
		        <td><input type="hidden" name="<?php echo $this->plugin_name; ?>[error]" value="<?php echo esc_attr( get_option('facebook-chatbot')['error'] ); ?>" /></td>
		        <td><input type="hidden" name="<?php echo $this->plugin_name; ?>[fb_alreadyexist]" value="<?php echo esc_attr( get_option('facebook-chatbot')['fb_alreadyexist'] ); ?>" /></td>
		        <td><input type="hidden" name="<?php echo $this->plugin_name; ?>[previous_post]" value="1"/></td>
		        </tr>
		    </table>
		    
        	<?php submit_button('Send', 'primary','submit', TRUE); ?>

		</form>		
	</div>
</div>
<script>
	(function( $ ) {
		'use strict';
		$(document).ready(function(){
				var errorCheck = "<?php echo esc_attr( get_option('facebook-chatbot')['error'] ); ?>";
				var fb_alreadyexist = "<?php echo esc_attr( get_option('facebook-chatbot')['fb_alreadyexist'] ); ?>";
				var fbid = "<?php echo esc_attr( get_option('facebook-chatbot')['fbid'] ); ?>";
				if(errorCheck=="true"){
					if(fb_alreadyexist=="true"){
						$("#connectwithfacebook").html(" ");
						$("#connectwithfacebook").html("<h3 style='color: royalblue'>You are all set! Get users to subscribe to your chatbot by embedding a subscribe button with the code below.</h3><p>Embed the following code anywhere on your site for users to subscribe to your chatbot</p><div style='border: 1px solid #cccccc;padding:10px'>&lt;table style='border: 1px solid #cccccc;'&gt;&lt;tr&gt;&lt;td style='width: 10%;border:none;'&gt;&lt;a href='https://m.me/"+fbid+"'&gt;&lt;img src='https://assets.materialup.com/uploads/78fac9bb-4db8-4b9d-ae0b-bcd8360ed88d/icon285x285.jpeg' height='38px'&gt;&lt;/a&gt;&lt;/td&gt;&lt;td style='border:none;'&gt;&lt;a href='https://m.me/"+fbid+"' style='text-decoration:none'&gt;Click here to get updates via Facebook Messenger&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td style='width: 4%;border:none;'&gt;&lt;/td&gt;&lt;td style='border:none;'&gt;&lt;a style='font-size: 10px;float: left;margin-top: -3%;' href='http://personic.com'&gt;Powered by Personic&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;</div><p>perview of widget once it is embedded:</p><div style='border: 1px solid #cccccc;padding:10px'><table style='border: 1px solid #cccccc;'><tr><td style='width: 10%;border:none;'><a href='https://m.me/"+fbid+"'><img src='https://assets.materialup.com/uploads/78fac9bb-4db8-4b9d-ae0b-bcd8360ed88d/icon285x285.jpeg' height='38px'></a></td><td style='border:none;'><a href='https://m.me/"+fbid+"' style='text-decoration:none'>Click here to get updates via Facebook Messenger</a></td></tr><tr><td style='width: 4%;border:none;'></td><td style='border:none;'><a style='font-size: 10px;float: left;margin-top: -3%;' href='http://personic.com'>Powered by Personic</a></td></tr></table></div>");
					}
				}else if(errorCheck=="none"){
					$("#wordpressForm").show();	
				}else if(errorCheck==""){
					$("#wordpressForm").show();	
				}else{
					if(fb_alreadyexist=="true"){
						$("#connectwithfacebook").html(" ");
						$("#connectwithfacebook").show();
						$("#connectwithfacebook").html(" ");
						$("#connectwithfacebook").html("<h3 style='color: royalblue'>You are all set! Get users to subscribe to your chatbot by embedding a subscribe button with the code below.</h3><p>Embed the following code anywhere on your site for users to subscribe to your chatbot</p><div style='border: 1px solid #cccccc;padding:10px'>&lt;table style='border: 1px solid #cccccc;'&gt;&lt;tr&gt;&lt;td style='width: 10%;border:none;'&gt;&lt;a href='https://m.me/"+fbid+"'&gt;&lt;img src='https://assets.materialup.com/uploads/78fac9bb-4db8-4b9d-ae0b-bcd8360ed88d/icon285x285.jpeg' height='38px'&gt;&lt;/a&gt;&lt;/td&gt;&lt;td style='border:none;'&gt;&lt;a href='https://m.me/"+fbid+"' style='text-decoration:none'&gt;Click here to get updates via Facebook Messenger&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td style='width: 4%;border:none;'&gt;&lt;/td&gt;&lt;td style='border:none;'&gt;&lt;a style='font-size: 10px;float: left;margin-top: -3%;' href='http://personic.com'&gt;Powered by Personic&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;</div><p>perview of widget once it is embedded:</p><div style='border: 1px solid #cccccc;padding:10px'><table style='border: 1px solid #cccccc;'><tr><td style='width: 10%;border:none;'><a href='https://m.me/"+fbid+"'><img src='https://assets.materialup.com/uploads/78fac9bb-4db8-4b9d-ae0b-bcd8360ed88d/icon285x285.jpeg' height='38px'></a></td><td style='border:none;'><a href='https://m.me/"+fbid+"' style='text-decoration:none'>Click here to get updates via Facebook Messenger</a></td></tr><tr><td style='width: 4%;border:none;'></td><td style='border:none;'><a style='font-size: 10px;float: left;margin-top: -3%;' href='http://personic.com'>Powered by Personic</a></td></tr></table></div>");
					}else{
						$("#wordpressForm").show();	
						$("#connectwithfacebook").show();
					}
				}
		});
	})( jQuery );
</script>

<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >
<div class="row">
  <div class="small-12 medium-5 columns">
    <h5>Profile:</h5>
    
    <ul class="account-settings-list"><li>
        <?php do_action( 'woocommerce_edit_account_form_start' ); ?>
    
        <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
        </p>
        <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
        </p>
        <div class="clear"></div>
        
        <?php //  MUST HAVE DISPLAY NAME FIELD HERE  -- IT IS HIDDEN BY MY CSS -- BUT NEEDS TO BE HERE FOR WOOCOMMERCE'S FORM VALIDATION TO ACCEPT THIS FORM BEING UPDATED -- THERE IS REPORTEDLY NO OTHER WAY ?>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-row--------displayname">
            <label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" aria-describedby="account_display_name_description" />
            <span id="account_display_name_description"><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
        </p>
    
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
        </p>

        <?php
        /**
         * Hook where additional fields should be rendered.
         *
         * @since 8.7.0
         */
        do_action( 'woocommerce_edit_account_form_fields' );
        ?>
    
        <h5 class="password-change">Change Password</h5>
        <div class="hidden-password-panel">
            <fieldset>
                <!--<legend><?php _e( 'Password change', 'woocommerce' ); ?></legend> -->
    
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password_current"><?php esc_html_e( 'Current password', 'woocommerce' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password_1"><?php esc_html_e( 'New password', 'woocommerce' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
                </p>
            </fieldset>
        </div>
    
        <div class="clear"></div>
    
        <?php do_action( 'woocommerce_edit_account_form' ); ?>
        
    </li></ul>
    
  </div>
  <div class="small-12 medium-5 columns">
  
    <div id="profile-pic-setting">
      <?php
      /****************************************************************************************************************************/
      /*******https://support.advancedcustomfields.com/forums/topic/acf_form-woocommerce-and-user-image-field/  *******************/
      /****************************************************************************************************************************/
      acf_form( array(
          'post_id' => 'user_' . get_current_user_id(),
          'form'    => false,
          'fields'  => array(
              'field_598cc638b63e9',
          ),
          'return' => false,
      ) );
      ?>
    </div>
    
  </div>
</div> 
<div class="row">
  <div class="small-12 columns text-center" style="margin-top:20px;">
         <p>
            <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
            <button type="submit" class="woocommerce-Button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
            <input type="hidden" name="action" value="save_account_details" />
        </p>
        <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
  </div>    
</div>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
<div style="margin-top: 20px;">
    <div class="wrap">
     
        <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'img/sidepop-logo.png'; ?>" height="30">
        <h3>Welcome to the Sidepop integration for WordPress</h3>
        <p>Use Sidepop to create customized social proof notifications for your website. Also, with this plugin, you can submit information from WordPress and WooCommerce to Sidepop. For more customization of Sidepop, visit the <a href="https://app.sidepop.me" target="_blank">Sidepop Dashboard</a></p>

        <form method="post">
          <table class="form-table" role="presentation">
            <tbody>
              <tr>
                <th scope="row"><label for="sidepop_display">Widget display settings</label></th>
                <td>
                    <select name="sidepop_display" id="sidepop_display">
                        <option value="no" <?php if ($sidepop_display=="no") echo "selected";?>>Don't display widget</option>
                        <option value="no-except" <?php if ($sidepop_display=="no-except") echo "selected";?>>Only on selected pages and posts</option>
                        <option value="all-except" <?php if ($sidepop_display=="all-except") echo "selected";?>>Everywhere except selected pages and posts</option>
                    </select>
                    <p class="description">You can select pages or posts directly in the post or page editor.</p>
                </td>
              </tr>

              <tr>
                <th scope="row"><label for="sidepop_wordpress">Notify registrations</label></th>
                <td>
                    <select name="sidepop_wordpress" id="sidepop_wordpress">
                        <option value="no" <?php if ($sidepop_wordpress=="no") echo "selected";?>>Don't send</option>
                        <option value="yes" <?php if ($sidepop_wordpress=="yes") echo "selected";?>>Send WordPress registrations</option>
                        
                    </select>

                    <p class="description">Send information about new WordPress user registrations to Sidepop to generate automatic notifications. Learn more.</p>

                    <ul class="customize_sidepop_wordpress">
                        <li>
                            <label for="sidepop_wordpress_line1">
                                Line 1: <input type="text" id="sidepop_wordpress_line1" name="sidepop_wordpress_line1" value="<?php echo $sidepop_wordpress_line1;?>" class="regular-text">
                            </label>
                        </li>
                        <li>
                            <label for="sidepop_wordpress_line2">
                                Line 2: <input type="text" id="sidepop_wordpress_line2" name="sidepop_wordpress_line2" value="<?php echo $sidepop_wordpress_line2;?>" class="regular-text">
                            </label>
                        </li>
                    </ul>


                </td>
              </tr>

              <?php if ( class_exists( 'WooCommerce' ) ) { ?>

              <tr>
                <th scope="row"><label for="sidepop_woocommerce">Notify WooCommerce sales</label></th>
                <td>
                    <select name="sidepop_woocommerce" id="sidepop_woocommerce">
                        <option value="no" <?php if ($sidepop_woocommerce=="no") echo "selected";?>>Don't send</option>
                        <option value="yes" <?php if ($sidepop_woocommerce=="yes") echo "selected";?>>Send WooCommerce sales</option>
                        
                    </select>

                    <p class="description">Send information about new WooCommerce sales to Sidepop to generate automatic notifications. You need to have WooCommerce installed. Learn more.</p>

                    <ul class="customize_sidepop_woocommerce">
                        <li>
                            <label for="sidepop_woocommerce_line1">
                                Line 1: <input type="text" id="sidepop_woocommerce_line1" name="sidepop_woocommerce_line1" value="<?php echo $sidepop_woocommerce_line1;?>" class="regular-text">
                            </label>
                        </li>
                        <li>
                            <label for="sidepop_woocommerce_line2">
                                Line 2: <input type="text" id="sidepop_woocommerce_line2" name="sidepop_woocommerce_line2" value="<?php echo $sidepop_woocommerce_line2;?>" class="regular-text">
                            </label>
                        </li>
                    </ul>

                </td>
              </tr>

          <?php } ?>


              <tr>
                <th scope="row"><label for="">Fake notifications</label></th>
                <td>
                    
                    Enable fake notifications in the <a href="https://app.sidepop.me" target="_blank">Sidepop Dashboard</a> in the Notifications section.

                </td>
              </tr>



            </tbody>
          </table>
          <?php echo wp_nonce_field( 'sidepop-settings-save', 'sidepop-settings-nonce' );?>
        <?php echo submit_button();?>
        </form>
     
    </div><!-- .wrap -->
</div>
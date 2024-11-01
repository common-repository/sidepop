<div style="margin-top: 20px;">
    <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'img/sidepop-logo.png'; ?>" height="30">
    <h3>Start using Sidepop in WordPress</h3>
    <p>Use Sidepop to create customized social proof notifications for your website. Also, with this plugin, you can submit information from WordPress and WooCommerce to Sidepop. Just follow these steps:</p>
    <p>
      <b>&middot;</b> If you don't have an account, <b>visit <a href="https://sidepop.me/" target="_new">Sidepop.me</a></b> to create your account.
    </p>
    <p>
      <b>&middot;</b> In your <b><a href="https://app.sidepop.me/" target="_new">Sidepop Dashboard</a></b>, go to <b>Integrations</b>
    </p>
    <p>
      <b>&middot;</b> Copy and paste the <b>integration key</b> in the following box. <b>Do not share this integration key.</b>
    </p>
    <p>
      <b>&middot;</b> By entering an integration key you agree that this plugin will connect to Sidepop servers and that you agree to Sidepop's <a target="_blank" href="https://sidepop.me/terms-of-service/">Terms of service</a> and <a target="_blank" href="https://sidepop.me/privacy-policy/">Privacy Policy</a></label>.
    </p>

    <form method="post">
      <table class="form-table" role="presentation">
        <tbody>
          <tr>
            <th scope="row"><label for="sidepop_api_key">Integration key</label></th>
            <td><input maxlength="36" type="password" id="sidepop_api_key" name="sidepop_api_key" placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" value="<?php echo $sidepop_api_key;?>" class="regular-text"></td>
          </tr>
        </tbody>
      </table>
      <?php echo wp_nonce_field( 'sidepop-api-save', 'sidepop-api-nonce' );?>
    <?php echo submit_button();?>
    </form>
  </div>

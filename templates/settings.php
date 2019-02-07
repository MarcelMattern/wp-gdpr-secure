<?php
    if( isset( $_GET[ 'tab' ] ) ) {
        $active_tab = $_GET[ 'tab' ];
    }
?>

<div class="wrap">
    <h2>DSGVO/GDPR</h2>
    <h3 class="nav-tab-wrapper">
            <a href="options-general.php?page=dsgvo_gdpr" class="nav-tab <?php echo isset($_GET["tab"]) ? '' : 'nav-tab-active'; ?>">Google Analytics Settings</a>
            <a href="options-general.php?page=dsgvo_gdpr&tab=ga" class="nav-tab <?php echo $active_tab == 'ga' ? 'nav-tab-active' : ''; ?>">Google Analytics Settings</a>
            <a href="options-general.php?page=dsgvo_gdpr&tab=cookie" class="nav-tab <?php echo $active_tab == 'cookie' ? 'nav-tab-active' : ''; ?>">Cookie Info Settings</a>
            <a href="options-general.php?page=dsgvo_gdpr&tab=iframe" class="nav-tab <?php echo $active_tab == 'iframe' ? 'nav-tab-active' : ''; ?>">iFrame Settings</a>
        </h3>
        <?php
        if( $active_tab == 'iframe' ) {?>
    <form method="post" action="options.php"> 
        <?php settings_fields('dsgvo_gdpr-group'); ?>
        <?php do_settings_sections('dsgvo_gdpr-group'); ?>
        <table class="form-table">


        
            <tr valign="top">
                <th scope="row"><label for="warning_title"><?=__('Warning Title:', 'dsgvogdpr');?></label></th>
                <td><input type="text" name="warning_title" id="warning_title" size="100" value="<?php echo (get_option('warning_title') ? get_option('warning_title') : 'https://policies.google.com/privacy?hl=de&gl=de'); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="warning_text"><?=__('Warning Text to Inform User:', 'dsgvogdpr');?></label></th>
                <td><input type="text" name="warning_text" id="warning_text" size="100" value="<?php echo (get_option('warning_text') ? get_option('warning_text') : 'https://policies.google.com/privacy?hl=de&gl=de'); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="warning_btn_text"><?=__('Warning Button Text:', 'dsgvogdpr');?></label></th>
                <td><input type="text" name="warning_btn_text" id="warning_btn_text" size="100" value="<?php echo (get_option('warning_btn_text') ? get_option('warning_btn_text') : 'Hiermit aktzeptiere ich die Datenschutzbestimmungen!'); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="yt_privacy_link"><?=__('YouTube Privacy Link', 'dsgvogdpr');?></label></th>
                <td><input type="text" name="yt_privacy_link" id="yt_privacy_link" size="100" value="<?php echo (get_option('yt_privacy_link') ? get_option('yt_privacy_link') : 'https://policies.google.com/privacy?hl=de&gl=de'); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="maps_privacy_link"><?=__('Maps Privacy Link', 'dsgvogdpr');?></label></th>
                <td><input type="text" name="maps_privacy_link" id="maps_privacy_link" size="100" value="<?php echo get_option('maps_privacy_link'); ?>" /></td>
            </tr>
            
        </table>

        <?php submit_button(); ?>  
    </form>
    <?php
        } 
        ?>
</div>

<?php

function dsgvo_render_js($warn_title, $warn_text, $warn_btn_text, $yt_privacy_link, $maps_privacy_link) {
    $js = '/* TEST */';
    $js .= 'var ';
    $js .= 'warn_title="' . $warn_title . '",';
    $js .= 'warn_text="' . $warn_text . '",';
    $js .= 'warn_btn_text="' . $warn_btn_text . '",';
    $js .= 'yt_p_link="' . $yt_privacy_link . '",';
    $js .= 'maps_p_link="' . $maps_privacy_link . '";';

    $fp = fopen(GDPR_PATH . '/assets/js/script_edit.min.js', 'w');
    fwrite($fp, $js);
    fclose($fp);

}

dsgvo_render_js(get_option('warning_title'), get_option('warning_text'), get_option('warning_btn_text'), get_option('yt_privacy_link'), get_option('yt_privacy_link'));
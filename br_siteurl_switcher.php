<?php
/*
	Plugin Name: Brafton Site domain Switcher
	Plugin URI: http://www.brafton.com/support/wordpress
	Description: simple plugin for moving the site from one domain/subdomain/or subfolder to another.  Modifies all instance of an old url to a new url in the post content, guid, and meta fields.
	Version: 1.0.2
    Requires: 4.0
	Author: Brafton, Inc.
    //@author: Deryk W. King <deryk.king@brafton.com>

*/

class BrSiteChanger{
    
    public function __construct(){
        add_action('admin_menu', array($this, 'BrSiteChanger_menu'));
    }
    public function BrSiteChanger_menu(){

        $hook = add_options_page( 'Brafton SiteUrl Switcher', 'Brafton SiteUrl Switcher', 'manage_options', 'br_site_changer', array($this, 'menuPage'));

    }
    public function menuPage(){
        if(isset($_POST['changeMe'])){
            $oldUrl = $_POST['oldUrl'];
            $newUrl = $_POST['newUrl'];
            $options = $_POST['dbitem'];
            //check and make sure old and new have data
            if($oldUrl != "" && $newUrl != ""){
                $result = $this->runconfig($oldUrl, $newUrl, $options);
                $result['success'] = true;
            }else{
                $result['success'] = false;
                $result['error'] = "You must specify an Old Url and New Url";
            }
        } ?>
<style>
    form.br-site-changer {
    width: 75%;
    padding: 25px;
    height: 500px;
}
    form.br-site-changer label {
    width: 200px;
    display: inline-block;
}
    .form-item {
    margin: 15px 0px;
}
    .checks{
        display:inline-block;
    }
    form.br-site-changer .form-item input[type="text"] {
    width: 200px;
    display: inline-block;
}
    .br-site-changer div.notice{
        padding:15px;
    }
    .br-site-changer div.error, .br-site-changer div.notice-success{
        padding:15px 10px;   
    }
</style>
        <form method="post" class="br-site-changer">
            <h1>Brafton SiteUrl Switcher</h1>
            <?php if(isset($result)){
                if($result['success']){
                    echo '<div class="notice">';
                    foreach($result['operations'] as $operation => $result){
                        echo sprintf("<div class='notice notice-%s'>%s</div>", (($result === false)? "error" : "success"), ($result === false)? $operation." resulted in a failure. There is likely an error in your url entries" : $operation." was successful ".$result." rows were affected");
                    }
                    echo '</div>';
                }else{
                    echo sprintf("<div class='error'>There was an error with this operation. %s</div>", $result['error']);
                }
            } ?>
            <div class="form-item">
                <label>Current/Old Site Url</label>
                <input type="text" name="oldUrl" placeholder="Old Url" value="<?php echo site_url(); ?>" title="Defaults to current sites url"/>
            </div>
            <div class="form-item">
                <label>New Site Url</label>
                <input type="text" name="newUrl" placeholder="New Url"/>
            </div>
            <div class="form-item">
                <label>Database Items to update</label>
                <div class="checks">
                    <input type="checkbox" name="dbitem[]" value="siteOptions"/> options <input type="checkbox" name="dbitem[]" value="postContent"/> postContent <input type="checkbox" name="dbitem[]" value="postPermalinks"/> postPermalinks <input type="checkbox" name="dbitem[]" value="postMeta"/> postMeta 
                </div>
            </div>
            <input type="submit" name="changeMe" value="Change"/>
        </form>

    <?php
        
    }
    private function runconfig($oldUrl, $newUrl, $options){
        global $wpdb;
        $update_siteOptions = $wpdb->prepare("UPDATE wp_options SET option_value = replace(option_value, %s, %s) WHERE option_name = 'home' OR option_name = 'siteurl'", $oldUrl, $newUrl);
        $update_postContent = $wpdb->prepare("UPDATE $wpdb->posts SET post_content = replace(post_content, %s, %s)", $oldUrl, $newUrl);
        $update_postPermalinks = $wpdb->prepare("UPDATE $wpdb->posts SET guid = replace(guid, %s, %s)", $oldUrl, $newUrl);
        $update_postMeta = $wpdb->prepare("UPDATE $wpdb->postmeta SET meta_value = replace(meta_value,%s,%s)", $oldUrl, $newUrl);
        $result = array('operations');
        foreach($options as $key => $option){
            $run = 'update_'.$option;
            $result['operations'][$run] = $wpdb->query($$run);
        }
        return $result;
        
    }
}

new BrSiteChanger();
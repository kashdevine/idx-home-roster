<?php

/*
  Plugin Name: IDX Home Custom Roster Layout
  Version: 1.0
  Description: Provides a dynamic roster layout similar to IDX Broker Home's PPI Reality's roster layout.
  Author: IDX Broker
  Author URI: https://www.idxbroker.com/
*/

namespace IDXHOME;


use IDXHOME\ActivateRoster;

require_once 'activate-plugin.php';

class IDXHomeRoster{
    
    public $tablename;
    public $charset;

    public function __construct()
    {
        global $wpdb;
        $this->charset = $wpdb->get_charset_collate();
        $this->tablename = $wpdb->prefix . 'homerosteragents';
        register_activation_hook( __FILE__, array( $this, 'rosterActivate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'rosterDeactivate' ) );
        add_action( 'admin_init', array($this, 'impress_For_IDX_exists'));
        add_action('wp_enqueue_scripts', array($this,'load_styles_scripts'));
    }


    public function rosterActivate(){
        global $wpdb;

        $query =  $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $this->tablename ) );
        if ( ! $wpdb->get_var( $query ) == $this->tablename ) {
            $this->createRosterTable();
        }       

        $this->create_IDX_account_url();

        new ActivateRoster();
    } 
    
    public function rosterDeactivate(){
        global $wpdb;

        $query =  $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $this->tablename ) );
        if ( $wpdb->get_var( $query ) == $this->tablename ) {
            $this->dropRosterTable();
        }
        
    }

    public function create_IDX_account_url(){
        $resultsUrl = get_option('idx_results_url');
        $midStepArray = explode("/", $resultsUrl);
        $IDXaccountURL = $midStepArray[0] . '//' . $midStepArray[2] . '/'; 
        $IDXaccountURLNoProto = '//' . $midStepArray[2] . '/'; 

        add_option('idx_account_url', $IDXaccountURL);
        add_option('idx_account_url_no_protocol', $IDXaccountURLNoProto);
    }

    public function load_styles_scripts(){
        if(!is_admin()){
            wp_enqueue_style('ppistyles', plugins_url('css/ppirosterstyles.css', __FILE__));
        }
    }


    function impress_For_IDX_exists() {
    if ( is_admin() && current_user_can( 'activate_plugins') && !is_plugin_active( 'idx-broker-platinum/idx-broker-platinum.php') ) {

    add_action( 'admin_notices', array($this, 'roster_plugin_notice') );

                deactivate_plugins( plugin_basename( __FILE__) );
                if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
                }
            }
     }

    function roster_plugin_notice() {
        ?><div class="error">
            <p>Sorry, But IDX HOME Custom Roster requires IMPress for IDX Broker to be installed and activated</p>
            </div>
            <?php
         }

    private  function createRosterTable(){
        require_once(ABSPATH . './wp-admin/includes/upgrade.php');
        dbDelta(
            "CREATE TABLE $this->tablename(
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            agentCategory nvarchar(16) NOT NULL DEFAULT '',
            agentFirstName nvarchar(50) NOT NULL DEFAULT '',
            agentLastName nvarchar(50) NOT NULL DEFAULT '',
            agentDisplayName nvarchar(50) NOT NULL DEFAULT '',
            agentEmail nvarchar(50) NOT NULL DEFAULT '',
            agentTitle nvarchar(50) NOT NULL DEFAULT '',
            address nvarchar(50) NOT NULL DEFAULT '',
            city nvarchar(50) NOT NULL DEFAULT '',
            stateProvince nvarchar(50) NOT NULL DEFAULT '',
            country nvarchar(50) NOT NULL DEFAULT '',
            zipCode nvarchar(50) NOT NULL DEFAULT '',
            agentHomePhone nvarchar(50) NOT NULL DEFAULT '',
            agentHomeFax nvarchar(50) NOT NULL DEFAULT '',
            agentOfficePhone nvarchar(50) NOT NULL DEFAULT '',
            agentOfficeFax nvarchar(50) NOT NULL DEFAULT '',
            agentCellPhone nvarchar(50) NOT NULL DEFAULT '',
            agentPager nvarchar(50) NOT NULL DEFAULT '',
            agentPhotoURL nvarchar(250) NOT NULL DEFAULT '',
            agentURL nvarchar(150) NOT NULL DEFAULT '',
            agentURLdisplay nvarchar(150) NOT NULL DEFAULT '',
            preferredPhone nvarchar (50) NOT NULL DEFAULT '',
            listingAgentID nvarchar (50) NOT NULL DEFAULT '',
            agentBioURL nvarchar (50) NOT NULL DEFAULT '',
            agentContactPhone nvarchar (50) NOT NULL DEFAULT '',
            agentID bigint(25) unsigned NOT NULL,
            PRIMARY KEY  (id)
            )"
        , $this->charset);

    }

    private  function dropRosterTable(){
        global $wpdb;

        $query = "DROP TABLE " . $this->tablename;
        $wpdb->query($query);
    }

}

new IDXHomeRoster();
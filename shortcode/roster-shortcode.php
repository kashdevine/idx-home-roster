<?php


namespace IDXHOME\Shortcode;

class IDXHOMERosterShortCode {

    public $tablename;
    public $agents;
    public $idxApi;

    public function __construct()
    {
        global $wpdb;
        $this->tablename = $wpdb->prefix . 'homerosteragents';
        add_shortcode( 'idxhomeroster', array($this, 'idxroster_function' ));  
        add_shortcode( 'idxhomeshorttest', array($this, 'shorttest_function' ));  
    }
    

    public function idxroster_function(){
        return $this->ppirealty_layout();
    }

    public function shorttest_function(){
        return "<h1>Hello Worlds</h1>";
    }

    public function ppirealty_layout(){
        $allAgents = $this->getAllAgents();

        ob_start();
        { ?>
            <h3>Support Team</h3>
                <div class="allAgentsContainer">
                    <?php foreach($allAgents as $agent) { ?> 
                        <?php if($agent->agentCategory != 'agent') { ?> 
                            <div class="agentContainer" style="min-width:300px;">
                                    <div class="agentContainer-Inner">
                                        <a href="<?php echo get_option('idx_account_url_no_protocol') . $agent->agentBioURL ?>" class="roster-popup">
                                        <?php if ($agent->agentPhotoURL != null || $agent->agentPhotoURL != '') {?>
                                            <img src="<?php echo $agent->agentPhotoURL?>" alt="<?php echo $agent->agentDisplayName?> Headshot" class="wp-post-image"></a>
                                            <?php } else {?>
                                                <img src="//d1qfrurkpai25r.cloudfront.net/images/missingAgent.png?auid=YQGhGHFtrTuKU3e2XIx1TgAAAAk" alt="<?php echo $agent->agentDisplayName?> Place Holder" class="wp-post-image"></a>
                                            <?php }?>
                                        <div class="agentHover">
                                            <a class="agentName roster-popup" href="<?php echo get_option('idx_account_url_no_protocol') . $agent->agentBioURL ?>">
                                            <?php echo $agent->agentDisplayName ?>
                                                    <span class="agentRole">
                                                        <?php if($agent->agentTitle != null || $agent->agentTitle != '') {?>
                                                            <?php echo $agent->agentTitle ?>
                                                        <?php } else { echo "Agent"; }?>
                                                    </span>
                                                </a>
                                            <div class="agentDetails">
                                                <div class="agentDetailsLeft">
                                                    <div class="agentInfo">
                                                        <i class="fas fa-phone"></i>
                                                        <a href="tel:<?php echo $agent->agentContactPhone ?>">
                                                        <?php echo $agent->agentContactPhone ?>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="agentDetailsRight">
                                                    <div class="agentInfo">
                                                        <a href="mailto:<?php echo $agent->agentEmail ?>"><i class="fas fa-envelope" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }?>
                    <?php }?>
            </div>
            <h3>Agents</h3>
            <div class="allAgentsContainer">
            <?php foreach($allAgents as $agent) { ?> 
                <?php if($agent->agentCategory == 'agent') { ?> 
                    <div class="agentContainer" style="min-width:300px;">
                            <div class="agentContainer-Inner">
                                <a href="<?php echo get_option('idx_account_url_no_protocol') . $agent->agentBioURL ?>" class="roster-popup">
                                    <?php if ($agent->agentPhotoURL != null || $agent->agentPhotoURL != '') {?>
                                    <img src="<?php echo $agent->agentPhotoURL?>" alt="<?php echo $agent->agentDisplayName?> Headshot" class="wp-post-image"></a>
                                    <?php } else {?>
                                        <img src="//d1qfrurkpai25r.cloudfront.net/images/missingAgent.png?auid=YQGhGHFtrTuKU3e2XIx1TgAAAAk" alt="<?php echo $agent->agentDisplayName?> Place Holder" class="wp-post-image"></a>
                                    <?php }?>
                                <div class="agentHover">
                                    <a class="agentName roster-popup" href="<?php echo get_option('idx_account_url_no_protocol') . $agent->agentBioURL ?>">
                                    <?php echo $agent->agentDisplayName ?>
                                            <span class="agentRole">
                                                <?php if($agent->agentTitle != null || $agent->agentTitle != '') {?>
                                                    <?php echo $agent->agentTitle ?>
                                                <?php } else { echo "Agent"; }?>
                                            </span>
                                        </a>
                                    <div class="agentDetails">
                                        <div class="agentDetailsLeft">
                                            <div class="agentInfo">
                                                <i class="fas fa-phone"></i>
                                                <a href="tel:<?php echo $agent->agentContactPhone ?>">
                                                <?php echo $agent->agentContactPhone ?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="agentDetailsRight">
                                            <div class="agentInfo">
                                                <a href="mailto:<?php echo $agent->agentEmail ?>"><i class="fas fa-envelope" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php }?>
            <?php }?>
        <?php }

        return ob_get_clean();
    }


    public function getAllAgents(){
        global $wpdb;
        $allAgentsQuery = "SELECT * FROM $this->tablename ORDER BY agentFirstName ASC, agentPhotoURL";
        $agents = $wpdb->get_results( $wpdb->prepare($allAgentsQuery));

        if($agents != null){
            return $agents;
        }
    }

}

new IDXHOMERosterShortCode();
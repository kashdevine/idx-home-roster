<?php

namespace IDXHOME\Api\Agents;


class AgentsAPI {


    public $agents;
    public $agentfields;
    public $mainclass;
    public $apikey;

    public function __construct()
    {
        global $wpdb;
        $this->tablename = $wpdb->prefix . 'homerosteragents';
        $this->apikey = get_option('idx_broker_apikey');
        add_option('home_roster_agent_fields', array($this->agentfields));
        add_shortcode('checkagentapi', array($this, 'showApiResult'));
        $this->addAgentsToDb();
        
    }

    public function curlGetAgentsFields(){
        $url = 'https://api.idxbroker.com/clients/agents';

        $encodedurl = urlencode($url);


        $ch = curl_init();

        $headerArray = array(
            "Content-type:application/x-www-form-urlencoded",
            "accesskey:$this->apikey",
            "apiversion:1.7.0"
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        
        return $response;

    }

    public function addAgentsToDb(){
        global $wpdb;
        $countQuery = "SELECT COUNT(*) FROM $this->tablename";
        $countResult = $wpdb->get_var($wpdb->prepare($countQuery));

        if($countResult == null || $countResult == 0){
            $response = $this->curlGetAgentsFields();
            $allagents = json_decode($response)->agent;
            $allManagement = json_decode($response)->management;
            $allStaff = json_decode($response)->staff;

            foreach ($allagents as $agent){
                $wpdb->insert($this->tablename, array(
                    'agentCategory' => "$agent->agentCategory",
                    'agentFirstName' => "$agent->agentFirstName",
                    'agentLastName' => "$agent->agentLastName",
                    'agentDisplayName' => "$agent->agentDisplayName",
                    'agentEmail' => "$agent->agentEmail",
                    'agentTitle' => "$agent->agentTitle",
                    'address' => "$agent->address",
                    'city' => "$agent->city",
                    'stateProvince' => "$agent->stateProvince",
                    'country' => "$agent->country",
                    'zipCode' => "$agent->zipCode",
                    'agentHomePhone' => "$agent->agentHomePhone",
                    'agentHomeFax' => "$agent->agentHomeFax",
                    'agentOfficePhone' => "$agent->agentOfficePhone",
                    'agentOfficeFax' => "$agent->agentOfficeFax",
                    'agentCellPhone' => "$agent->agentCellPhone",
                    'agentPager' => "$agent->agentPager",
                    'agentPhotoURL' => "$agent->agentPhotoURL",                
                    'agentURL' => "$agent->agentURL",                
                    'agentURLdisplay' => "$agent->agentURLdisplay",                
                    'listingAgentID' => "$agent->listingAgentID",                
                    'listingAgentID' => "$agent->listingAgentID",                
                    'agentBioURL' => "$agent->agentBioURL",                
                    'agentContactPhone' => "$agent->agentContactPhone",                
                    'agentID' => $agent->agentID                
                ));
            }
            foreach ($allManagement as $management){
                $wpdb->insert($this->tablename, array(
                    'agentCategory' => "$management->agentCategory",
                    'agentFirstName' => "$management->agentFirstName",
                    'agentLastName' => "$management->agentLastName",
                    'agentDisplayName' => "$management->agentDisplayName",
                    'agentEmail' => "$management->agentEmail",
                    'agentTitle' => "$management->agentTitle",
                    'address' => "$management->address",
                    'city' => "$management->city",
                    'stateProvince' => "$management->stateProvince",
                    'country' => "$management->country",
                    'zipCode' => "$management->zipCode",
                    'agentHomePhone' => "$management->agentHomePhone",
                    'agentHomeFax' => "$management->agentHomeFax",
                    'agentOfficePhone' => "$management->agentOfficePhone",
                    'agentOfficeFax' => "$management->agentOfficeFax",
                    'agentCellPhone' => "$management->agentCellPhone",
                    'agentPager' => "$management->agentPager",
                    'agentPhotoURL' => "$management->agentPhotoURL",                
                    'agentURL' => "$management->agentURL",                
                    'agentURLdisplay' => "$management->agentURLdisplay",                
                    'listingAgentID' => "$management->listingAgentID",                
                    'listingAgentID' => "$management->listingAgentID",                
                    'agentBioURL' => "$management->agentBioURL",                
                    'agentContactPhone' => "$management->agentContactPhone",                
                    'agentID' => $management->agentID                
                ));
            }
            foreach ($allStaff as $staff){
                $wpdb->insert($this->tablename, array(
                    'agentCategory' => "$staff->agentCategory",
                    'agentFirstName' => "$staff->agentFirstName",
                    'agentLastName' => "$staff->agentLastName",
                    'agentDisplayName' => "$staff->agentDisplayName",
                    'agentEmail' => "$staff->agentEmail",
                    'agentTitle' => "$staff->agentTitle",
                    'address' => "$staff->address",
                    'city' => "$staff->city",
                    'stateProvince' => "$staff->stateProvince",
                    'country' => "$staff->country",
                    'zipCode' => "$staff->zipCode",
                    'agentHomePhone' => "$staff->agentHomePhone",
                    'agentHomeFax' => "$staff->agentHomeFax",
                    'agentOfficePhone' => "$staff->agentOfficePhone",
                    'agentOfficeFax' => "$staff->agentOfficeFax",
                    'agentCellPhone' => "$staff->agentCellPhone",
                    'agentPager' => "$staff->agentPager",
                    'agentPhotoURL' => "$staff->agentPhotoURL",                
                    'agentURL' => "$staff->agentURL",                
                    'agentURLdisplay' => "$staff->agentURLdisplay",                
                    'listingAgentID' => "$staff->listingAgentID",                
                    'listingAgentID' => "$staff->listingAgentID",                
                    'agentBioURL' => "$staff->agentBioURL",                
                    'agentContactPhone' => "$staff->agentContactPhone",                
                    'agentID' => $staff->agentID                
                ));
            }
        }
    }

    public function showApiResult(){
        $response = $this->curlGetAgentsFields();
        $agentarray = json_decode($response)->agent;
        var_dump($agentarray);
    }

}

new AgentsAPI();
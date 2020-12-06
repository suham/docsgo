<?php
namespace TP\Tools;

use stdClass;

#
# @Class SonarQube
# 
# This Class can be used for the data extraction from the sonar qube server
#

class SonarQube
{
    /**
     * This method is used to fetch sonar qube vulnerabilities
     * @param {String} URL - contains the TestLink API URL
     * @param {String} options - contains the request options
     * @return {Object} vulnearabilities
     */
    function getVulnerabilities($URL, $options = ""){
        $response = $this->callAPI($URL);
        
        return $response;
    }


    /**
     * This method is used to make a http/https call
     * @param {String} URL - contains the URL
     * @param {Object} options - contains the request options
     * @return {Object} API response 
     */
    private function callAPI($URL, $options = ""){
        try {
            $vulnerabilities = [];
            $ch = curl_init();  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_URL, $URL); 
            $result = curl_exec($ch); 
            curl_close($ch);

            $data = json_decode($result);
            if( $data->total ){
                $count = $data->total;  
                $pageCount = floor($count/100);
                if( $pageCount == 0 ){
                    $pageCount = 1;
                }        
                if( $count != 0 && $pageCount > 0 ){
                    for( $i = 1; $i <= $pageCount; $i++ ){
                        $pageIndex = $i;
                        $curlReq = curl_init();  
                        curl_setopt($curlReq, CURLOPT_RETURNTRANSFER, 1); 
                        curl_setopt($curlReq, CURLOPT_URL, "$URL&pageIndex=$pageIndex"); 
                        $res = curl_exec($curlReq); 
                        $tmp = json_decode($res);
                        $vulnerabilities = array_merge( $vulnerabilities, $tmp->issues);
                    }
                }
            }
            return $vulnerabilities;
        } catch(Exception $e){
            error_log($e);
            return false;
        }
    }
}
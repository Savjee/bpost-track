<?php

namespace Savjee;

use Curl\Curl;
use Sunra\PhpSimple\HtmlDomParser;

/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 29/08/15
 * Time: 12:00
 */
class BpostPackage
{
    private $itemNumber;
    private $statusUpdates = array();
    private $language = 'NL';

    /**
     * BpostPackage constructor.
     * @param $itemNumber
     */
    public function __construct($itemNumber)
    {
        $this->setItemNumber($itemNumber);
        $this->getTrackingInformation();
    }

    private function getTrackingInformation(){

        //
        // First request: getting the queryToken and sessionIdCookie
        //
        $curl = new Curl();
        $curl->setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.157 Safari/537.36');
        $curl->get('http://track.bpost.be/etr/light/showSearchPage.do?oss_language='. $this->getLanguage());

        if($curl->error){
            throw new Exception('CURL error: ' . $curl->errorCode . ': ' . $curl->errorMessage);
        }

        $postData = $this->getPostData($curl);
        $sessionIdCookie = ($curl->getCookie('JSESSIONID'));

        //
        // Second request: get the tracking information
        //
        $curl->setReferer('http://track.bpost.be/etr/light/showSearchPage.do?oss_language=NL');
        $curl->post('http://track.bpost.be/etr/light/performSearch.do;jsessionid=' . $sessionIdCookie, $postData);

        if($curl->error){
            throw new Exception('CURL error: ' . $curl->errorCode . ': ' . $curl->errorMessage);
        }

        //
        // Process the tracking information and create StatusUpdate instances
        //
        $this->generateStatusUpdateInstances($curl->response);
    }

    private function generateStatusUpdateInstances($data){
        // Parse the response
        $dom = HtmlDomParser::str_get_html($data);

        foreach($dom->find('table#reportedLine tr[class="odd"], table#reportedLine tr[class="even"]') as $historyLine){
            $date = $historyLine->find('td', 0)->plaintext;
            $time = $historyLine->find('td', 1)->plaintext;
            $status = $historyLine->find('td', 2)->plaintext;
            $location = $historyLine->find('td', 3)->plaintext;

            $statusUpdate = new StatusUpdate($date, $time, $status, $location);
            array_push($this->statusUpdates, $statusUpdate);
        }
    }

    private function getPostData(Curl $curl){
        // Feed response into Simple HTML DOM
        $dom = HtmlDomParser::str_get_html($curl->response);

        // Array for post data
        $postData = array();
        $postData['searchByItemCode'] = 'true';
        $postData['searchByCustomerReference'] = 'false';
        $postData['includeOldItems'] = 'false';
        $postData['oss_language'] = $this->getLanguage();
        $postData['itemCodes'] = $this->getItemNumber();

        // Search for the queryToken
        $queryToken = $dom->find('input[name="queryToken"]', 0);
        $postData['queryToken'] = $queryToken->value;

        return $postData;
    }



    /**
     * @return mixed
     */
    public function getItemNumber()
    {
        return $this->itemNumber;
    }

    /**
     * @param mixed $itemNumber
     */
    public function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;
    }

    /**
     * @return array
     */
    public function getStatusUpdates()
    {
        return $this->statusUpdates;
    }

    /**
     * @param array $statusUpdates
     */
    public function setStatusUpdates($statusUpdates)
    {
        $this->statusUpdates = $statusUpdates;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }
}
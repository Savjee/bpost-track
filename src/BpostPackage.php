<?php

namespace Savjee\BpostTrack;

use Curl\Curl;
use Exception;
use Sunra\PhpSimple\HtmlDomParser;

/**
 * Created by PhpStorm.
 * User: Xavier
 * Date: 29/08/15
 * Time: 12:00
 */
class BpostPackage
{
    const BPOST_API_ENDPOINT = 'http://track.bpost.be/btr/api/';
    const LANGUAGE = 'nl'; // nl, en, fr

    // Pakcage information
    private $statusUpdates = array();
    private $itemNumber;
    private $weight;
    private $customerReference;
    private $requestedDeliveryMethod;

    /** @var  SenderReceiver $sender */
    private $sender;

    /** @var  SenderReceiver $receiver */
    private $receiver;

    private $translationsCache = null;



    public function __construct($itemNumber)
    {
        $this->setItemNumber($itemNumber);
        $this->fetchTranslations();
        $this->getTrackingInformation();
    }

    private function fetchTranslations(){
        $curl = new Curl();
        $curl->get(self::BPOST_API_ENDPOINT . 'translations?lang=' . self::LANGUAGE);

        if($curl->error){
            throw new Exception('CURL error while fetching translations: ' . $curl->errorCode . ': ' . $curl->errorMessage);
        }

        $this->translationsCache = $curl->response;
    }

    private function translateKey($key){
        if($this->translationsCache == null){
            $this->fetchTranslations();
        }

        return $this->translationsCache->event->$key->description;
    }
    
    private function getTrackingInformation(){
        $curl = new Curl();
        $curl->get(self::BPOST_API_ENDPOINT . 'items?itemIdentifier=' . $this->getItemNumber());

        if($curl->error){
            throw new Exception('CURL error while fetching tracking information: ' . $curl->errorCode . ': ' . $curl->errorMessage);
        }

        // Curl library already decoded the JSON (cool!)
        $response = $curl->response[0];

        // Decode sender
        $rawSender = $response->sender;
        $this->sender = new SenderReceiver($rawSender->countryCode, $rawSender->municipality, $rawSender->postcode);

        // Decode receiver
        $rawReceiver = $response->receiver;
        $this->receiver = new SenderReceiver($rawReceiver->countryCode, $rawReceiver->municipality, $rawReceiver->postcode, $rawReceiver->name);


        // Some other stuff
        $this->weight = (int) $response->weightInGrams;
        $this->customerReference = $response->customerReference;
        $this->requestedDeliveryMethod = $response->requestedDeliveryMethod;

        // Decode events
        $rawEvents = $response->events;

        foreach($rawEvents as $rawEvent){
            $lang = self::LANGUAGE;
            $eventDescription = $this->translateKey($rawEvent->key);

            $statusUpdate = new StatusUpdate($rawEvent->date, $rawEvent->time, $eventDescription, $rawEvent->location->$lang);

            array_push($this->statusUpdates, $statusUpdate);
        }
    }

    /**
     * @return mixed
     */
    public function getItemNumber()
    {
        return $this->itemNumber;
    }

    /**
     * @return array
     */
    public function getStatusUpdates()
    {
        return $this->statusUpdates;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return mixed
     */
    public function getCustomerReference()
    {
        return $this->customerReference;
    }

    /**
     * @return mixed
     */
    public function getRequestedDeliveryMethod()
    {
        return $this->requestedDeliveryMethod;
    }

    /**
     * @return SenderReceiver
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return SenderReceiver
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    private function setItemNumber($itemNumber)
    {
        $this->itemNumber = $itemNumber;
    }
}
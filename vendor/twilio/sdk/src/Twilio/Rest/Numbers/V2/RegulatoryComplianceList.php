<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Numbers\V2;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceContext;
use Twilio\ListResource;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\BundleList;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\EndUserList;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\EndUserTypeList;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\RegulationList;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\SupportingDocumentList;
use Twilio\Rest\Numbers\V2\RegulatoryCompliance\SupportingDocumentTypeList;
use Twilio\Version;

/**
 * @property BundleList $bundles
 * @property EndUserList $endUsers
 * @property EndUserTypeList $endUserTypes
 * @property RegulationList $regulations
 * @property SupportingDocumentList $supportingDocuments
 * @property SupportingDocumentTypeList $supportingDocumentTypes
 * @method \Twilio\Rest\Numbers\V2\RegulatoryCompliance\BundleContext bundles(string $sid)
 * @method \Twilio\Rest\Numbers\V2\RegulatoryCompliance\EndUserContext endUsers(string $sid)
 * @method \Twilio\Rest\Numbers\V2\RegulatoryCompliance\EndUserTypeContext endUserTypes(string $sid)
 * @method \Twilio\Rest\Numbers\V2\RegulatoryCompliance\RegulationContext regulations(string $sid)
 * @method \Twilio\Rest\Numbers\V2\RegulatoryCompliance\SupportingDocumentContext supportingDocuments(string $sid)
 * @method \Twilio\Rest\Numbers\V2\RegulatoryCompliance\SupportingDocumentTypeContext supportingDocumentTypes(string $sid)
 */
class RegulatoryComplianceList extends ListResource {
    protected $_bundles = null;
    protected $_endUsers = null;
    protected $_endUserTypes = null;
    protected $_regulations = null;
    protected $_supportingDocuments = null;
    protected $_supportingDocumentTypes = null;

    /**
     * Construct the RegulatoryComplianceList
     *
     * @param Version $version Version that contains the resource
     */
    public function __construct(Version $version) {
        parent::__construct($version);

        // Path Solution
        $this->solution = [];
    }

    /**
     * Access the bundles
     */
    protected function getBundles(): BundleList {
        if (!$this->_bundles) {
            $this->_bundles = new BundleList($this->version);
        }

        return $this->_bundles;
    }

    /**
     * Access the endUsers
     */
    protected function getEndUsers(): EndUserList {
        if (!$this->_endUsers) {
            $this->_endUsers = new EndUserList($this->version);
        }

        return $this->_endUsers;
    }

    /**
     * Access the endUserTypes
     */
    protected function getEndUserTypes(): EndUserTypeList {
        if (!$this->_endUserTypes) {
            $this->_endUserTypes = new EndUserTypeList($this->version);
        }

        return $this->_endUserTypes;
    }

    /**
     * Access the regulations
     */
    protected function getRegulations(): RegulationList {
        if (!$this->_regulations) {
            $this->_regulations = new RegulationList($this->version);
        }

        return $this->_regulations;
    }

    /**
     * Access the supportingDocuments
     */
    protected function getSupportingDocuments(): SupportingDocumentList {
        if (!$this->_supportingDocuments) {
            $this->_supportingDocuments = new SupportingDocumentList($this->version);
        }

        return $this->_supportingDocuments;
    }

    /**
     * Access the supportingDocumentTypes
     */
    protected function getSupportingDocumentTypes(): SupportingDocumentTypeList {
        if (!$this->_supportingDocumentTypes) {
            $this->_supportingDocumentTypes = new SupportingDocumentTypeList($this->version);
        }

        return $this->_supportingDocumentTypes;
    }

    /**
     * Magic getter to lazy load subresources
     *
     * @param string $name Subresource to return
     * @return \Twilio\ListResource The requested subresource
     * @throws TwilioException For unknown subresources
     */
    public function __get(string $name) {
        if (\property_exists($this, '_' . $name)) {
            $method = 'get' . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown subresource ' . $name);
    }

    /**
     * Magic caller to get resource contexts
     *
     * @param string $name Resource to return
     * @param array $arguments Context parameters
     * @return InstanceContext The requested resource context
     * @throws TwilioException For unknown resource
     */
    public function __call(string $name, array $arguments): InstanceContext {
        $property = $this->$name;
        if (\method_exists($property, 'getContext')) {
            return \call_user_func_array(array($property, 'getContext'), $arguments);
        }

        throw new TwilioException('Resource does not have a context');
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string {
        return '[Twilio.Numbers.V2.RegulatoryComplianceList]';
    }
}
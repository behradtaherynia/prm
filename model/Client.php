<?php

class Client extends WPCustomPostType
{

    /**
     * @param $ID
     */
    public function __construct(int $ID)
    {
        parent::__construct($ID);
    }


// region Class Getter Functions::

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getPostMeta('client_name', 'string');
    }

    /**
     * @return Type
     */
    public function getPrefix(): Type
    {
        global $occupationalPrefix;
        $ID = $this->getPostMeta('client_prefix_id', 'int');
        return ($ID > 0) ? $occupationalPrefix[$ID] : $occupationalPrefix[1];

    }

    /**
     * @return Attachment
     */
    public function getAvatar(): Attachment
    {
        return new Attachment(intval(get_post_thumbnail_id($this->getID())));
    }

    /**
     * @return ClientSpeciality[]
     */
    public function getSpecialty(): array
    {
        return ClientSpeciality::GetClientSpecialities($this->getID());
    }

    /**
     * @return string
     */
    public function getInstagram(): string
    {
        return $this->getPostMeta('client_instagram', 'string');
    }

    /**
     * @return string
     */
    public function getWebsiteUrl(): string
    {
        return $this->getPostMeta('client_website_url', 'string');
    }

    /**
     * @param bool $editMode
     * @return string
     */
    public function getAddress(bool $editMode = true): string
    {
        $result = $this->getPostMeta('client_address', 'string');
        return $editMode ? $result : apply_filters('the_content', $result);
    }

    /**
     * @param bool $editMode
     * @return string
     */
    public function getBusinessPhoneNumbers(bool $editMode = true): string
    {
        $result = $this->getPostMeta('client_business_phone_numbers', 'string');
        return $editMode ? $result : apply_filters('the_content', $result);
    }

    /**
     * @return string
     */
    public function getPrivatePhoneNumber(): string
    {
        return $this->getPostMeta('client_private_phone_number', 'string');
    }

    /**
     * @param bool $editMode
     * @return string
     */
    public function getWorkingHours(bool $editMode = true): string
    {
        $result = $this->getPostMeta('client_working_hours', 'string');
        return $editMode ? $result : apply_filters('the_content', $result);
    }

    /**
     * @return Attachment[]
     */
    public function getAttachments(): array
    {
        return parent::getAttachmentsBy('client_attachments');
    }

    /**
     * @return array
     */
    public function getServices(): array
    {
        return self::Get(
            'service',
            'Service',
            [
                'key' => 'clientID',
                'value' => $this->getID(),
                'compare' => '=',
                'type' => 'NUMERIC'
            ]
        );
    }

    /**
     * @return array
     */
    public function getActiveS(): array
    {
        return self::Get(
            'client',
            'Client',
            [
                'key' => 'Client_Status',
                'value' => 'active',
                'compare' => '=',
                'type' => 'CHAR'
            ]
        );
    }

    /**
     * @return array
     */
    public function getInactiveS(): array
    {
       return self::Get(
            'client',
            'Client',
            [
                'key' => 'Client_Status',
                'value' => 'inactive',
                'compare' => '=',
                'type' => 'CHAR'
            ]
        );
    }

    /**
     * @return WP_User_Query
     */
    public function getEmployees(): WP_User_Query
    {
        $args = array(
            'meta_query'     => array(
                array(
                    'key'     => 'clientID',
                    'value'   => $this->getID(),
                    'compare' => '=',
                    'type'    => 'NUMERIC',
                ),
            ),
            'fields'         => 'all_with_meta',
        );

// The User Query
        return new WP_User_Query( $args );
    }

    /**
     * @return array
     */
    public function getDossierS(): array
    {
        return self::Get(
            'dossier',
            'Dossier',
            [
                'key' => 'ClientID',
                'value' => $this->getID(),
                'compare' => '=',
                'type' => 'NUMERIC'
            ]
        );
    }

    /**
     * @return array
     */
    public function getPatientHistories(): array
    {
        return self::Get(
            'PatientHistory',
            'PatientHistory',
            [
                'key' => 'ClientID',
                'value' => $this->getID(),
                'compare' => '=',
                'type' => 'NUMERIC'
            ]
        );
    }

    public function getStatus()
    {
        $this->getPostMeta('ClientStatus', 'bool');
    }

// endregion

// region Class Update Functions::
    /**
     * @param string $name
     * @return bool
     */
    public function updateName(string $name): bool
    {
        return $this->updatePostMeta('client_name', $name);
    }

    /**
     * @param int $prefixID
     * @return bool
     */
    public function updatePrefix(int $prefixID): bool
    {
        return $this->updatePostMeta('client_prefix_id', $prefixID);
    }

    /**
     * @param string $instagram
     * @return bool
     */
    public function updateInstagram(string $instagram): bool
    {
        return $this->updatePostMeta('client_instagram', $instagram);
    }

    /**
     * @param string $website
     * @return bool
     */
    public function updateWebsiteUrl(string $website): bool
    {
        return $this->updatePostMeta('client_website_url', $website);
    }

    /**
     * @param string $address
     * @return bool
     */
    public function updateAddress(string $address): bool
    {
        return $this->updatePostMeta('client_address', $address);
    }

    /**
     * @param string $businessPhoneNumbers
     * @return bool
     */
    public function updateBusinessPhoneNumbers(string $businessPhoneNumbers): bool
    {
        return $this->updatePostMeta('client_business_phone_numbers', $businessPhoneNumbers);
    }

    /**
     * @param string $privatePhoneNumber
     * @return bool
     */
    public function updatePrivatePhoneNumber(string $privatePhoneNumber): bool
    {
        return $this->updatePostMeta('client_private_phone_number', $privatePhoneNumber);
    }

    /**
     * @param string $workingHours
     * @return bool
     */
    public function updateWorkingHours(string $workingHours): bool
    {
        return $this->updatePostMeta('client_working_hours', $workingHours);
    }

    /**
     * @param array $attachments
     * @return bool
     */
    public function updateAttachments(array $attachments): bool
    {
        return parent::updateAttachmentsBy($attachments, 'client_attachments', 15);
    }

    /**
     * @param bool $val
     * @return bool|true
     */
    public function updateStatus(bool $val): bool
    {
//        parent::updateStatus(); // TODO: Change the autogenerated stub
       return $this->updatePostMeta('ClientStatus', $val);
    }
//endregion

// region Class Static Functions::

    /**
     * @param array $metaQuery
     * @param int $count
     * @param SmartDate|null $from
     * @param SmartDate|null $to
     * @param string $orderBy
     * @param string $order
     * @return Client[]
     */
    public static function GetClientsList(array $metaQuery, int $count = -1, SmartDate $from = null, SmartDate $to = null, string $orderBy = 'date', string $order = 'DESC'): array
    {
        return parent::Get('client', 'Client', $metaQuery, $count, $from, $to, $orderBy, $order);
    }

    /**
     * @return Client[]
     */
    public static function GetAllClientsList(): array
    {
        return parent::GetAll('client', 'Client');
    }

    /**
     * @return bool
     */
    public static function IsThisClient(): bool
    {
        return WPInstrument::CheckCurrentCustomPostTypeInArray(self::GetServiceCustomPostTypes());

    }

    /**
     * @return string[]
     */
    public static function GetServiceCustomPostTypes(): array
    {
        return ['client'];
    }

// endregion


}
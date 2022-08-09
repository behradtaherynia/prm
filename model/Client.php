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
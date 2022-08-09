<?php

class Attachment extends WPCustomPost
{

    /**
     * Attachment constructor.
     * @param string|int $attachment :: هم میتواند آی دی فایل داده شود هم لینک
     */
    public function __construct($attachment)
    {
        if (is_numeric($attachment)) {
            $ID = $attachment;
        }
        else {
            $ID = attachment_url_to_postid($attachment);
        }
        parent::__construct($ID);
    }

// region Class Public Functions::

    /**
     * @return string
     */
    public function getAttachmentThumbnailURL(): string
    {
        return WPInstrument::GetFileThumbnail($this->getAttachmentURL());

    }

    /**
     * @return  string Attachment URL, otherwise ''.
     */
    public function getAttachmentURL(): string
    {
        $attachmentUrl = wp_get_attachment_url($this->getID());
        return !$attachmentUrl ? '' : $attachmentUrl;
    }

    /**
     * @return MediaType
     */
    public function getMediaType(): MediaType
    {
        return MediaType::FindMediaType($this->getAttachmentURL());
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
     * @return Attachment[]
     */
    public static function GetAttachmentsList(array $metaQuery, int $count = -1, SmartDate $from = null, SmartDate $to = null, string $orderBy = 'date', string $order = 'DESC'): array
    {
        return parent::Get('attachment', 'Attachment', $metaQuery, $count, $from, $to, $orderBy, $order);
    }

//endregion
}
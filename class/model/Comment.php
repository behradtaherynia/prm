<?php


namespace model;

//use Feed;
//use Step;
//use function current_time;
//use function get_comment;
//use function get_comment_meta;
//use function get_comments;
//use function update_comment_meta;
//use function wp_insert_comment;

class Comment
{


    private int $ID;
    private $commentInfo;

    /**
     * model\Comment constructor.
     * @param int $ID
     */
    private function __construct(int $ID)
    {
        $this->ID = $ID;
        $this->commentInfo = get_comment($ID);
    }


// region Class Getter Functions::

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @return int
     */
    public function getPostID(): int
    {
        return $this->commentInfo->comment_post_ID;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->commentInfo->comment_content;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        global $commentStatus;
        $statusID = $this->commentInfo->comment_approved;
        if ($statusID == 1)
            $statusID = 1;
        elseif ($statusID == 'trash')
            $statusID = 4;
        elseif ($statusID == 'spam')
            $statusID = 3;
        else
            $statusID = 2;
        return $commentStatus[$statusID];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        global $commentTypes;
        /* @var Type $type */
        foreach ($commentTypes as $type) {
            if ($type->getSlug() == $this->commentInfo->comment_type)
                return $type;
        }
        return false;
    }

    public function getUser()
    {
        $userID = $this->commentInfo->user_id;
        if ($userID == false)
            return false;
        return new User($userID);
    }

    /**
     * @return SmartDate
     */
    public function getDate(): SmartDate
    {
        return new SmartDate($this->commentInfo->comment_date, 'string');
    }

    /**
     * @return Comment|false
     */
    public function getParent()
    {
        $commentParentID = $this->commentInfo->comment_parent;
        return ($commentParentID != 0) ? new Comment($commentParentID) : false;
    }

    /**
     * @return Attachment[]
     */
    public function getAttachments(): array
    {
        $attachments = [];
        $serializedAttachmentsID = get_comment_meta($this->getID(), 'attachments', true);
        if ($serializedAttachmentsID) {
            $attachmentsIDArray = unserialize($serializedAttachmentsID);
            foreach ($attachmentsIDArray as $attachmentID) {
                $attachments[] = new Attachment($attachmentID);
            }
        }
        return $attachments;
    }

    /**
     * @return false|User
     */
    public function getMentionedUser()
    {
        $userID = intval(get_comment_meta($this->getID(), "mentioned_user_id", true));
        if ($userID == false || $userID == 0)
            return false;
        return new User($userID);
    }


//endregion

// region Class Update Functions::

//endregion


// region Class Update Functions::

    /**
     * @param string $userID
     * @return bool
     */
    public function updateMentionedUser(string $userID): bool
    {
        return $this->updateCommentMeta('mentioned_user_id', $userID);
    }

    /**
     * @param int[] $attachments
     * @return bool
     */
    public function updateAttachments(array $attachments): bool
    {
        return $this->updateCommentMeta('attachments', serialize($attachments));

    }

    /**
     * @param string $key
     * @param string $value
     * @return true
     * key not exist            => insert       => must return true
     * key exist but value new  => update value => must return true
     * key exist but value same => return false => we return true
     */
    private function updateCommentMeta(string $key, string $value): bool
    {
        update_comment_meta($this->getID(), $key, $value);
        return true;
    }
//endregion

// region Class Static Functions::

    /**
     * @param int $postID
     * @param string $commentContent
     * @param User $user
     * @param int $commentTypeID
     * @param int $commentParentID
     * @param int $commentStatusID
     * @return Comment|false
     */
    private static function Insert(int $postID, string $commentContent, User $user, int $commentTypeID = 1, int $commentParentID = 0, int $commentStatusID = 1)
    {
        $data = array(
            'comment_post_ID' => $postID,
            'comment_author' => $user->getDisplayName(),
            'comment_content' => $commentContent,
            'comment_type' => $commentTypeID,
            'user_id' => $user->getID(),
            'comment_date' => current_time('mysql'),
            'comment_parent' => $commentParentID,
            'comment_approved' => $commentStatusID
        );
        $newCommentID = wp_insert_comment($data);

        return $newCommentID ? new Comment($newCommentID) : false;
    }

    /**
     * @param string $message
     * @param int $taskID
     * @param int $mentionedUserID
     * @param array $attachments
     * @return Comment|false
     */
    public static function SendNewComment(string $message, int $taskID, int $mentionedUserID = 0, array $attachments = [])
    {
        $user = User::GetCurrentUser();
        $comment = self::Insert($taskID, $message, $user);
        if ($comment) {
            if ($mentionedUserID > 0)
                $comment->updateMentionedUser($mentionedUserID);
            if (count($attachments) > 0)
                $comment->updateAttachments($attachments);

            return $comment;
        }
        return false;
    }

    public static function ReplyComment(string $message, int $taskID, int $mentionedUserID = 0, array $attachments = [], $parentCommentID = 0)
    {
        $user = User::GetCurrentUser();
        $comment = self::Insert($taskID, $message, $user, 1, $parentCommentID);
        if ($comment) {
            if ($mentionedUserID > 0)
                $comment->updateMentionedUser($mentionedUserID);
            if (count($attachments) > 0)
                $comment->updateAttachments($attachments);
            return $comment;
        }
        return false;
    }

    private static function ConvertCommentsList($originalCommentsArray): array
    {
        $list = array();
        foreach ($originalCommentsArray as $comment) {
            $list[] = new Comment($comment->comment_ID);
        }
        return $list;
    }

    /**
     * @param $feedID
     * @return Comment[]
     */
    public static function GetFeedAllCommentsList(int $feedID): array
    {
        return self::GetCommentsList($feedID);
    }

    /**
     * @param Feed $feed
     * @return Comment|false
     */
    public static function FeedAutoChangeStepComment(Feed $feed)
    {
        $comment = new Comment();
        $comment->setPostID($feed->getID());
        $comment->setContent($feed->getPrevStep()->getName() . ' با موفقیت انجام شد.');
        $comment->setType('auto-comment');

        $_currentUser = User::GetCurrentUser();
        $comment->setUser($_currentUser);

        $_commentParent = new Comment(0);
        $comment->setCommentParent($_commentParent);

        $mentionedUsersList = [];
        $comment->setMentionedUsers($mentionedUsersList);


        return $comment->insert();

    }

    /**
     * @param Feed $feed
     * @param Step $fromStep
     * @return Comment|false
     */
    public static function FeedManualChangeStepComment(Feed $feed, Step $fromStep)
    {
        $comment = new Comment();
        $comment->setPostID($feed->getID());
        $comment->setContent('محتوا از مرحله ' . $fromStep->getName() . ' به مرحله ' . $feed->getStep()->getName() . ' انتقال داده شد.');
        $comment->setType('comment');

        $_currentUser = User::GetCurrentUser();
        $comment->setUser($_currentUser);

        $_commentParent = new Comment(0);
        $comment->setCommentParent($_commentParent);

        $mentionedUsersList = [];
        $comment->setMentionedUsers($mentionedUsersList);


        return $comment->insert();

    }

    /**
     * @param int $postID
     * @param array|null $metaQuery
     * @param int|null $parentID
     * @param array|null $commentTypes
     * @param int $count
     * @param SmartDate|null $from
     * @param SmartDate|null $to
     * @param string $orderBy
     * @param string $order
     * @return Comment[]
     */
    public static function GetCommentsList(int $postID = 0, array $metaQuery = null, int $parentID = null, array $commentTypes = null, int $count = -1, SmartDate $from = null, SmartDate $to = null, string $orderBy = 'date', string $order = 'DESC'): array
    {

        $args['post_id'] = $postID;
        $args['meta_query'] = ($metaQuery == null) ? '' : $metaQuery;
        $args['parent'] = ($parentID != null && $parentID > 0) ? $parentID : '';
        $args['type'] = ($commentTypes == null) ? '' : $commentTypes;
        $args['number'] = ($count < 1) ? '' : $count;
        $args['orderby'] = $orderBy;
        $args['order'] = $order;

        $dateQuery['after'] = ($from != null) ? $from->getDateStringGregorian() . ' 00:00:00' : '';
        $dateQuery['before'] = ($to != null) ? $to->getDateStringGregorian() . ' 23:59:00' : '';
        $dateQuery['inclusive'] = true;

        $args['date_query'] = ($from == null && $to == null) ? '' : $dateQuery;

//        $args=array(
//            'post_id'=>$postID
//        );
        $commentsArray = get_comments($args);

        return self::ConvertCommentsList($commentsArray);

    }

    /**
     * @param int $ID
     * @param string $name
     * @param string $slug
     * @param string $description
     * @return Comment|false
     */
    public static function Get(int $ID): Comment
    {
        if ($ID < 1)
            return false;
        else
            return new self($ID);
    }
//endregion


}
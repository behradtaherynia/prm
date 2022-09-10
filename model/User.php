<?php

class User extends WPClass
{
    private int $ID;
    private $userInfo;

    /**
     * User constructor.
     * @param int $ID
     */
    public function __construct(int $ID = 0)
    {
        if ($ID > 0) {
            $this->ID = $ID;
        } else {
            $currentUser = wp_get_current_user();
            $this->ID = $currentUser->ID;
        }
        $this->userInfo = get_userdata($this->ID);

    }

// region Class getter Functions::

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->ID;
    }

    /**
     * @return string | false
     */
    public function getFirstName(): string
    {

        return !$this->userInfo ? false : $this->userInfo->first_name;
    }

    /**
     * @return string | false
     */
    public function getLastName(): string
    {
        return !$this->userInfo ? false : $this->userInfo->last_name;
    }

    /**
     * @return string | false
     */
    public function getFullName(): string
    {
        return !$this->userInfo ? false : $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return !$this->userInfo ? false : $this->userInfo->display_name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        /*
         * (string) The author's field from the current author's DB object, otherwise an empty string.
         */
        return get_the_author_meta('description', $this->getID());
    }

    /**
     * @return false|string
     */
    public function getAvatarURL()
    {
        /*
         * (string|false) The URL of the avatar on success, false on failure.
         */
        return get_avatar_url($this->getID());
    }

    /**
     * @return string | false
     */
    public function getUsername(): string
    {
        return !$this->userInfo ? false : $this->userInfo->user_login;
    }

    /**
     * @return SmartDate
     */
    public function getUserRegistered(): SmartDate
    {
        return new SmartDate($this->userInfo->user_registered, 'string');
    }

    /**
     * @return string | false
     */
    public function getEmail(): string
    {

        return !$this->userInfo ? false : $this->userInfo->user_email;
    }

    /**
     * @return Role[]
     */
    public function getRoles(): array
    {
        return Role::GetUserRoles($this->getID());
    }

    /**
     * @param string $by
     * @return array of strings
     */
    public function getRolesListBy(string $by = 'name'): array
    {
        $rolesList = [];
        foreach ($this->getRoles() as $role) {
            if ($by == 'name') {
                $rolesList[] = strtolower($role->getName());
            } elseif ($by == 'slug') {
                $rolesList[] = $role->getSlug();
            }
        }
        return $rolesList;
    }

    /**
     * @return false | string
     */
    public function getTelegramChatID()
    {
        $telegramChatID = get_user_meta($this->getID(), 'telegram_chat_id', true);
        return ($telegramChatID == '') ? false : $telegramChatID;
    }

    /**
     * @return false|string
     */
    public function getMobile(bool $isGlobalMode = false)
    {
        $mobile = get_user_meta($this->getID(), 'mobile', true);
        if ($mobile == '')
            return false;
        else {
            if ($isGlobalMode)
                return '+98' . $mobile;
            else
                return '0' . $mobile;
        }
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
       $result=intval(get_user_meta($this->getID(), 'Client_ID'));
        return new Client($result);
    }
//endregion

// region Class Update Functions::

    /**
     * @param string $telegramID
     * @return bool
     */
    public function updateTelegramChatID(string $telegramID): bool
    {
        return update_user_meta($this->getID(), 'telegram_chat_id', $telegramID);
    }

    /**
     * @param string $mobile
     * @return bool
     */
    public function updateMobile(string $mobile): bool
    {
        return update_user_meta($this->getID(), 'mobile', $mobile);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function updateEmail(string $email): bool
    {
        $userInfo = array('ID' => $this->getID(), 'user_email' => $email);
        $result = wp_update_user($userInfo);
        return $result > 0;
    }

    /**
     * @param string $firstName
     * @return bool
     */
    public function updateFirstname(string $firstName): bool
    {
        $result = update_user_meta($this->getID(), 'first_name', $firstName);
        return $result == true;
    }

    /**
     * @param string $lastName
     * @return bool
     */

    public function updateLastname(string $lastName): bool
    {
        $result = update_user_meta($this->getID(), 'last_name', $lastName);
        return $result == true;
    }

    /**
     * @param string $nickName
     * @return bool
     */
    public function updateNickname(string $nickName): bool
    {
        $result = update_user_meta($this->getID(), 'nickname', $nickName);
        return $result > 0;
    }

    /**
     * @param string $Description
     * @return bool
     */
    public function updateDescription(string $Description): bool
    {
        $result = update_user_meta($this->getID(), 'Description', $Description);
        return $result > 0;
    }

    /**
     * @param string $userName
     * @return bool
     */
    public function updateUsername(string $userName): bool
    {
        global $wpdb;
        $result = $wpdb->update($wpdb->users, ['user_login' => $userName], ['ID' => $this->getID()]);
        return $result > 0;
    }

    public function updateClient(int $clientID): bool
    {
        return update_user_meta($this->getID(), 'Client_ID', $clientID);
    }


//endregion

// region Class Access Functions::

    /**
     * @param string $accessName
     * @return bool دسترسی‌هایی که به صورت پایه‌ای برای سایدبار داده شده را عمدتا بررسی می‌کند
     */
    public function roleBaseAccess(string $accessName): bool
    {
        global $roleBaseAccess;
        $userRolesList = $this->getRolesListBy('slug');
        foreach ($userRolesList as $roleName) {
            if (in_array($roleName, $roleBaseAccess[$accessName]))
                return true;
        }
        return false;
    }

    /**
     * @param Step $step
     * @return bool بررسی میکند که آیا کاربر با توجه به نقش‌هایی که دارد در لیست دسترسی‌های این مرحله است یا نه
     */
    public function hasAccessToStep(Step $step): bool
    {
        $stepRoles = $step->getRolesAccessStep();
        foreach ($this->getRoles() as $userRole) {
            foreach ($stepRoles as $stepRole) {
                if ($userRole->getSlug() == $stepRole->getSlug()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param Task $task
     * @return bool بررسی توانایی دسترسی به این مرحله و اینکه اساین شده است یا نه
     */
    private function hasAccessToDoTask(Task $task): bool
    {

        if ($this->hasAccessToStep($task->getStep())) {
            $userAssigned = $task->getUserAssignedTo();
            if ($userAssigned) {
                if ($userAssigned->isMe()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param Task $task
     * @return bool
     */
    public function hasAccessToEditor(Task $task): bool
    {

        if ($this->hasAccessToDoTask($task)) {
            if ($task->getStepStatus()->getID() == 2)
                return true;
        }
        return false;
    }

    /**
     * @param Task $task
     * @return bool
     */
    public function hasAccessToStartTask(Task $task): bool
    {
        if ($this->hasAccessToDoTask($task)) {
            if ($task->getStepStatus()->getID() == 1)
                return true;
        }
        return false;
    }

    /**
     * @param Task $task
     * @return bool
     */
    public function hasAccessToPauseTask(Task $task): bool
    {
        if ($this->hasAccessToDoTask($task)) {
            if ($task->getStepStatus()->getID() == 2)
                return true;
        }
        return false;
    }

    /**
     * @param Task $task
     * @return bool
     */
    public function hasAccessToResumeTask(Task $task): bool
    {
        if ($this->hasAccessToDoTask($task)) {
            if ($task->getStepStatus()->getID() == 4)
                return true;
        }
        return false;
    }

    /**
     * @param Task $task
     * @return bool
     */
    public function hasAccessToFinishTask(Task $task): bool
    {
        if ($this->hasAccessToDoTask($task)) {
            if ($task->getStepStatus()->getID() == 2)
                return true;
        }
        return false;
    }


    /**
     * @param string $capability
     * @return bool Whether the user has the given capability.
     */
    public function can(string $capability): bool
    {

        return user_can($this->getID(), $capability);

    }

    /**
     * این تابع آبجکت یوزر ساخته شده رو با کاربر فعیلی بررسی میکند
     * @return bool
     */
    public function isMe(): bool
    {
        if ($this->getID() == self::GetCurrentUser()->getID())
            return true;
        else
            return false;
    }

    /**
     * @return bool
     */
    public function isClient(): bool
    {
        return $this->can('client');
    }

    /**
     * @param $password
     * @return bool
     */
    public function checkPassword($password): bool
    {
        return wp_check_password($password, $this->userInfo->user_pass, $this->getID());
    }


// endregion

// region Class Protected Functions::

    /**
     * @return string[]
     */
    protected function getSortablePropertiesList(): array
    {
        return [
            'ID' => $this->getID(),
        ];
    }

// endregion

// region Class Public Static Functions::

    /**
     * Current User
     * @return User
     */
    public static function GetCurrentUser(): User
    {
        return new User(wp_get_current_user()->ID);

    }

    private static function GetUserByMetaData($metaKey, $metaValue)
    {

        $user_query = new WP_User_Query(
            array(
                'meta_key' => $metaKey,
                'meta_value' => $metaValue
            )
        );
        $users = $user_query->get_results();
        return (count($users) > 0) ? new User($users[0]->ID) : false;
    }

    /**
     * User constructor by any fields.
     * @param string $field
     * @param string $value
     * @param bool $isMeta
     * @return User | false
     */
    public static function GetUserBy(string $field, string $value, bool $isMeta = false)
    {
        if ($isMeta) {
            return self::GetUserByMetaData($field, $value);
        } else {
            $selectedUser = get_user_by($field, $value);
            return !$selectedUser ? false : new User($selectedUser->ID);
        }
    }

    /**
     * User constructor by any fields.
     * @param Role[] $roles
     * @return User[]
     */
    public static function GetAllUsersHaveThisRoles(array $roles): array
    {
        $rolesSlugArray = [];
        foreach ($roles as $role) {
            $rolesSlugArray[] = $role->getSlug();
        }

        return self::ConvertUsersList(get_users(array('role__in' => $rolesSlugArray)));
    }

    /**
     * @return User[]
     */
    public static function GetAllUsers(): array
    {
        $users = get_users();
        return self::ConvertUsersList($users);

    }

    /**
     * @return array
     */
    public static function GetAllUsersIDOnly(): array
    {
        $users = get_users();
        $list = array();
        foreach ($users as $user) {
            $list[] = $user->ID;
        }
        return $list;

    }

    /**
     * @param $originalUsersArray
     * @return User[]
     */
    public static function ConvertUsersList($originalUsersArray): array
    {
        $list = array();
        foreach ($originalUsersArray as $user) {
            $list[] = new User($user->ID);
        }
        return $list;
    }


// endregion


// region Old Class Functions::


    /**
     * @param SmartDate|null $feedCreatedDateStart
     * @param SmartDate|null $feedCreatedDateEnd
     * @param Step|null $productionStep
     * @param bool $edited
     * @param SmartDate|string $checkoutRequestDate :: 'all','paid','notPaid', date
     * @return Performance[]|array
     */
    public function getUserPerformance(SmartDate $feedCreatedDateStart = null, SmartDate $feedCreatedDateEnd = null, Step $productionStep = null, bool $edited = null, $checkoutRequestDate = 'all'): array
    {
        if ($this->getID() > 0)
            return Performance::UserPerformance($this, $feedCreatedDateStart, $feedCreatedDateEnd, $productionStep, $edited, $checkoutRequestDate);
        else
            return array();
    }

    /**
     * @param User $operator
     * @param int $amount
     * @param SmartDate $feedCreatedDateStart
     * @param SmartDate $feedCreatedDateEnd
     */
    public function paySalary(User $operator, SmartDate $feedCreatedDateStart, SmartDate $feedCreatedDateEnd)
    {
        if ($this->getID() > 0) {

            $notPaidPerformances = $this->getUserPerformance($feedCreatedDateStart, $feedCreatedDateEnd, null, null, 'notPaid');

            $totalAmount = 0;
            foreach ($notPaidPerformances as $performance) {
                if ($performance->isEdited()) {
                    $amount = 0;
                } else {
                    $amount = Settings::GetPerformanceAmount($performance->getProductionStep()->getID(), $performance->getFeed()->getType()->getID());
                }

                if ($performance->getProductionStep()->getID() == 13) {
                    $amount = $amount * count($performance->getFeed()->getFinalSlides());
                }
                $totalAmount += $amount;

                $performance->balance();
            }
            $checkout = new Checkout();
            $checkout->setUser($this);
            $checkout->setOperator($operator);
            $checkout->setAmount($totalAmount);
            $checkout = $checkout->checkoutRequest();
            $checkout->pay();

        }
    }

    /**
     * @return Checkout[]|false
     */
    public function getMyCheckoutsList()
    {
        return Checkout::GetCheckoutsList($this);
    }

    public function addJob(Feed $feed)
    {
        $performance = new Performance();
        $performance->setFeed($feed);
        $performance->setUser($this);
        $performance->setProductionStep($feed->getStep());
        return $performance->insert();
    }


    /**
     * @return Feed[] | false
     */
    public function feedsAssignToMe(): array
    {
        if ($this->getID() > 0)
            return InstagramPost::PostsAssignTo($this->getID());
        else
            return false;
    }

    /**
     * @return Feed[] | false
     */
    public function feedsInMySteps(): array
    {
        if ($this->getID() > 0)
            return Feed::FeedsInUserSteps($this);
        else
            return false;
    }
// endregion
}
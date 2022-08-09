<?php


class WPMetaBox
{
    private array $customPostTypes;
    private string $metaBoxName;
    private string $metaBoxTitle;
    private string $metaBoxCallbackFunctionName;
    private string $metaBoxContext;
    private string $metaBoxPriority;
    private string $postSaveCallbackFunctionName = '';
    private string $postMetaSaveCallbackFunctionName;
    private bool $autoSave;

    /**
     * WPAddAction constructor.
     * @param string[] $customPostTypes
     * @param string $metaBoxName
     * @param string $metaBoxTitle
     * @param string $metaBoxCallbackFunctionName
     * @param string $metaBoxContext :: 'normal', 'side', and 'advanced'
     * @param string $metaBoxPriority :: 'high', 'core', 'default', or 'low'
     * @param string $postSaveCallbackFunctionName
     * @param string $postMetaSaveCallbackFunctionName
     * @param bool $autoSave
     */
    public function __construct(array $customPostTypes, string $metaBoxName, string $metaBoxTitle, string $metaBoxCallbackFunctionName, string $metaBoxContext, string $metaBoxPriority, string $postSaveCallbackFunctionName, string $postMetaSaveCallbackFunctionName, bool $autoSave = false)
    {
        $this->customPostTypes = $customPostTypes;
        $this->metaBoxName = $metaBoxName;
        $this->metaBoxTitle = $metaBoxTitle;
        $this->metaBoxCallbackFunctionName = $metaBoxCallbackFunctionName;
        $this->metaBoxContext = $metaBoxContext;
        $this->metaBoxPriority = $metaBoxPriority;
        $this->postSaveCallbackFunctionName = $postSaveCallbackFunctionName;
        $this->postMetaSaveCallbackFunctionName = $postMetaSaveCallbackFunctionName;
        $this->autoSave = $autoSave;

        add_action('add_meta_boxes', function () {
            foreach ($this->customPostTypes as $postType) {
                add_meta_box($this->metaBoxName . '_meta_box', $this->metaBoxTitle, $this->metaBoxCallbackFunctionName, $postType, $this->metaBoxContext, $this->metaBoxPriority);
            }
        });
        if ($this->autoSave)
            add_action('post_updated', [$this, '_saveData'], 10, 2);

    }

    public function _saveData($post_id, $post)
    {
        if ($this->autoSave) {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }

            $canContinue = false;
            foreach ($this->customPostTypes as $postType) {
                if ($postType == $post->post_type) {
                    $canContinue = true;
                    break;
                }
            }
            if ($canContinue) {
                ($this->postMetaSaveCallbackFunctionName)($post_id);
                remove_action('post_updated', [$this, '_saveData']);
                ($this->postSaveCallbackFunctionName)($post_id);
                add_action('post_updated', [$this, '_saveData']);
            }

        }
    }


}
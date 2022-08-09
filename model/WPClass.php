<?php


abstract class WPClass
{


    abstract protected function getSortablePropertiesList();

    /**
     * @param $property
     * @return mixed
     */
    public function getSortablePropertyValue($property)
    {
        $sortablePropertiesList = $this->getSortablePropertiesList();
        if (!array_key_exists($property, $sortablePropertiesList))
            $property = 'ID';
        return $sortablePropertiesList[$property];
    }


    /**
     * @param $list
     * @param $on
     * @param string $order
     * @return array
     */
    public static function MultiSort($list, $on, string $order = 'ASC'): array
    {

        if ($order == 'DESC') {
            usort($list,
                function ($x, $y) use ($on) {
                    return $y->getSortablePropertyValue($on) - $x->getSortablePropertyValue($on);
                }
            );
        } else {
            usort($list,
                function ($x, $y) use ($on) {
                    return $x->getSortablePropertyValue($on) - $y->getSortablePropertyValue($on);
                }
            );
        }

        return $list;
    }

    public static function Merge($array1, $array2): array
    {
        return array_merge($array1, $array2);
    }

    public static function Search($array, $property, $value)
    {
        foreach ($array as $item) {
            if ($item->$property == $value) {
                return $item;
            }

        }
        return false;
    }

    /**
     * @param string $className for
     * @param array $dbObjectsArray :: این همان آرایه‌ای است که از طریق توابع وردپرس لیست محتواها را گرفته‌ایم
     * @return array
     */
    protected static function ConvertToObjectList(string $className, array $dbObjectsArray): array
    {
        $list = array();
        foreach ($dbObjectsArray as $originalPost) {
            $post = new $className($originalPost->ID);
            $list[] = $post;
        }
        return $list;
    }
}
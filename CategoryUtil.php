<?php

/*
 * This file is part of PHP CS Fixer.
 */

class CategoryUtil
{
    /**
     * 组合一维数组.
     *
     * @param array  $cate
     * @param string $html
     * @param int    $parentId
     * @param int    $level
     *
     * @return array
     */
    public static function unlimitedForLevel($cate, $html = '|--', $parentId = 0, $level = 0)
    {
        $arr = [];
        foreach ($cate as $v) {
            if ($v['parentId'] == $parentId) {
                $v['level'] = $level + 1;
                $v['html']  = str_repeat($html, $level);
                $arr[]      = $v;
                //将子类合并到和父类的同一个数组里
                $arr = array_merge($arr, self::unlimitedForLevel($cate, $html, $v['id'], $level + 1));
            }
        }

        return $arr;
    }

    /**
     * 组合多维数组.
     *
     * @param array  $cate
     * @param string $name
     * @param int    $parentId
     *
     * @return array
     */
    public static function unlimitedForLayer($cate, $name = 'child', $parentId = 0)
    {
        $arr = [];
        foreach ($cate as $v) {
            if ($v['parentId'] == $parentId) {
                $v[$name] = self::unlimitedForLayer($cate, $name, $v['id']);
                $arr[]    = $v;
            }
        }

        return $arr;
    }

    /**
     * 传递一个子类ID返回所有的父级.
     *
     * @param array $cate
     * @param int   $id
     *
     * @return array
     */
    public static function getParents($cate, $id)
    {
        $arr = [];
        foreach ($cate as $v) {
            if ($v['id'] == $id) {
                $arr[] = $v;
                $arr   = array_merge(self::getParents($cate, $v['parentId']), $arr);
            }
        }

        return $arr;
    }

    /**
     * 传递一个父级ID返回所有的子类.
     *
     * @param array $cate
     * @param int   $parentId
     *
     * @return array
     */
    public static function getChilds($cate, $parentId)
    {
        $arr = [];
        foreach ($cate as $v) {
            if ($v['parentId'] == $parentId) {
                $arr[] = $v;
                $arr   = array_merge($arr, self::getChilds($cate, $v['id']));
            }
        }

        return $arr;
    }

    /**
     * 传递一个父级ID返回所有的子类id.
     *
     * @param array $cate
     * @param int   $parentId
     *
     * @return array
     */
    public static function getChildsId($cate, $parentId)
    {
        $arr = [];
        foreach ($cate as $v) {
            if ($v['parentId'] == $parentId) {
                $arr[] = $v['id'];
                $arr   = array_merge($arr, self::getChildsId($cate, $v['id']));
            }
        }

        return $arr;
    }
}

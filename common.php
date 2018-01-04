<?php

/**
 * @Author:   mingzhongshui
 * @Email:    in1993summer@163.com
 * @Date:     2018-01-04 17:30:31
 * @Describe: php
 * @Last Modified time: 2018-01-04 17:31:45
 */


/**
 * 多维数组树形结构
 */
function tree($data, $pid = 0)
{
    $children = [];
    foreach ($data as $key => $value) {

        if ($value['parentid'] == $pid) {
            $children[] = $value;
        }
    }
    if (empty($children)) {
        return null;
    }

    foreach ($children as $key => $value) {
        $chid = tree($data, $value['id']);
        if ($chid != null) {
            $children[$key]['childs'] = $chid;
        }
    }
    return $children;
}

 /**格式化数组输出**/
function p($arr)
{
    echo "<pre>";
    echo '========================开始========================';
    echo "</br>";
    if( $arr ){
        print_r($arr);
    } else {
        echo '此值为空';
    }
    echo "</br>";
    echo '========================结束========================';
    echo "</pre>";
}

 /**格式化数组输出并终止程序**/
function pe($arr)
{
    echo "<pre>";
    echo '========================开始========================';
    echo "</br>";
    if( $arr ){
        print_r($arr);
    } else {
        echo '此值为空';
    }
    echo "</br>";
    echo '========================结束========================';
    echo "</pre>";
    exit;
}
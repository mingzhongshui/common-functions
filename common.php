<?php

/**
 * @Author:   mingzhongshui
 * @Email:    in1993summer@163.com
 * @Date:     2018-01-04 17:30:31
 * @Describe: php
 * @Last Modified time: 2018-01-05 10:51:56
 */


/**
 * 无限分类生成多维数组树形结构
 * 结果：
 * [
 *     [
 *         'id' => '1',
 *         'name' => 'test',
 *         'childs' => [
 *             [
 *                 'id' => '5',
 *                 'name' => 'echo',
 *                 'childs' => [
 *                     [
 *                         'id'    => '9',
 *                          'name' => 'printf',
 *                     ]
 *             ]
 *         ]
 *     ]
 * ]
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

/**
 * 递归运算返回值创建html树结构
 * @param  array $tree 树形数组
 * @return html 
 * 中国
 *     北京
 *         朝阳区
 *     河南
 *         郑州市
 *         洛阳市
 * 美国
 *     纽约
 *     加利福尼亚   
 */
function creatHtmlTree1($tree)
{
    // $htmlTree为普通局部变量;
    $htmlTree = '<ul>';
    
    foreach ($tree as $key => $value) {
        // 给变量$htmlTree累加值
        $htmlTree .= "<li><span><i class='icon-folder-open'></i>{$value['name']} </span> <a href=''>Goes somewhere</a>";
        if (isset($value['childs']) && is_array($value['childs'])) {
            // 递归中每次的结果累加到$htmlTree
            $htmlTree .= creatHtmlTree($value['childs']);
        } 
        $htmlTree .= "</li>";
    }
    // 赋值ul闭合标签
    $htmlTree .= "</ul>";
    return $htmlTree;
}

/**
 * 递归运算静态变量创建html树结构
 * @param  array $tree 树形数组
 * @return html 
 * 中国
 *     北京
 *         朝阳区
 *     河南
 *         郑州市
 *         洛阳市
 * 美国
 *     纽约
 *     加利福尼亚   
 */
function creatHtmlTree($tree)
{
    // 声明静态变量
    static $htmlTree;
    $htmlTree .= '<ul>';
    foreach ($tree as $key => $value) {
        // 给静态$htmlTree变量累加值
        $htmlTree .= "<li><span><i class='icon-folder-open'></i>{$value['name']} </span> <a href=''>Goes somewhere</a>";
        if (isset($value['childs']) && is_array($value['childs'])) {
            creatHtmlTree($value['childs']);
        } 
        $htmlTree .= "</li>";
    }
    // 赋值ul闭合标签
    $htmlTree .= "</ul>";
    return $htmlTree;
}
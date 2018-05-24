<?php

/**
 * @Author:   mingzhongshui
 * @Email:    in1993summer@163.com
 * @Date:     2018-01-04 17:30:31
 * @Describe: php
 * @Last Modified time: 2018-05-24 11:23:12
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


/**
 * 引用JS
 * @param string $js JS文件
 * @return string
 */
function js( $js )
{
    $is_relative = ( strpos( $js, 'http' ) === FALSE );
    if ( $is_relative ) $js = base_url( "resource/js/{$js}");
    return "<script type=\"text/javascript\" src=\"{$js}\"></script>";
}

// 引用图片
function images( $images )
{
    $is_relative = ( strpos( $images, 'http' ) === FALSE );
    if ( $is_relative ) $images = base_url( "resource/images/{$images}");
    return $images;
}


/**
 * 引用CSS
 * @param string $css CSS文件
 * @param string $extra 属性 (id="" class="")
 * @param string $theme 主题
 * @return string
 */
function css( $css, $extra = '', $theme = '' )
{
    $is_relative = ( strpos( $css, 'http' ) === FALSE );
    // CSS
    // 当前主题
    if ( $is_relative ) {
        $css = base_url( "resource/css/{$css}" );
    }
    if($extra) {
        return "<link {$extra} rel=\"stylesheet\" type=\"text/css\" href=\"{$css}\" media=\"all\" />";
    }
    return "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$css}\" media=\"all\" />";

}


/**
 * 弹出提示信息
 * @param string $msg 信息
 * @param string $url 跳转地址
 */
function alert( $msg = '', $url = '' )
{
    if ( $url != '' ) {
        if ( $msg != '' ) {
            echo "<script type=\"text/javascript\">alert('$msg');window.location.href='$url';</script>";
        } else {
            echo "<script type=\"text/javascript\">window.location.href='$url';</script>";
        }
    } else {
        echo "<script>alert('$msg');</script>";
    }

}


/**
 * 下载文件方法
 * @param  string $file_name 文件名
 * @param  string $path      文件路径
 * @author 命中水、
 * @date(2016.12.26)
 */
function download_flie($file_name, $path)
{
    header("Content-type:text/html;charset=utf-8");
    $file_name = iconv("utf-8","gb2312",$file_name);
    $file_path = $path.$file_name;
    if(!file_exists($file_path))
    {
        echo "没有该文件文件";
        return ;
    }
    $fp = fopen($file_path,"r");
    $file_size = filesize($file_path);
    //下载文件需要用到的头
    Header("Content-type: application/octet-stream");
    Header("Accept-Ranges: bytes");
    Header("Accept-Length:".$file_size);
    Header("Content-Disposition: attachment; filename=".$file_name);
    $buffer = 1024;
    $file_count = 0;
    while( !feof( $fp ) && $file_count < $file_size)
    {
        $file_con    = fread($fp,$buffer);
        $file_count += $buffer;
        echo $file_con;
    }
    fclose($fp);
}


/**
 * 上传图片处理
 * @param  string $targetPath 相对路径
 * @param  array $file_ext    允许上传文件后缀
 * @return json(file_url完整路径;url相对路径 )
 * @author 命中水、
 * @date(2016-9-29 am)
 */
function plupload($targetPath, $file_ext)
{
    if(empty($targetPath) || empty($file_ext) || !is_array($file_ext)) {
        return '不是正确的文件类型';
    }
    $tempFile = $_FILES["file"]["tmp_name"];
    if (!file_exists($targetPath)) {
        @mkdir($targetPath);
        chmod($targetPath, 0777);
    }
    $file_name   = $_REQUEST['name'];
    $fileParts   = pathinfo($file_name);
    $date        = date('YmdHis', time());
    $targetFile  = rtrim($targetPath,'/').'/'.$date.'_'.$file_name;
    $targetFiles = iconv("UTF-8", "GBK//IGNORE",$targetFile);
    $url         = base_url(substr($targetFile,1));
    if (in_array($fileParts['extension'],$file_ext)) {
        if(move_uploaded_file($tempFile,$targetFiles)){
            $file_message = array(
                'file_url' => $url,
                'url'      => substr($targetFile,1)
                );
            return json_encode($file_message);
        }else{
            echo '啊哦！文件移动失败了,请检查文件路径';
            return FALSE;
        }
    } else {
        echo '文件类型不匹配哈！';
        return FALSE;
    }
}


/**
 * 计算时间差
 * 例：几秒前、几分钟前、几小时前等
 * @param  intval $time 当前时间戳
 * @return string
 */
function time_tranx($time) {
    $dur = time() - $time;
    if ($dur < 0) {
        return $time;
    } else {
        if ($dur < 60) {
            return $dur . '秒前';
        } else {
            if ($dur < 3600) {
                return floor($dur / 60) . '分钟前';
            } else {
                if ($dur < 86400) {
                    return floor($dur / 3600) . '小时前';
                } else {
                    if ($dur < 259200) {//3天内
                        return floor($dur / 86400) . '天前';
                    } else {
                        return date('Y-m-d H:i:s', $time);
                    }
                }
            }
        }
    }
}


/**
 * 取得文件绝对路径
 * @param  string $file_path 文件路径
 * 例：/uploads/business_code/20161104032818.jpg
 * @return string            文件绝对路径
 * 例：E:\WWW\lims_cy_new\web\uploads\business_code\20161104032818.jpg
 * @author 命中水、
 * @date(2016-11-4 am)
 */
function get_absolute_path( $file_path )
{
    $file_path = str_replace('/', '\\', $file_path);
    $file_path = getcwd() . $file_path;  //转换绝对路径
    $absolute_path = iconv("UTF-8", "GBK",$file_path);  //调整编码
    return $absolute_path;
}
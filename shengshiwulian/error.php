<?php
namespace shengshiwulian;

class Error {

    /**
     * 打印错误信息
     * @return string
     */
    public static function message($error_number, $error_message, $error_file, $error_line) {
        $str = '
        <style>
        .table { 
                border: 1px solid #DDDDDD; 
                background-color: transparent;
                border-collapse: collapse;
                border-spacing: 0;
        }
        .table th { 
                font-weight:normal;
                background-color:#DBEFF9; 
                color:#333;
                border-left: 1px solid #DDDDDD;
                border-top: 1px solid #DDDDDD;
        }
        .table td { 
                line-height:30px;
                background-color:#FFF; 
                color:#333;
                border-left: 1px solid #DDDDDD;
                border-top: 1px solid #DDDDDD;
        }
        </style>
        ';
        $str .= '<table width="100%" class="table">
                    <tr>
                            <th width="200px">错误标识</th>
                            <td>' . $error_number . '</td>
                    </tr>
                    <tr>
                            <th width="200px">报错行数</th>
                            <td>' . $error_line . '行</td>
                    </tr>
                    <tr>
                            <th width="200px">报错文件</th>
                            <td>' . $error_file . '</td>
                    </tr>
                    <tr>
                            <th width="200px">错误信息</th>
                            <td>' . $error_message . '</td>
                    </tr>
                </table>';
        static::write($error_message, $error_file, $error_line);
        exit($str);
    }

    /**
     * 错误提示
     * @param type $error_message
     * @param type $error_file
     */
    public static function show($error_message, $error_file, $date = null) {
        $date = $date == null ? date('Y-m-d H:i:s') : $date;
        $str = '<style>
        .table { 
                border: 1px solid #DDDDDD; 
                background-color: transparent;
                border-collapse: collapse;
                border-spacing: 0;
        }
        .table th { 
                font-weight:normal;
                background-color:#DBEFF9; 
                color:#333;
                border-left: 1px solid #DDDDDD;
                border-top: 1px solid #DDDDDD;
        }
        .table td { 
                line-height:30px;
                background-color:#FFF; 
                color:#333;
                border-left: 1px solid #DDDDDD;
                border-top: 1px solid #DDDDDD;
        }
        </style>';
        $str .= '<table width="100%" class="table">
                    <tr>
                            <th width="200px">报错文件</th>
                            <td>' . $error_file . '</td>
                    </tr>
                    <tr>
                            <th width="200px">错误信息</th>
                            <td>' . $error_message . '</td>
                    </tr>
                </table>';
        static::write($error_message, $error_file, 0, $date);
        exit($str);
    }

    /**
     * 日志写入
     * @param type $error_message
     * @param type $error_file
     * @param type $error_line
     * @param type $date
     */
    public static function write($error_message, $error_file, $error_line = 0, $date = null) {
        $date = $date == null ? date('Y-m-d H:i:s') : $date;
        $dir = dirname(dirname(__FILE__)) . '/runtime/log';
        if (!is_dir($dir) && !mkdir($dir, 0777, true)) {
            die('runtime/log目录创建失败');
        }
        $filename = dirname(dirname(__FILE__)) . '/runtime/log/' . date('Y-m-d') . '.txt';
        if (!is_file($filename) && !touch($filename)) {
            die('runtime/log/' . date('Y-m-d') . '文件创建失败');
        }
        return file_put_contents($filename, $date . ' 文件：' . $error_file . ' 行数：' . $error_line . ' 错误信息：' . $error_message . (PATH_SEPARATOR == ':' ? "\n" : "\r\n"), FILE_APPEND);
    }

}

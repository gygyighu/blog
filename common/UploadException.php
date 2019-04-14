<?php
/**
 * Created by PhpStorm.
 * User: 10765
 * Date: 2019/4/14
 * Time: 13:14
 */
namespace common;
use Throwable;

class UploadException extends \Exception {
    public function __construct($code)
    {
        $message = $this->codeToMessage($code);
        parent::__construct($message, $code);
    }
    private function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "文件过大，请重新上传";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "文件上传不完整，请重新上传";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "文件未上传";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;
            default:
                $message = "未知错误";
                break;
        }
        return $message;
    }
}
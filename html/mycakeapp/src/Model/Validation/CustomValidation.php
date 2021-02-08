<?php

namespace App\Model\Validation;

use Cake\Validation\Validation;

// カスタムバリデーションの作成
class CustomValidation extends Validation
{
    // 空白文字のみの場合falseを返す
    public function NotBlankOnly($value)
    {
        return !(bool)preg_match("/^[ 　\t\r\n]+$/", $value);
    }
    // 半角英数字のみ許可
    public function HalfSizeAlphanumericOnly($value)
    {
        return (bool)preg_match(" /^[a-zA-Z0-9]+$/", $value);
    }
    // 半角英字と半角のスペースのみ許可
    public function HalfSizeAlphabetAndSpaceOnly($value)
    {
        return (bool)preg_match(" /^[a-zA-Z ]+$/", $value);
    }
}

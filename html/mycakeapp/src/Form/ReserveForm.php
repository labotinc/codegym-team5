<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class ReserveForm extends Form
{
  protected function _buildSchema(Schema $schema)
  {
    // フィールドの設定です。
    return $schema
      ->addField('use_point', 'int')
      ->addField('registered_order', 'int');
  }

  protected function _buildValidator(Validator $validator)
  {
    return $validator
      ->notEmpty('use_point', '選択されていません')
      ->greaterThan('use_point', 0, 'ポイント利用は1ポイント以上を入力してください')
      ->integer('use_point', '半角数字以外の文字が使われています')
      ->notEmpty('registered_order', '選択されていません')
      ->integer('registered_order', null);
  }

  protected function _execute(array $data)
  {
    return true;
  }
}

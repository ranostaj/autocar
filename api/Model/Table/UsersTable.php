<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class UsersTable extends Table
{

    public function validationDefault(Validator $validator)
    {
        $validator = $this->validationPassword($validator);
        $validator->notEmpty('username', 'Užívateľský e-mail je povinný');
        return $validator;

    }


    public function validationPassword(Validator $validator)
    {

        $validator->add('password', [
            'size' => ['rule' => ['lengthBetween', 8, 20], 'message'=>'Heslo musí mať minimálne 8 znakov']]);

        return $validator;

    }

    public function validationCreate(Validator $validator)
    {
        $validator = $this->validationDefault($validator);
        $validator->add('username',   [
            'uniq'=>[
                'rule'=>[$this, 'uniqUsername'],
                'message'=>"Užívateľ s týmto e-mailom už existuje"
            ]
        ]);
        return $validator;

    }

    /**
     * @param Validator $validator
     * @return Validator
     */
    public function validationUpdate(Validator $validator)
    {

        $validator->notEmpty('username', 'Užívateľský e-mail je povinný');
        $validator->add('username',   [
            'uniq'=>[
                'rule'=>[$this, 'uniqUsername'],
                'message'=>"Užívateľ s týmto e-mailom už existuje"
            ]
        ]);
        return $validator;

    }


    public function uniqUsername($value, array $context) {
        if($context['newRecord']) {
           return  $this->find()->where(['username'=>$value])->first() ? false : true;
        } else {
           return  $this->find()->where(['username'=>$value,'id !='=>$context['data']['id'] ])->first() ? false : true;
        }
    }



}
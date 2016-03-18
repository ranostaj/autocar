<?php
namespace App\Model\Table;

use App\Model\Entity\Order;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orders Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Statuses
 * @property \Cake\ORM\Association\BelongsTo $Operations
 */
class OrdersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('orders');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Operations', [
            'foreignKey' => 'operation_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('Accessories', [
            'foreignKey' => 'order_id',
            'dependent'=>true
        ]);

        $this->hasMany('Images', [
            'foreignKey' => 'order_id',
        ]);

        $this->hasMany('Files');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');


        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->allowEmpty('email');

        $validator
            ->requirePresence('phone', 'create')
            ->notEmpty('phone');


        $validator
            ->requirePresence('typ', 'create')
            ->notEmpty('typ');

        $validator
            ->add('base_price', 'valid', ['rule' => 'decimal'])
            ->requirePresence('base_price', 'create')
            ->notEmpty('base_price');

        $validator
            ->add('total_price', 'valid', ['rule' => 'decimal'])
            ->requirePresence('total_price', 'create')
            ->notEmpty('total_price');

        $validator
            ->requirePresence('managed_through', 'create')
            ->notEmpty('managed_through');


        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['status_id'], 'Statuses'));
        $rules->add($rules->existsIn(['operation_id'], 'Operations'));
        return $rules;
    }
}

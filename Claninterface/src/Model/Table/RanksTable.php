<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ranks Model
 *
 * @property \App\Model\Table\PlayersTable&\Cake\ORM\Association\HasMany $Players
 *
 * @method \App\Model\Entity\Rank get($primaryKey, $options = [])
 * @method \App\Model\Entity\Rank newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Rank[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Rank|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Rank saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Rank patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Rank[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Rank findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RanksTable extends Table
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

        $this->setTable('ranks');
        $this->setDisplayField('speekName');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Players', [
            'foreignKey' => 'rank_id',
        ]);
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('speekName')
            ->maxLength('speekName', 255)
            ->requirePresence('speekName', 'create')
            ->notEmptyString('speekName');

        $validator
            ->integer('sort')
            ->notEmptyString('sort');

        $validator
            ->integer('isComando')
            ->notEmptyString('isComando');

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
        $rules->add($rules->isUnique(['name']));

        return $rules;
    }
}

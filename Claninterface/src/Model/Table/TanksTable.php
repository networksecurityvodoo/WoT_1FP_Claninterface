<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tanks Model
 *
 * @property \App\Model\Table\TanktypesTable&\Cake\ORM\Association\BelongsTo $TankTypes
 * @property \App\Model\Table\StatisticsTable&\Cake\ORM\Association\HasMany $Statistics
 *
 * @method \App\Model\Entity\Tank get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tank newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tank[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tank|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tank saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tank patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tank[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tank findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TanksTable extends Table
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

        $this->setTable('tanks');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Tanktypes', [
            'foreignKey' => 'tankType_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Statistics', [
            'foreignKey' => 'tank_id',
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
            ->notEmptyString('name');

        $validator
            ->integer('tier')
            ->requirePresence('tier', 'create')
            ->notEmptyString('tier');

        $validator
            ->decimal('expDef')
            ->notEmptyString('expDef');

        $validator
            ->decimal('expFrag')
            ->notEmptyString('expFrag');

        $validator
            ->decimal('expSpot')
            ->notEmptyString('expSpot');

        $validator
            ->decimal('expDamage')
            ->notEmptyString('expDamage');

        $validator
            ->decimal('expWinRate')
            ->notEmptyString('expWinRate');

        $validator
            ->scalar('nation')
            ->maxLength('nation', 255)
            ->requirePresence('nation', 'create')
            ->notEmptyString('nation');

        $validator
            ->integer('premium')
            ->requirePresence('premium', 'create')
            ->notEmptyString('premium');

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
        $rules->add($rules->existsIn(['tankType_id'], 'TankTypes'));

        return $rules;
    }
}

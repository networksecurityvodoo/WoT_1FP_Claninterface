<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Inactives Model
 *
 * @property \App\Model\Table\PlayersTable&\Cake\ORM\Association\BelongsTo $Players
 *
 * @method \App\Model\Entity\Inactive get($primaryKey, $options = [])
 * @method \App\Model\Entity\Inactive newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Inactive[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Inactive|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Inactive saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Inactive patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Inactive[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Inactive findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InactivesTable extends Table
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

        $this->setTable('inactives');
        $this->setDisplayField('player_id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Players', [
            'foreignKey' => 'player_id',
            'joinType' => 'INNER',
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
            ->integer('battle')
            ->notEmptyString('battle');

        $validator
            ->scalar('reason')
            ->allowEmptyString('reason');

        $validator
            ->dateTime('offline')
            ->requirePresence('offline', 'create')
            ->notEmptyDateTime('offline');

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
        $rules->add($rules->existsIn(['player_id'], 'Players'));

        return $rules;
    }
}

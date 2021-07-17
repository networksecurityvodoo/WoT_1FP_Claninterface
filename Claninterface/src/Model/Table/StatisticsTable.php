<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Statistics Model
 *
 * @property \App\Model\Table\PlayersTable&\Cake\ORM\Association\BelongsTo $Players
 * @property \App\Model\Table\TanksTable&\Cake\ORM\Association\BelongsTo $Tanks
 *
 * @method \App\Model\Entity\Statistic get($primaryKey, $options = [])
 * @method \App\Model\Entity\Statistic newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Statistic[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Statistic|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Statistic saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Statistic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Statistic[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Statistic findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StatisticsTable extends Table
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

        $this->setTable('statistics');
        $this->setDisplayField('tank_id');
        $this->setPrimaryKey(['tank_id', 'player_id', 'date', 'battletype']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Players', [
            'foreignKey' => 'player_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tanks', [
            'foreignKey' => 'tank_id',
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
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->scalar('battletype')
            ->maxLength('battletype', 255)
            ->requirePresence('battletype', 'create')
            ->notEmptyString('battletype');

        $validator
            ->integer('damage')
            ->requirePresence('damage', 'create')
            ->notEmptyString('damage');

        $validator
            ->integer('spotted')
            ->requirePresence('spotted', 'create')
            ->notEmptyString('spotted');

        $validator
            ->integer('frags')
            ->requirePresence('frags', 'create')
            ->notEmptyString('frags');

        $validator
            ->integer('droppedCapturePoints')
            ->requirePresence('droppedCapturePoints', 'create')
            ->notEmptyString('droppedCapturePoints');

        $validator
            ->integer('battle')
            ->notEmptyString('battle');

        $validator
            ->integer('win')
            ->requirePresence('win', 'create')
            ->notEmptyString('win');

        $validator
            ->integer('in_garage')
            ->notEmptyString('in_garage');

        $validator
            ->integer('shots')
            ->notEmptyString('shots');

        $validator
            ->integer('xp')
            ->notEmptyString('xp');

        $validator
            ->integer('hits')
            ->notEmptyString('hits');

        $validator
            ->integer('survived')
            ->notEmptyString('survived');

        $validator
            ->integer('tanking')
            ->notEmptyString('tanking');

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
        $rules->add($rules->existsIn(['tank_id'], 'Tanks'));

        return $rules;
    }
}

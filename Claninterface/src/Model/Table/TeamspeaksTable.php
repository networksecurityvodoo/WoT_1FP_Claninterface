<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Teamspeaks Model
 *
 * @property \App\Model\Table\PlayersTable&\Cake\ORM\Association\BelongsTo $Players
 *
 * @method \App\Model\Entity\Teamspeak get($primaryKey, $options = [])
 * @method \App\Model\Entity\Teamspeak newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Teamspeak[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Teamspeak|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Teamspeak saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Teamspeak patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Teamspeak[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Teamspeak findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TeamspeaksTable extends Table
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

        $this->setTable('teamspeaks');
        $this->setDisplayField('id');
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
            ->dateTime('start')
            ->requirePresence('start', 'create')
            ->notEmptyDateTime('start');

        $validator
            ->dateTime('end')
            ->requirePresence('end', 'create')
            ->notEmptyDateTime('end');

        $validator
            ->integer('reason')
            ->requirePresence('reason', 'create')
            ->notEmptyString('reason');

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

<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Meetings Model
 *
 * @property \App\Model\Table\ClansTable&\Cake\ORM\Association\BelongsTo $Clans
 * @property \App\Model\Table\MeetingparticipantsTable&\Cake\ORM\Association\HasMany $Meetingparticipants
 *
 * @method \App\Model\Entity\Meeting get($primaryKey, $options = [])
 * @method \App\Model\Entity\Meeting newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Meeting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Meeting|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Meeting saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Meeting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Meeting[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Meeting findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MeetingsTable extends Table
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

        $this->setTable('meetings');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clans', [
            'foreignKey' => 'clan_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Meetingparticipants', [
            'foreignKey' => 'meeting_id',
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
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->time('start')
            ->requirePresence('start', 'create')
            ->notEmptyTime('start');

        $validator
            ->time('end')
            ->requirePresence('end', 'create')
            ->notEmptyTime('end');

        $validator
            ->integer('cloned')
            ->notEmptyString('cloned');

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
        $rules->add($rules->existsIn(['clan_id'], 'Clans'));

        return $rules;
    }
}

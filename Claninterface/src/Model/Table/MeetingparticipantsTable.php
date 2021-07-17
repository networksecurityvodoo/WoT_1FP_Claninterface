<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Meetingparticipants Model
 *
 * @property \App\Model\Table\PlayersTable&\Cake\ORM\Association\BelongsTo $Players
 * @property \App\Model\Table\MeetingsTable&\Cake\ORM\Association\BelongsTo $Meetings
 *
 * @method \App\Model\Entity\Meetingparticipant get($primaryKey, $options = [])
 * @method \App\Model\Entity\Meetingparticipant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Meetingparticipant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Meetingparticipant|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Meetingparticipant saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Meetingparticipant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Meetingparticipant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Meetingparticipant findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MeetingparticipantsTable extends Table
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

        $this->setTable('meetingparticipants');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Players', [
            'foreignKey' => 'player_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Meetings', [
            'foreignKey' => 'meeting_id',
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
            ->time('joined')
            ->requirePresence('joined', 'create')
            ->notEmptyTime('joined');

        $validator
            ->scalar('channel')
            ->requirePresence('channel', 'create')
            ->notEmptyString('channel');

        $validator
            ->integer('wot')
            ->requirePresence('wot', 'create')
            ->notEmptyString('wot');

        $validator
            ->scalar('teamspeak')
            ->maxLength('teamspeak', 255)
            ->requirePresence('teamspeak', 'create')
            ->notEmptyString('teamspeak');

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
        $rules->add($rules->existsIn(['meeting_id'], 'Meetings'));

        return $rules;
    }
}

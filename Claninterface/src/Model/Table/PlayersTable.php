<?php
namespace App\Model\Table;

use Cake\ORM\Association\HasMany;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use PhpParser\Node\Stmt\HaltCompiler;

/**
 * Players Model
 *
 * @property \App\Model\Table\ClansTable&\Cake\ORM\Association\BelongsTo $Clans
 * @property \App\Model\Table\RanksTable&\Cake\ORM\Association\BelongsTo $Ranks
 * @property \App\Model\Table\InactivesTable&\Cake\ORM\Association\HasMany $Inactives
 * @property \App\Model\Table\StatisticsTable&\Cake\ORM\Association\HasMany $Statistics
 * @property \App\Model\Table\TeamspeaksTable&\Cake\ORM\Association\HasMany $Teamspeaks
 * @property \App\Model\Table\TokensTable&\Cake\ORM\Association\HasMany $Tokens
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 * @property MeetingparticipantsTable&HasMany $Meetingparticipants
 *
 * @method \App\Model\Entity\Player get($primaryKey, $options = [])
 * @method \App\Model\Entity\Player newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Player[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Player|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Player saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Player patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Player[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Player findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PlayersTable extends Table
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

        $this->setTable('players');
        $this->setDisplayField('nick');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Clans', [
            'foreignKey' => 'clan_id',
        ]);
        $this->belongsTo('Ranks', [
            'foreignKey' => 'rank_id',
        ]);
        $this->hasMany('Inactives', [
            'foreignKey' => 'player_id',
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('Statistics', [
            'cascadeCallbacks' => true,
            'foreignKey' => 'player_id',
        ]);
        $this->hasMany('Teamspeaks', [
            'foreignKey' => 'player_id',
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('Tokens', [
            'foreignKey' => 'player_id',
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'player_id',

        ]);
        $this->hasMany('Meetingparticipants', [
            'foreignKey' => 'player_id',
            'cascadeCallbacks' => true,
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
            ->scalar('nick')
            ->maxLength('nick', 255)
            ->requirePresence('nick', 'create')
            ->notEmptyString('nick');

        $validator
            ->dateTime('joined')
            ->requirePresence('joined', 'create')
            ->notEmptyDateTime('joined');

        $validator
            ->dateTime('lastBattle')
            ->requirePresence('lastBattle', 'create')
            ->notEmptyDateTime('lastBattle');

        $validator
            ->integer('battle')
            ->notEmptyString('battle');

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
        $rules->add($rules->existsIn(['rank_id'], 'Ranks'));

        return $rules;
    }
}

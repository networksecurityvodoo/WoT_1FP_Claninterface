<?php
namespace App\Model\Table;

use App\Model\Entity\Clan;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clans Model
 *
 * @property \App\Model\Table\PlayersTable&\Cake\ORM\Association\HasMany $Players
 *
 * @method Clan get($primaryKey, $options = [])
 * @method Clan newEntity($data = null, array $options = [])
 * @method Clan[] newEntities(array $data, array $options = [])
 * @method Clan|false save(EntityInterface $entity, $options = [])
 * @method Clan saveOrFail(EntityInterface $entity, $options = [])
 * @method Clan patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Clan[] patchEntities($entities, array $data, array $options = [])
 * @method Clan findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ClansTable extends Table
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

        $this->setTable('clans');
        $this->setDisplayField('short');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Players', [
            'foreignKey' => 'clan_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 255)
            ->requirePresence('icon', 'create')
            ->notEmptyString('icon');

        $validator
            ->scalar('short')
            ->maxLength('short', 10)
            ->requirePresence('short', 'create')
            ->notEmptyString('short');

        $validator
            ->integer('cron')
            ->notEmptyString('cron');

        return $validator;
    }
}

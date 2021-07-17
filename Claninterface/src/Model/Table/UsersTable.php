<?php
namespace App\Model\Table;

use Cake\Auth\AbstractPasswordHasher;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\PlayersTable&\Cake\ORM\Association\BelongsTo $Players
 * @property &\Cake\ORM\Association\HasMany $Tokens
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Players', [
            'foreignKey' => 'player_id',
        ]);
        $this->hasMany('Tokens', [
            'foreignKey' => 'user_id',
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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password')
            ->add('password', [
                'isSecurePassword' => [
                    'rule' => function ($value, $context) {
                        return strlen($value) >= 3;
                    },
                    'message' => __("Ihr Passwort sollte mindestens 3 Zeichen haben. Bitte überprüfen Sie Ihre Eingaben."),
                ],
            ]);
        $validator->add('password_confirm', [
            'equalToPassword' => [
                'rule' => function ($value, $context) {
                    return $value === $context['data']['password'];
                },
                'message' => __("Ihre Passwörter stimmen nicht überein. Bitte überprüfen Sie Ihre Eingaben."),
            ],
        ]);
        $validator->add('password_old', [
            'equalToPassword' => [
                'rule' => function ($value, $context) {
                    $DefaultPasswordHasher = new DefaultPasswordHasher();
                    $user = $this->get($context['data']['id']);

                    return $DefaultPasswordHasher->check($value, $user->password);
                },
                'message' => __("Ihr altes Passwort ist nicht richtig. Bitte überprüfen Sie Ihre Eingaben."),
            ],
        ]);
        $validator
            ->integer('admin')
            ->notEmptyString('admin');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['player_id'], 'Players'));

        return $rules;
    }
}

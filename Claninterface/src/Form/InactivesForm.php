<?php


namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class InactivesForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema
            ->addField('player', 'string')
            ->addField('reason', ['type' => 'text'])
            ->addField('offline', ['type' => 'string'])
            ->addField("unkown",["type"=>"boolean"]);
    }
    protected function _execute(array $data)
    {
        // Send an email.
        return true;
    }

}

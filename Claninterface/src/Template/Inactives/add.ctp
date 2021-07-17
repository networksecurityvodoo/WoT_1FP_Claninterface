<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Form\InactivesForm $inactivesForm
 * @var string $js_player_array JS Array with Playernames
 */
?>
<div class="inactives form large-9 medium-8 columns content">
    <?= $this->Form->create($inactivesForm) ?>
    <fieldset>
        <legend><?= __('Abmelden') ?></legend>
        Du möchtest dich von World of Tanks zurückziehen.<br/>
        Wenn du länger nicht spielen spielen willst, melde dich ab, um nicht vom Clan ausgeschlossen zu werden.<br />
        Dies gilt nicht für normale Aussetzer wie einen Urlaube<br />
        <br />
        <?php
            echo $this->Form->control('player', ['id'=>'player','label'=>'Wie heißt du?','type' => 'Text']);
            echo $this->Form->control('reason',['label'=>"Willst du uns sagen warum du nicht da sein wirst?"]);
            echo $this->Form->control('offline', [
                  'class'               => 'form-control datepicker-here',
                  'label'               => 'Bis wann bist du voraussichtlich Offline?',
                  'id'                  => 'offline',
                  'type'                => 'Text',
                  'data-language'       => 'de',
                  'data-date-format'    => 'dd.mm.yy',
                  'value'               => date('d.m.y'),
                  'empty'               =>'empty'
                  ]);
            echo $this->Form->control("unkown",[
                 'label'               => 'Ich weiß nicht wann ich zurück komme',
            ])
        ?>
    </fieldset>
    <?= $this->Form->button(__('Abmelden')) ?>
    <?= $this->Form->end() ?>
</div>

<script>
    $(document).ready(function (){
        $( "#player" ).autocomplete({
            source: <?= $js_player_array ?>
        });
       $("#offline").datepicker({
           minDate: 0,
           firstDay: 1,
           dateFormat: "dd.mm.yy",
           changeYear: true,
           changeMonth: true,
           monthNamesShort: [ "Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez" ]
       });
    });
</script>

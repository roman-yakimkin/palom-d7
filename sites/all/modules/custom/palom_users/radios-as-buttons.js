(function ($) {

  Drupal.behaviors.palom_users = {
    attach: function(context, settings) {

      var roles_texts = new Map([
        ['owner','Вы являетесь сотрудником или владельцем какой-либо организации, связанной с паломничеством и можете добавить свою организацию на сайт.<br/ > Также, если ваша организация - паломническая служба, то вы можете добавить свои паломнические маршруты'],
        ['owner-ps','Вы являетесь сотрудником или владельцем <strong>паломнической службы</strong> и можете добавить свою на сайт свою паломническую службу, а также размещать маршруты'],
        ['owner-a','Вы обеспечиваете <strong>проживание паломников</strong> и можете добавить на сайт свою организацию'],
        ['owner-f','Вы обеспечиваете <strong>питание паломников</strong> и можете добавить на сайт свою организацию'],
        ['owner-t','Вы обеспечиваете <strong>перевозку паломников</strong> и можете добавить на сайт свою организацию'],
        ['mouse_leave', 'Выберите свою роль на данном сайте. Если вы выберите роль, отличную от обычного пользователя, вы сможете размещать дополнительную информацию']
      ]);

      $('#edit-my-role').attr('data-toggle', 'buttons');

      $('#edit-my-role label')
        .mouseenter(function(){
          var $this = $(this);


          var this_key = $this.attr('for').replace('edit-my-role-', '');
          if (roles_texts.has(this_key)){
            console.log(roles_texts.get(this_key));
            $('.form-item-my-role .help-block').html(roles_texts.get('mouse_leave') + '<p>' + roles_texts.get(this_key) + '</p>');
          }
          else {
            $('.form-item-my-role .help-block').html(roles_texts.get('mouse_leave'));
          }
        })
          .mouseleave(function(){
            $('.form-item-my-role .help-block').html(roles_texts.get('mouse_leave'));

          })
    }
  };

}(jQuery));


<?php
    use yii\widgets\ActiveForm;
?>

<section class="registration__user">

  <h1>Регистрация аккаунта</h1>
  <div class="registration-wrapper">

    <?php $form = ActiveForm::begin([
        'id' => 'registration',
        'options' => ['class'=>'registration__user-form form-create', 'name'=>'signup', 'method'=>'post', 'action' => "#"],
//        'enableAjaxValidation' => true,
//        'errorCssClass' => 'has-error',
//        'errorSummaryCssClass' => 'registration__text-error',
        ]); ?>
      <div class="field-container field-container--registration">
        <label>Электронная почта</label>
        <?= $form->field($model, 'email')->textInput([
                'class' => "input textarea",
                'type' => 'email',
                'placeholder' => "somebody@mail.ru",
                'template' => "{input}\n{error}",
                ])
                ->label(false)

        ?>
      </div>
      <div class="field-container field-container--registration">
        <label>Ваше имя</label>
        <?= $form->field($model, 'login')->textInput([
                'class' => "input textarea",
                'type' => 'text',
                'placeholder' => "Мамедов Кумар",
                'template' => "{input}\n{error}",
                ])
                ->label(false)
        ?>
      </div>

      <div class="field-container field-container--registration">
        <label>Город проживания</label>
          <?= $form->field($model, 'city_id')
                   ->dropDownList($model->cities_list, ['class' => 'multiple-select input town-select registration-town'])
                   ->label($label = false)
          ?>
      </div>

      <div class="field-container field-container--registration">
        <label>Пароль</label>
        <?= $form->field($model, 'password')->textInput([
                'class' => "input textarea",
                'type' => 'password',
                'template' => "{input}\n{error}",
                ])
                ->label(false)
        ?>
      </div>


<!-- КАК ВЫВЕСТИ СООБЩЕНИЕ ОБ ОШИБКЕ КРАСНЫМ ЦВЕТОМ ?
    <span class="registration__text-error">Введите валидный адрес электронной почты</span>-->

      <button class="button button__registration" type="submit">Cоздать аккаунт</button>

    <?php ActiveForm::end(); ?>

  </div>
  <div class="clipart-woman">
    <img src="./img/clipart-woman.png" width="238" height="450">
  </div>
  <div class="clipart-message">
    <div class="clipart-message-text">
      <h2>Знаете ли вы, что?</h2>
      <p>После регистрации вам будет доступно более
        двух тысяч заданий из двадцати разных категорий.</p>
      <p>В среднем, наши исполнители зарабатывают
        от 500 рублей в час.</p>
    </div>
  </div>

</section>

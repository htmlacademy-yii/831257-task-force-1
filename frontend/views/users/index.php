<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;
?>
<section class="user__search">
    <?php foreach ($builders as $builder) { ?>
        <div class="content-view__feedback-card user__search-wrapper">
          <div class="feedback-card__top">
            <div class="user__search-icon">
              <a href="user.html"><img src="./img/man-glasses.jpg" width="65" height="65"></a>
              <span>
                <?=
                    \Yii::t('app',
                    '{n, plural, =0{# заданий} =1{# задание} one{# задание} few{# задания} many{# заданий} other{нет заданий}}',
                    ['n' => $builder->tasks_count]);
                ?>
              </span>
              <span>
                <?=
                    \Yii::t('app',
                    '{n, plural, =0{# отзывов} =1{# отзыв} one{# отзыв} few{# отзывов} many{# отзывов} other{нет отзывов}}',
                    ['n' => $builder->opinions_count]);
                ?>
              </span>
            </div>
            <div class="feedback-card__top--name user__search-card">
              <p class="link-name">
                <?= Html::tag('a', $builder->login, ['class'=>"link-regular", 'href'=>Url::to("user/".$builder->id)])?>
              </p>
              <span></span><span></span><span></span><span></span><span class="star-disabled"></span>
              <b><?= $builder->raiting; ?></b>
              <p class="user__search-content">
                <?= $builder->about_me; ?>
              </p>
            </div>
            <span class="new-task__time">Был на сайте <?= $builder->getPeriodLastVizit(); ?></span>
          </div>
          <div class="link-specialization user__search-link--bottom">
            <?php $categories = $builder->categories; ?>
            <?php foreach ($categories as $category) { ?>
                <a href="browse.html" class="link-regular"><?= $category->category; ?></a>
            <?php } ?>
          </div>
        </div>
    <?php } ?>
</section>

<section class="search-task">
    <div class="search-task__wrapper">
        <?php
            $form = ActiveForm::begin([
                'id' => 'search_tasks_id',
                'options' => ['class' => 'search-task__form', 'name' => 'search_tasks', 'method' => 'post', 'action' => "#"]
            ]);
        ?>

        <fieldset class="search-task__categories">
          <legend>Категории</legend>

            <?= $form->field($model, 'categories_check', ['template' => "{input}"])->
              checkboxList($cats,
                [
                  'item' => function ($index, $label, $name, $checked, $value) {
                              return '
                                <label class="checkbox__legend">
                                  <input class="visually-hidden checkbox__input" type="checkbox" name='.$name.
                                    ' value='.$value.
                                    (($checked)?" checked":"").
                                  '>'.
                                  '<span>'.$label.'</span>
                                </label>
                              ';
                            }
                ]
              );
            ?>
        </fieldset>

        <fieldset class='search-task__categories'>
          <legend>Дополнительно</legend>
          <div>
            <?= $form->field($model, 'free')->checkbox([
                  'class' => 'visually-hidden checkbox__input',
                  'label' => '<span>Сейчас свободен</span>',
                  'labelOptions' => ['class' => 'checkbox__legend']
                  ]
                );
            ?>
          </div>
          <div>
            <?= $form->field($model, 'online')->checkbox([
                  'class' => 'visually-hidden checkbox__input',
                  'label' => '<span>Сейчас онлайн</span>',
                  'labelOptions' => ['class' => 'checkbox__legend']
                  ]
                );
            ?>
          </div>
          <div>
            <?= $form->field($model, 'reviews')->checkbox([
                  'class' => 'visually-hidden checkbox__input',
                  'label' => '<span>Есть отзывы</span>',
                  'labelOptions' => ['class' => 'checkbox__legend']
                  ]
                );
            ?>
          </div>
          <div>
            <?= $form->field($model, 'chosen')->checkbox([
                  'class' => 'visually-hidden checkbox__input',
                  'label' => '<span>В избранном</span>',
                  'labelOptions' => ['class' => 'checkbox__legend']
                  ]
                );
            ?>
          </div>
        </fieldset>

        <div class="field-container">
            <label class="search-task__name">Поиск по названию</label>
            <?= $form->field($model, 'search')->textInput([
                'class' => "input-middle input",
                'type' => 'search'])
                ->label($label = false)?>
          </div>

          <button class="button" type="submit">Искать</button>

        <?php ActiveForm::end(); ?>

    </div>

</section>

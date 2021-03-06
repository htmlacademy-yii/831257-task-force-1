<?php

require_once '../../vendor/autoload.php';

use TaskForce\logic\Task;
use TaskForce\ex\TaskArgumentsExeption;

assert(Task::getStatusesMap() == ['new' => 'Новое',
                                    'canceled' => 'Отменено',
                                    'work' => 'В работе',
                                    'done' => 'Выполнено',
                                    'failed' => 'Провалено'
                                   ],
                                   'Warning: StatusesMap');

assert(Task::getActionsMap() == ['cancel' => 'Отмененить',
                                   'complete' => 'Выполнено',
                                   'respond' => 'Откликнуться',
                                   'refuse' => 'Отказаться'
                                  ],
                                  'Warning: ActionsMap');


$Task1 = new Task(1,2);

try {

$Task1->status = Task::STATUS_NEW;

assert($Task1->getNextStatus('cancel') == Task::STATUS_CANCELED, 'Warning: cancel action');
assert($Task1->getNextStatus('respond222') == Task::STATUS_WORK, 'Warning: respond action');

$Task1->status = Task::STATUS_WORK;

assert($Task1->getNextStatus('complete') == Task::STATUS_DONE, 'Warning: complete action');
assert($Task1->getNextStatus('refuse') == Task::STATUS_FAILED, 'Warning: refuse action');


assert($Task1->getAvaliableAction('new', 1)->getInternalName() == Task::ACTION_CANCEL, 'Warning: cancel action');
assert($Task1->getAvaliableAction('new', 2)->getInternalName() == Task::ACTION_RESPOND, 'Warning: respond action');

assert($Task1->getAvaliableAction('work', 1)->getInternalName() == Task::ACTION_COMPLETE, 'Warning: complete action');
assert($Task1->getAvaliableAction('work', 2)->getInternalName() == Task::ACTION_REFUSE, 'Warning: refuse action');

}

catch (TaskArgumentsExeption $e) {
    error_log("Ошибка аргумента класса Task: " . $e->getMessage());
}

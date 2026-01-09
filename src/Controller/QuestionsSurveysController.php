<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * QuestionsSurveys Controller
 *
 * @property \App\Model\Table\QuestionsSurveysTable $QuestionsSurveys
 * @method \App\Model\Entity\QuestionsSurvey[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QuestionsSurveysController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Surveys', 'Questions'],
        ];
        $questionsSurveys = $this->paginate($this->QuestionsSurveys);

        $this->set(compact('questionsSurveys'));
    }

    /**
     * View method
     *
     * @param string|null $id Questions Survey id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $questionsSurvey = $this->QuestionsSurveys->get($id, [
            'contain' => ['Surveys', 'Questions'],
        ]);

        $this->set(compact('questionsSurvey'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $questionsSurvey = $this->QuestionsSurveys->newEmptyEntity();
        if ($this->request->is('post')) {
            $questionsSurvey = $this->QuestionsSurveys->patchEntity($questionsSurvey, $this->request->getData());
            if ($this->QuestionsSurveys->save($questionsSurvey)) {
                $this->Flash->success(__('The questions survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The questions survey could not be saved. Please, try again.'));
        }
        $surveys = $this->QuestionsSurveys->Surveys->find('list', ['limit' => 200])->all();
        $questions = $this->QuestionsSurveys->Questions->find('list', ['limit' => 200])->all();
        $this->set(compact('questionsSurvey', 'surveys', 'questions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Questions Survey id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $questionsSurvey = $this->QuestionsSurveys->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $questionsSurvey = $this->QuestionsSurveys->patchEntity($questionsSurvey, $this->request->getData());
            if ($this->QuestionsSurveys->save($questionsSurvey)) {
                $this->Flash->success(__('The questions survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The questions survey could not be saved. Please, try again.'));
        }
        $surveys = $this->QuestionsSurveys->Surveys->find('list', ['limit' => 200])->all();
        $questions = $this->QuestionsSurveys->Questions->find('list', ['limit' => 200])->all();
        $this->set(compact('questionsSurvey', 'surveys', 'questions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Questions Survey id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $questionsSurvey = $this->QuestionsSurveys->get($id);
        if ($this->QuestionsSurveys->delete($questionsSurvey)) {
            $this->Flash->success(__('The questions survey has been deleted.'));
        } else {
            $this->Flash->error(__('The questions survey could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

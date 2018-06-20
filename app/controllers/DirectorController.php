<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class DirectorController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for director
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Director', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id_director";

        $director = Director::find($parameters);
        if (count($director) == 0) {
            $this->flash->notice("The search did not find any director");

            $this->dispatcher->forward([
                "controller" => "director",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $director,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a director
     *
     * @param string $id_director
     */
    public function editAction($id_director)
    {
        if (!$this->request->isPost()) {

            $director = Director::findFirstByid_director($id_director);
            if (!$director) {
                $this->flash->error("director was not found");

                $this->dispatcher->forward([
                    'controller' => "director",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id_director = $director->id_director;

            $this->tag->setDefault("id_director", $director->id_director);
            $this->tag->setDefault("nombre_director", $director->nombre_director);
            $this->tag->setDefault("fecha_nacimiento", $director->fecha_nacimiento);
            
        }
    }

    /**
     * Creates a new director
     */
    public function createAction()
    {
        /*if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "director",
                'action' => 'index'
            ]);

            return;
        }*/

        $director = new Director();
      // Almacenar y comprobar errores
      $success = $director->save(
          $this->request->getPost(),
          [
              "nombre_director",
              "fecha_nacimiento",
          ]
      );

        //$director = new Director();
        //$director->nombreDirector = $this->request->getPost("nombre_director");
        //$director->añoNacimiento = $this->request->getPost("fecha_nacimiento");
        

       /* if (!$director->save()) {
            foreach ($director->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "director",
                'action' => 'new'
            ]);

            return;
        }*/

        if ($success) {
            $this->flash->success("Director registrado correctamente");

            $this->dispatcher->forward([
            'controller' => "director",
            'action' => 'search'
            ]);
        }else{

            $this->flash->success("Director no pudo ser registrado correctamente");

            $this->dispatcher->forward([
            'controller' => "director",
            'action' => 'search'
            ]);
        }
    }

    /**
     * Saves a director edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "director",
                'action' => 'index'
            ]);
            return;
        }

        $id_director = $this->request->getPost("id_director");
        $director = Director::findFirstByid_director($id_director);

        if (!$director) {
            $this->flash->error("director does not exist " . $id_director);
            $this->dispatcher->forward([
                'controller' => "director",
                'action' => 'index'
            ]);
            return;
        }

        //$director->nombreDirector = $this->request->getPost("nombre_director");
        //$director->añoNacimiento = $this->request->getPost("fecha_nacimiento");
        

        /*if (!$director->save()) {

            foreach ($director->getMessages() as $message) {
                $this->flash->error($message);
            }*/

      $director = new Director();
      // Almacenar y comprobar errores
      $success = $director->save(
          $this->request->getPost(),
          [
              "id_director",
              "nombre_director",
              "fecha_nacimiento",
          ]);

        if ($success) {
            $this->flash->success("Director fue actualizado correctamente");
            $this->dispatcher->forward([
                'controller' => "director",
                'action' => 'edit',
                'params' => [$director->id_director]
            ]);
        }else{
        $this->flash->success("Director no pudo ser actualizado correctamente");
        $this->dispatcher->forward([
            'controller' => "director",
            'action' => 'index'
        ]);
        }
    }

    /**
     * Deletes a director
     *
     * @param string $id_director
     */
    public function deleteAction($id_director)
    {
        $director = Director::findFirstByid_director($id_director);
        if (!$director) {
            $this->flash->error("director was not found");

            $this->dispatcher->forward([
                'controller' => "director",
                'action' => 'index'
            ]);

            return;
        }

        if (!$director->delete()) {

            foreach ($director->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "director",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("director was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "director",
            'action' => "index"
        ]);
    }

}

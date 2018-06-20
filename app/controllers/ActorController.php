<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class ActorController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for actor
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Actor', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id_actor";

        $actor = Actor::find($parameters);
        if (count($actor) == 0) {
            $this->flash->notice("No se encontro ningun actor");

            $this->dispatcher->forward([
                "controller" => "actor",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $actor,
            'limit'=> 8,
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
     * Edits a actor
     *
     * @param string $id_actor
     */
    public function editAction($id_actor)
    {
        if (!$this->request->isPost()) {

            $actor = Actor::findFirstByid_actor($id_actor);
            if (!$actor) {
                $this->flash->error("actor was not found");

                $this->dispatcher->forward([
                    'controller' => "actor",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id_actor = $actor->id_actor;

            $this->tag->setDefault("id_actor", $actor->id_actor);
            $this->tag->setDefault("nombre_actor", $actor->nombre_actor);
            $this->tag->setDefault("fecha_nacimiento", $actor->fecha_nacimiento);
            
        }
    }

    /**
     * Creates a new actor
     */
    public function createAction()
    {
       
    $actor = new Actor();
      // Almacenar y comprobar errores
      $success = $actor->save(
          $this->request->getPost(),
          [
              "nombre_actor",
              "fecha_nacimiento",
          ]);

        /*if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "actor",
                'action' => 'index'
            ]);

            return;
        }

        $actor = new Actor();
        $actor->nombreActor = $this->request->getPost("nombre_actor");
        $actor->añoNacimiento = $this->request->getPost("fecha_nacimiento");
        

        if (!$actor->save()) {
            foreach ($actor->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "actor",
                'action' => 'new'
            ]);

            return;
        }*/

        if ($success) {
        $this->flash->success("Actor registrado correctamente");

        $this->dispatcher->forward([
            'controller' => "actor",
            'action' => 'search'
        ]);
    }else{
        $this->flash->success("Actor no pudo ser registrado");

        $this->dispatcher->forward([
            'controller' => "actor",
            'action' => 'search'
        ]);
    }   
    }

    /**
     * Saves a actor edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "actor",
                'action' => 'index'
            ]);

            return;
        }

        $id_actor = $this->request->getPost("id_actor");
        $actor = Actor::findFirstByid_actor($id_actor);

        if (!$actor) {
            $this->flash->error("actor no existe " . $id_actor);

            $this->dispatcher->forward([
                'controller' => "actor",
                'action' => 'index'
            ]);

            return;
        }

        //$actor->nombreActor = $this->request->getPost("nombre_actor");
        //$actor->añoNacimiento = $this->request->getPost("fecha_nacimiento");
        

        /*if (!$actor->save()) {

            foreach ($actor->getMessages() as $message) {
                $this->flash->error($message);
            }*/

        $success = $actor->save(
          $this->request->getPost(),
          [
              "id_actor",
              "nombre_actor",
              "fecha_nacimiento",
          ]);

        //}

        if ($success) {
        
           
        $this->flash->success("actor fue actualizado correctamente");

         $this->dispatcher->forward([
                'controller' => "actor",
                'action' => 'edit',
                'params' => [$actor->id_actor]
            ]);
        

       } else{

        $this->flash->success("actor no pudo ser actualizado correctamente");

        $this->dispatcher->forward([
            'controller' => "actor",
            'action' => 'index'
        ]);
       }
    }

    /**
     * Deletes a actor
     *
     * @param string $id_actor
     */
    public function deleteAction($id_actor)
    {
        $actor = Actor::findFirstByid_actor($id_actor);
        if (!$actor) {
            $this->flash->error("actor was not found");

            $this->dispatcher->forward([
                'controller' => "actor",
                'action' => 'index'
            ]);

            return;
        }

        if (!$actor->delete()) {

            foreach ($actor->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "actor",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("actor was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "actor",
            'action' => "index"
        ]);
    }

}

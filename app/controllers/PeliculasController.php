<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PeliculasController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for peliculas
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Peliculas', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "id_pelicula";

        $peliculas = Peliculas::find($parameters);
        if (count($peliculas) == 0) {
            $this->flash->notice("The search did not find any peliculas");

            $this->dispatcher->forward([
                "controller" => "peliculas",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $peliculas,
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
     * Edits a pelicula
     *
     * @param string $id_pelicula
     */
    public function editAction($id_pelicula)
    {
        if (!$this->request->isPost()) {

            $pelicula = Peliculas::findFirstByid_pelicula($id_pelicula);
            if (!$pelicula) {
                $this->flash->error("pelicula was not found");

                $this->dispatcher->forward([
                    'controller' => "peliculas",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id_pelicula = $pelicula->id_pelicula;

            $this->tag->setDefault("id_pelicula", $pelicula->id_pelicula);
            $this->tag->setDefault("nombre_pelicula", $pelicula->nombre_pelicula);
            $this->tag->setDefault("fecha_pelicula", $pelicula->fecha_pelicula);
            $this->tag->setDefault("genero_pelicula", $pelicula->genero_pelicula);
            $this->tag->setDefault("id_director", $pelicula->id_director);
            
        }
    }

    /**
     * Creates a new pelicula
     */
    public function createAction()
    {

    $peliculas = new Peliculas();
      // Almacenar y comprobar errores
      $success = $peliculas->save(
          $this->request->getPost(),
          [
              "nombre_pelicula",
              "fecha_pelicula",
              "genero_pelicula",
              "id_director",
          ]);

        /*if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'index'
            ]);

            return;
        }*/

        /*$pelicula = new Peliculas();
        $pelicula->nombrePelicula = $this->request->getPost("nombre_pelicula");
        $pelicula->añoPelicula = $this->request->getPost("fecha_pelicula");
        $pelicula->generoPelicula = $this->request->getPost("genero_pelicula");
        $pelicula->idDirector = $this->request->getPost("id_director");
        

        if (!$pelicula->save()) {
            foreach ($pelicula->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'new'
            ]);

            return;
        }*/

        if ($success) {
            $this->flash->success("Pelicula fue creada correctamente");
            $this->dispatcher->forward([
            'controller' => "peliculas",
            'action' => 'search'
            ]); 
        } else{
            $this->flash->success("Pelicula no pudo ser creada correctamente");
            $this->dispatcher->forward([
            'controller' => "peliculas",
            'action' => 'search'
            ]); 
        }

        
    }

    /**
     * Saves a pelicula edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'index'
            ]);

            return;
        }

        $id_pelicula = $this->request->getPost("id_pelicula");
        $pelicula = Peliculas::findFirstByid_pelicula($id_pelicula);

        if (!$pelicula) {
            $this->flash->error("pelicula does not exist " . $id_pelicula);

            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'index'
            ]);

            return;
        }

        //$pelicula->nombrePelicula = $this->request->getPost("nombre_pelicula");
        //$pelicula->añoPelicula = $this->request->getPost("fecha_pelicula");
        //$pelicula->generoPelicula = $this->request->getPost("genero_pelicula");
        //$pelicula->idDirector = $this->request->getPost("id_director");
        

        /*if (!$pelicula->save()) {

            foreach ($pelicula->getMessages() as $message) {
                $this->flash->error($message);
            }*/


          $peliculas = new Peliculas();
      // Almacenar y comprobar errores
      $success = $peliculas->save(
          $this->request->getPost(),
          [
              "nombre_pelicula",
              "fecha_pelicula",
              "genero_pelicula",
              "id_director",
          ]);
  

    if ($success) {
        $this->flash->success("Pelicula modificada correctamente");
        $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'edit',
                'params' => [$pelicula->id_pelicula]
            ]);
    }else{
        $this->flash->success("Pelicula no pudo ser modificada");
        $this->dispatcher->forward([
            'controller' => "peliculas",
            'action' => 'index'
        ]);
        }
    }

    /**
     * Deletes a pelicula
     *
     * @param string $id_pelicula
     */
    public function deleteAction($id_pelicula)
    {
        $pelicula = Peliculas::findFirstByid_pelicula($id_pelicula);
        if (!$pelicula) {
            $this->flash->error("pelicula was not found");

            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'index'
            ]);

            return;
        }

        if (!$pelicula->delete()) {
            foreach ($pelicula->getMessages() as $message) {
                $this->flash->error($message);
            }
            $this->dispatcher->forward([
                'controller' => "peliculas",
                'action' => 'search'
            ]);

            return;
        }
        $this->flash->success("pelicula was deleted successfully");
        $this->dispatcher->forward([
            'controller' => "peliculas",
            'action' => "index"
        ]);
    }

}

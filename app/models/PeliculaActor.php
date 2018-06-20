<?php

class PeliculaActor extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id_pelicula;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id_actor;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tiendapeliculas");
        $this->setSource("pelicula_actor");
        $this->belongsTo('id_pelicula', '\Peliculas', 'id_pelicula', ['alias' => 'Peliculas']);
        $this->belongsTo('id_actor', '\Actor', 'id_actor', ['alias' => 'Actor']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'pelicula_actor';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return PeliculaActor[]|PeliculaActor|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return PeliculaActor|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}

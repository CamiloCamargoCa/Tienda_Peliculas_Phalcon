<?php

class Peliculas extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id_pelicula;

    /**
     *
     * @var string
     * @Column(type="string", length=70, nullable=true)
     */
    public $nombre_pelicula;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $fecha_pelicula;

    /**
     *
     * @var string
     * @Column(type="string", length=30, nullable=true)
     */
    public $genero_pelicula;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id_director;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tiendapeliculas");
        $this->setSource("peliculas");
        $this->hasMany('id_pelicula', 'PeliculaActor', 'id_pelicula', ['alias' => 'PeliculaActor']);
        $this->belongsTo('id_director', '\Director', 'id_director', ['alias' => 'Director']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'peliculas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Peliculas[]|Peliculas|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Peliculas|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}

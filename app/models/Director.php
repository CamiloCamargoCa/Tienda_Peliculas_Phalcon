<?php

class Director extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id_director;

    /**
     *
     * @var string
     * @Column(type="string", length=70, nullable=true)
     */
    public $nombre_director;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $fecha_nacimiento;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("tiendapeliculas");
        $this->setSource("director");
        $this->hasMany('id_director', 'Peliculas', 'id_director', ['alias' => 'Peliculas']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'director';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Director[]|Director|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Director|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}

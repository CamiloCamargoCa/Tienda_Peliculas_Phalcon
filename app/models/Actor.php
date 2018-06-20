<?php

class Actor extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id_actor;

    /**
     *
     * @var string
     * @Column(type="string", length=70, nullable=true)
     */
    public $nombre_actor;

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
        $this->setSource("actor");
        $this->hasMany('id_actor', 'PeliculaActor', 'id_actor', ['alias' => 'PeliculaActor']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'actor';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Actor[]|Actor|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Actor|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
